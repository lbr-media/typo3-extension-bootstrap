'use strict';

const babel = require('gulp-babel');
const sourcemaps = require('gulp-sourcemaps');
const header = require('gulp-header');

/**
 * Task to minify and bundle some js files.
 */
module.exports = (gulp, plugins, ENV, config) => {
    return (cb) => {
        let mergedStreams = require('merge-stream')();

        config.js.bundles.forEach((bundle) => {
            console.log(
                plugins.color('js:bundle: Bundle ', 'BLUE') +
                    plugins.color(bundle.sources.length, 'CYAN') +
                    plugins.color(' files to ', 'BLUE') +
                    plugins.color(bundle.destination + bundle.outputFile, 'CYAN')
            );

            if (ENV.sourcemaps) {
                var stream = gulp
                    .src(bundle.sources)
                    .pipe(plugins.concat(bundle.outputFile))
                    .pipe(sourcemaps.init())
                    .pipe(babel(config.babel))
                    .pipe(ENV.mode.production(plugins.terser()))
                    .pipe(ENV.mode.staging(plugins.terser()))
                    .pipe(sourcemaps.write('./'))
                    .pipe(header(config.header.banner, { pkg: config.pkg, date: config.date} ))
                    .pipe(gulp.dest(bundle.destination));
            } else {
                var stream = gulp
                    .src(bundle.sources)
                    .pipe(plugins.concat(bundle.outputFile))
                    .pipe(babel(config.babel))
                    .pipe(ENV.mode.production(plugins.terser()))
                    .pipe(ENV.mode.staging(plugins.terser()))
                    .pipe(header(config.header.banner, { pkg: config.pkg, date: config.date} ))
                    .pipe(gulp.dest(bundle.destination));
            }

            mergedStreams.add(stream);
        });

        return mergedStreams.isEmpty() ? cb() : mergedStreams;
    };
};
