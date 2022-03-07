'use strict';

// stuff for ts
const browserify = require('browserify');
const source = require('vinyl-source-stream');
const tsify = require('tsify');
const terser = require('gulp-terser');
const sourcemaps = require('gulp-sourcemaps');
const buffer = require('vinyl-buffer');
const babel = require('gulp-babel');
const header = require('gulp-header');

/**
 * Task to bundle and minify/terser js files.
 */
module.exports = (gulp, plugins, ENV, config) => {
    return () => {
        var mergedStreams = require('merge-stream')();

        for (var key in config.ts.files) {
            // create target filename
            let pathParts = key.split('/');
            let targetFilename = pathParts[pathParts.length - 1].replace('.ts', '.js');

            // inform the user
            console.log(
                plugins.color('ts -> bundle -> terser: ', 'BLUE') + plugins.color(key, 'CYAN')
            );
            console.log(
                plugins.color('                    to: ', 'BLUE') +
                    plugins.color(config.ts.files[key] + targetFilename, 'CYAN')
            );

            if (ENV.sourcemaps) {
                var stream = browserify()
                    .add(key)
                    .plugin(tsify, config.ts.tsConfig)
                    .bundle()
                    .on('error', function (error) {
                        console.error(error.toString());
                    })
                    .pipe(source(targetFilename))
                    .pipe(buffer())
                    .pipe(sourcemaps.init())
                    .pipe(babel(config.babel))
                    .pipe(ENV.mode.production(plugins.terser()))
                    .pipe(ENV.mode.staging(plugins.terser()))
                    .pipe(sourcemaps.write('./'))
                    .pipe(header(config.header.banner, { pkg: config.pkg, date: config.date} ))
                    .pipe(gulp.dest(config.ts.files[key]));
            } else {
                var stream = browserify()
                    .add(key)
                    .plugin(tsify, config.ts.tsConfig)
                    .bundle()
                    .on('error', function (error) {
                        console.error(error.toString());
                    })
                    .pipe(source(targetFilename))
                    .pipe(buffer())
                    .pipe(babel(config.babel))
                    .pipe(ENV.mode.production(plugins.terser()))
                    .pipe(ENV.mode.staging(plugins.terser()))
                    .pipe(header(config.header.banner, { pkg: config.pkg, date: config.date} ))
                    .pipe(gulp.dest(config.ts.files[key]));
            }

            mergedStreams.add(stream);
        }

        return mergedStreams.isEmpty() ? null : mergedStreams;
    };
};
