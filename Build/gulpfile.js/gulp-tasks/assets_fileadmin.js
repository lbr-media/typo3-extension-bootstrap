'use strict';

/**
 * Task to copy some files
 */
module.exports = (gulp, plugins, ENV, config) => {
    return () => {
        var mergedStreams = require('merge-stream')();

        for (var key in config.assets_fileadmin) {
            console.log(plugins.color('Copy: ', 'BLUE') + plugins.color(key, 'CYAN'));
            console.log(
                plugins.color('  to: ', 'BLUE') + plugins.color(config.assets_fileadmin[key], 'CYAN')
            );

            var stream = gulp.src(key).pipe(gulp.dest(config.assets_fileadmin[key]));

            mergedStreams.add(stream);
        }

        return mergedStreams.isEmpty() ? null : mergedStreams;
    };
};
