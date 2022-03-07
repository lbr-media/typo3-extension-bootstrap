'use strict';

/**
 * Call the methods in command line either with --production, --development or --staging parameter.
 * Default value is production.
 * Example: gulp scss --development
 *
 * Add '--sourcemaps' to build sourcemaps
 */

// fetch command line arguments
const arg = ((argList) => {
    let arg = {},
        a,
        opt,
        thisOpt,
        curOpt;
    for (a = 0; a < argList.length; a++) {
        thisOpt = argList[a].trim();
        opt = thisOpt.replace(/^\-+/, '');

        if (opt === thisOpt) {
            // argument value
            if (curOpt) arg[curOpt] = opt;
            curOpt = null;
        } else {
            // argument name
            curOpt = opt;
            arg[curOpt] = true;
        }
    }

    return arg;
})(process.argv);

const gulp = require('gulp');
const plugins = require('gulp-load-plugins')();

// set environment
let ENV = {
    mode: require('gulp-mode')({
        modes: ['production', 'staging', 'development'],
        default: 'production',
    }),
    context: 'production',
    sourcemaps: arg.sourcemaps || false,
};

if (ENV.mode.development()) {
    ENV.context = 'development';
} else if (ENV.mode.staging()) {
    ENV.context = 'staging';
}

// print environment message
console.log(
    plugins.color('=== Set context to ', 'BLUE') +
        plugins.color(ENV.context, 'CYAN') +
        plugins.color(' with sourcemaps ', 'BLUE') +
        plugins.color(ENV.sourcemaps ? 'enabled' : 'disabled', 'CYAN') +
        plugins.color(' ===', 'BLUE')
);

// load configuration for tasks
const config = require('./config')(ENV);

/**
 * Method to load a task dynamically.
 * @param {string} task
 */
let getTask = (task) => {
    return require('./gulp-tasks/' + task)(gulp, plugins, ENV, config);
};

// define scss tasks
gulp.task('scss', getTask('scss'));
gulp.task('scss:watch', () => {
    console.log('watch: ' + plugins.color(config.styles.watchSource, 'CYAN'));
    return gulp.watch(config.styles.watchSource, gulp.series('scss'));
});

// define typescript tasks
gulp.task('ts', getTask('ts'));
gulp.task('ts:watch', function () {
    console.log('watch: ' + plugins.color(config.ts.watchSource, 'CYAN'));
    return gulp.watch([config.ts.watchSource], gulp.series('ts'));
});

// define js single tasks
gulp.task('js', getTask('js'));
gulp.task('js:watch', () => {
    console.log('watch: ' + plugins.color(config.js.watchSource, 'CYAN'));
    return gulp.watch(config.js.watchSource, gulp.series('js'));
});

// define js merge task
gulp.task('js:bundle', getTask('js_bundle'));

// define cleanup tasks
gulp.task('cleanup', getTask('cleanup'));

// define assets task
gulp.task('assets', getTask('assets'));
gulp.task('assets:fileadmin', getTask('assets_fileadmin'));

// define linting task
gulp.task('eslint', getTask('eslint'));
gulp.task('stylelint', getTask('stylelint'));
gulp.task('lintspaces', getTask('lintspaces'));
gulp.task('lint', gulp.series('eslint', 'stylelint', 'lintspaces'));

// task to build all in once
gulp.task('build', gulp.series('cleanup', 'scss', 'ts', 'js', 'js:bundle', 'assets', 'assets:fileadmin'));

// task to watch js and scss
gulp.task('watch:js:scss', gulp.parallel('js:watch', 'scss:watch'));

// task to watch js, ts and scss
gulp.task('watch:all', gulp.parallel('js:watch', 'ts:watch', 'scss:watch'));

// default/help
gulp.task('help', getTask('help'));
gulp.task('default', gulp.series('help'));

