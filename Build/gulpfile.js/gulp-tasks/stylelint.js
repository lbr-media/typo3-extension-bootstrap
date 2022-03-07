'use strict';

const gulpStylelint = require('gulp-stylelint');

/**
 * Task to linting ts
 */
module.exports = (gulp, plugins, ENV, config) => {
    return (cb) => {
        return gulp
            .src(config.stylelint.files.src)
            .pipe(gulpStylelint(config.stylelint.options));
    };
};
