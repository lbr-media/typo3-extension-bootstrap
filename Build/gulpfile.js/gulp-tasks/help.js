'use strict';

/**
 * Task to show some help.
 */
module.exports = (gulp, plugins, ENV, config) => {
    return (cb) => {
        return new Promise(function (resolve, reject) {
            console.log('Available tasks:');
            console.log(plugins.color('Stylesheets:', 'CYAN'));
            console.log(plugins.color('gulp scss             ', 'CYAN') + 'Build css from scss');
            console.log(plugins.color('gulp scss:watch       ', 'CYAN') + 'Watch scss-files and build on changes');
            console.log('');
            console.log(plugins.color('TypeScript:', 'CYAN'));
            console.log(plugins.color('gulp ts               ', 'CYAN') + 'Bundles and minifies typescript');
            console.log(plugins.color('gulp ts:watch         ', 'CYAN') + 'Watch ts-files and build on changes');
            console.log('');
            console.log(plugins.color('JavaScript:', 'CYAN'));
            console.log(plugins.color('gulp js               ', 'CYAN') + 'Minifies js');
            console.log(plugins.color('gulp js:watch         ', 'CYAN') + 'Watch js-files and build on changes');
            console.log(plugins.color('gulp js:bundle        ', 'CYAN') + 'Merges and minifies some js files to one file');
            console.log('');
            console.log(plugins.color('Assets/Cleanup:', 'CYAN'));
            console.log(plugins.color('gulp cleanup          ', 'CYAN') + 'Removes some built folders/files');
            console.log(plugins.color('gulp assets           ', 'CYAN') + 'Copies some folders/files');
            console.log(plugins.color('gulp assets:fileadmin ', 'CYAN') + 'Copies some folders/files to fileadmin/bootstrap/');
            console.log('');
            console.log(plugins.color('Linting:', 'CYAN'));
            console.log(plugins.color('gulp eslint           ', 'CYAN') + 'Lint TS files');
            console.log(plugins.color('gulp stylelint        ', 'CYAN') + 'Lint CSS files');
            console.log(plugins.color('gulp lintspaces       ', 'CYAN') + 'Lint spaces (also outside Build folder)');
            console.log(plugins.color('gulp lint             ', 'CYAN') + 'Process eslint, stylelint and lint at once');
            console.log('');
            console.log(plugins.color('Build:', 'CYAN'));
            console.log(plugins.color('gulp build            ', 'CYAN') + 'Do the stuff above: cleanup, scss, ts, js, js:bundle, assets and assets:fileadmin');
            console.log('');
            console.log(plugins.color('Watch:', 'CYAN'));
            console.log(plugins.color('gulp watch:js:scss    ', 'CYAN') + 'Watch js and scss at once');
            console.log(plugins.color('gulp watch:all        ', 'CYAN') + 'Watch js, ts and scss at once');
            console.log('');
            console.log('... call them either with:');
            console.log(plugins.color('--production', 'CYAN') + ' (default)');
            console.log(plugins.color('--staging', 'CYAN'));
            console.log(plugins.color('--development', 'CYAN'));
            console.log('');
            console.log('... call them with ' + plugins.color('--sourcemaps', 'CYAN') + ' to build them.');
            console.log('');

            resolve();
        });
    }
};
