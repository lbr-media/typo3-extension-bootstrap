'use strict';

const eslint = require('gulp-eslint');

/**
 * Task to linting ts
 */
module.exports = (gulp, plugins, ENV, config) => {
    return (cb) => {
        return gulp.src(config.eslint.files.src)
            .pipe(eslint(config.eslint.options))
            .pipe(eslint.format())
            .pipe(eslint.failAfterError());
    };
};
