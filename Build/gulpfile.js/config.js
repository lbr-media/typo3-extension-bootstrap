'use strict';

/**
 * Configuration of all paths, patterns, etc for the used tasks.
 */

const paths = {
    root: '../',
    node: './node_modules/',
    css: {
        src: './Sources/Sass/',
        dist: '../Resources/Public/Stylesheets/'
    },
    js: {
        src: './Sources/JavaScript/',
        dist: '../Resources/Public/JavaScript/' // same as 'ts'. Be sure not overwriting built ts.
    },
    ts: {
        src: './Sources/TypeScript/',
        dist: '../Resources/Public/JavaScript/' // same as 'js'. Be sure not overwriting built js.
    },
};

var pkg = require('../package.json');

paths.fileadmin =  '../../../../fileadmin/',
paths.fileadmin_bootstrap =  paths.fileadmin + 'bootstrap/',
paths.fileadmin_bootstrap_js =  paths.fileadmin_bootstrap + 'assets/js/',
paths.fileadmin_bootstrap_css =  paths.fileadmin_bootstrap + 'assets/css/',

module.exports = (ENV) => {
    return {
        pkg: pkg,
        date: new Date(),

        header: {
            banner: [
                '/**',
                ' * @package <%= pkg.name %> - <%= pkg.description %>',
                ' * @version <%= pkg.version %>',
                ' * @author <%= pkg.author.name %> <<%= pkg.author.email %>>',
                ' * @date <%= date.toUTCString() %>',
                ' * @copyright <%= date.getFullYear() %> <%= pkg.author.company %>',
                ' * @link <%= pkg.homepage %>',
                ' * @license <%= pkg.license %>',
                ' */',
                ''
            ].join('\n')
        },

        // generate css from scss + autoprefixer
        styles: {
            watchSource: paths.css.src + '**/*.scss',
            generateSourcemap: false,
            files: {
                [paths.css.src + 'Backend/FormElements.scss']: paths.css.dist + 'Backend/',
                [paths.css.src + 'CKEditor/CKEditor.scss']: paths.css.dist + 'CKEditor/',
                [paths.css.src + 'Frontend/error-page.scss']: paths.css.dist + 'Frontend/',
                [paths.css.src + 'Frontend/Elements/figure-copyright.scss']: paths.css.dist + 'Frontend/Elements/',
                [paths.css.src + 'Frontend/Elements/iconset.scss']: paths.css.dist + 'Frontend/Elements/',
                [paths.css.src + 'Frontend/ContentElement/bootstrap_alert.scss']: paths.css.dist + 'Frontend/ContentElement/',
                [paths.css.src + 'Frontend/ContentElement/bootstrap_textmediafloat.scss']: paths.css.dist + 'Frontend/ContentElement/',
                [paths.css.src + 'Frontend/ContentElement/bootstrap_markdown.scss']: paths.css.dist + 'Frontend/ContentElement/',
            },
        },

        // bundle and minify single ts files
        ts: {
            tsConfig: {
                "noImplicitAny": true,
                "target": "es2017"
            },
            watchSource: paths.ts.src + '**/*.ts',
            files: {
                [paths.ts.src + 'SvgError.ts']: paths.ts.dist,
            },
        },

        js: {
            // minify single js files
            watchSource: paths.js.src + '**/*.js',
            files: {
                [paths.js.src + 'App.js']: paths.js.dist,
                [paths.js.src + 'FormEngine/Element/AllEdgesElement.js']: paths.js.dist + 'FormEngine/Element/',
                [paths.js.src + 'FormEngine/Element/BootstrapBorderElement.js']: paths.js.dist + 'FormEngine/Element/',
                [paths.js.src + 'FormEngine/Element/BootstrapDevicesElement.js']: paths.js.dist + 'FormEngine/Element/',
                [paths.js.src + 'FormEngine/Element/BootstrapIconsElement.js']: paths.js.dist + 'FormEngine/Element/',
            },

            // bundle and minify a group of files to one file
            bundles: [
                // collection 1 to be processed: Polyfills.js
                {
                    // source js files to be merged and minified:
                    sources: [
                        paths.js.src + 'Polyfills/picturefill.ie.js',
                        paths.js.src + 'Polyfills/Promise.js',
                        paths.js.src + 'Polyfills/forEach.js',
                        paths.js.src + 'Polyfills/find.js',
                    ],
                    destination: paths.js.dist, // target folder
                    outputFile: 'Polyfills.js', // name of the generated file
                },
            ],
        },

        // assets which should be 'cleanup'
        cleanup: [
            paths.css.dist + '**',
            paths.js.dist + '**',
        ],

        // assets to copy
        assets: {
            [paths.node + 'picturefill/dist/picturefill.min.js']: paths.js.dist + 'lib/',
            [paths.node + 'masonry-layout/dist/masonry.pkgd.min.js']: paths.js.dist + 'lib/',
            [paths.node + 'imagesloaded/imagesloaded.pkgd.min.js']: paths.js.dist + 'lib/',

        },

        // assets to copy to fileadmin/bootstrap/
        assets_fileadmin: {
            // lib
            [paths.js.dist + 'lib/picturefill.min.js']: paths.fileadmin_bootstrap_js,
            [paths.js.dist + 'lib//masonry.pkgd.min.js']: paths.fileadmin_bootstrap_js,
            [paths.js.dist + 'lib/imagesloaded.pkgd.min.js']: paths.fileadmin_bootstrap_js,

            // js
            [paths.js.dist + 'App.js']: paths.fileadmin_bootstrap_js,
            [paths.js.dist + 'Polyfills.js']: paths.fileadmin_bootstrap_js,
            [paths.js.dist + 'SvgError.js']: paths.fileadmin_bootstrap_js,

            // css
            [paths.css.dist + 'CKEditor/CKEditor.css']: paths.fileadmin_bootstrap_css,
            [paths.css.dist + 'Frontend/error-page.css']: paths.fileadmin_bootstrap_css,
            [paths.css.dist + 'Frontend/Elements/figure-copyright.css']: paths.fileadmin_bootstrap_css,
            [paths.css.dist + 'Frontend/Elements/iconset.css']: paths.fileadmin_bootstrap_css,
            [paths.css.dist + 'Frontend/ContentElement/bootstrap_alert.css']: paths.fileadmin_bootstrap_css,
            [paths.css.dist + 'Frontend/ContentElement/bootstrap_textmediafloat.css']: paths.fileadmin_bootstrap_css,
            [paths.css.dist + 'Frontend/ContentElement/bootstrap_markdown.css']: paths.fileadmin_bootstrap_css,
        },

        eslint: {
            options: {
                configFile: 'eslintrc.json',
                cache: true,
                cacheLocation: './.cache/eslintcache/'
            },
            files: {
                src: [
                    paths.ts.src + '**/*.ts',
                ]
            }
        },

        stylelint: {
            options: {
                customSyntax: require("postcss-scss"),
                configFile: paths.root + '.stylelintrc',
                reporters: [
                    { formatter: 'verbose', console: true }
                ],
                fix: true,
            },
            files: {
                src: [
                    paths.css.src + '**/*.scss',
                ]
            }
        },

        lintspaces: {
            options: {
                editorconfig: paths.root + '.editorconfig'
            },
            files: {
                src: [
                    // html
                    paths.root + 'Resources/Private/**/*.html',
                    paths.root + 'Resources/Public/*.html',

                    // xlf
                    paths.root + 'Resources/Private/Language/**/*.xlf',

                    // typoscript
                    paths.root + 'Configuration/**/*.typoscript',
                ]
            },
        },

        // configuration for babel(...)
        babel: {
            presets: [
                [
                    '@babel/env',
                    {
                        modules: false,
                    },
                ],
            ],
        },
    };
};
