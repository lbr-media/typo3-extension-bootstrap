'use strict';

const lintspaces = require("gulp-lintspaces");

/**
 * Task to linting ts
 */
module.exports = (gulp, plugins, ENV, config) => {
    return (cb) => {
        return gulp
            .src(config.lintspaces.files.src)
            .pipe(lintspaces(config.lintspaces.options))
            .pipe(lintspaces.reporter());
    };
};
