'use strict';

const babel = require('gulp-babel');
const sourcemaps = require('gulp-sourcemaps');
const header = require('gulp-header');

/**
 * Task to minify/uglify js files.
 */
module.exports = (gulp, plugins, ENV, config) => {
    return () => {
        // Minifies the js files
        var mergedStreams = require('merge-stream')();

        for (var key in config.js.files) {
            console.log(plugins.color('js -> minify: ', 'BLUE') + plugins.color(key, 'CYAN'));
            console.log(
                plugins.color('          to: ', 'BLUE') +
                    plugins.color(config.js.files[key], 'CYAN')
            );
            
            if (ENV.sourcemaps) {
                var stream = gulp
                    .src(key)
                    .pipe(sourcemaps.init())
                    .pipe(babel(config.babel))
                    .pipe(ENV.mode.production(plugins.terser()))
                    .pipe(ENV.mode.staging(plugins.terser()))
                    .pipe(sourcemaps.write('./'))
                    .pipe(header(config.header.banner, { pkg: config.pkg, date: config.date} ))
                    .pipe(gulp.dest(config.js.files[key]));
            } else {
                var stream = gulp
                    .src(key)
                    .pipe(babel(config.babel))
                    .pipe(ENV.mode.production(plugins.terser()))
                    .pipe(ENV.mode.staging(plugins.terser()))
                    .pipe(header(config.header.banner, { pkg: config.pkg, date: config.date} ))
                    .pipe(gulp.dest(config.js.files[key]));
            }

            mergedStreams.add(stream);
        }

        return mergedStreams.isEmpty() ? null : mergedStreams;
    };
};
