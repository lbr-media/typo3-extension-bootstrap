'use strict';

const glob = require('glob');
const del = require('del');

/**
 * Task to cleanup some folders.
 */
module.exports = (gulp, plugins, ENV, config) => {
    return (cb) => {
        let totalPromise = null;
        config.cleanup.forEach(function (pattern) {
            var filesToRemove = glob.sync(pattern);
            if (filesToRemove.length) {
                console.log(
                    plugins.color('cleanup: Remove ', 'BLUE') +
                        plugins.color(filesToRemove.length, 'CYAN') +
                        plugins.color(' files with pattern ', 'BLUE') +
                        plugins.color(pattern, 'CYAN')
                );

                let promise = Promise.resolve(del(pattern, {force: true}));
                if (promise) {
                    totalPromise = promise;
                }
            } else {
                console.log(
                    plugins.color('cleanup: Nothing to remove with pattern: ', 'BLUE') +
                        plugins.color(pattern, 'CYAN')
                );
            }
        });

        return totalPromise ? totalPromise : cb();
    };
};
