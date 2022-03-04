

module.exports = function (grunt) {
    const sass = require('node-sass');

    // Project configuration.
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        paths: {
            root: '../',
            node: 'node_modules/',
            sources: './Sources/',
            resources: '<%= paths.root %>Resources/',
            sass: '<%= paths.sources %>Sass/',
            css: '<%= paths.resources %>Public/Stylesheets/',
            js_source: '<%= paths.sources %>JavaScript/',
            typescript: '<%= paths.sources %>TypeScript/',
            js: '<%= paths.resources %>Public/JavaScript/'
        },
        clean: {
            build: [
                '.cache',
            ],
            css: [
                '<%= paths.css %>Backend/FormElements.css',
                '<%= paths.css %>Backend/FormElements.min.css',
                '<%= paths.css %>CKEditor/CKEditor.css',
                '<%= paths.css %>CKEditor/CKEditor.min.css',
                '<%= paths.css %>Frontend/error-page.css',
                '<%= paths.css %>Frontend/error-page.min.css',
                '<%= paths.css %>Frontend/Elements/figure-copyright.css',
                '<%= paths.css %>Frontend/Elements/figure-copyright.min.css',
                '<%= paths.css %>Frontend/Elements/iconset.css',
                '<%= paths.css %>Frontend/Elements/iconset.min.css',
                '<%= paths.css %>Frontend/ContentElement/bootstrap_alert.css',
                '<%= paths.css %>Frontend/ContentElement/bootstrap_alert.min.css',
                '<%= paths.css %>Frontend/ContentElement/bootstrap_textmediafloat.css',
                '<%= paths.css %>Frontend/ContentElement/bootstrap_textmediafloat.min.css',
            ],
            typescript: [
                '<%= paths.js %>SvgError.js',
                '<%= paths.js %>SvgError.min.js',
            ],
            javascript: [
                '<%= paths.js %>FormEngine/Element/AllEdgesElement.js',
                '<%= paths.js %>FormEngine/Element/BootstrapBorderElement.js',
                '<%= paths.js %>FormEngine/Element/BootstrapDevicesElement.js',
                '<%= paths.js %>FormEngine/Element/BootstrapIconsElement.js',
            ],
            copy: [
                '<%= paths.js %>lib/masonry.pkgd.min.js',
            ],
        },
        banner: '/**\n' +
            ' * Package: <%= pkg.name %> - Version <%= pkg.version %>\n' +
            ' * <%= pkg.description %>\n' +
            ' * Author: <%= pkg.author.name %> <<%= pkg.author.email %>>\n' +
            ' * Build date: <%= grunt.template.today("yyyy-mm-dd HH:MM:ss") %>\n' +
            ' * Copyright (c) <%= grunt.template.today("yyyy") %> <%= pkg.author.company %>\n' +
            ' * Released under the <%= pkg.license %> license\n' +
            ' * https://github.com/lbr-media/typo3-extension-bootstrap\n' +
            ' */\n',
        usebanner: {
            options: {
                position: 'top',
                banner: '<%= banner %>',
                linebreak: true
            },
            css: {
                files: {
                    src: [
                        '<%= paths.css %>Backend/FormElements.css',
                        '<%= paths.css %>Backend/FormElements.min.css',
                        '<%= paths.css %>CKEditor/CKEditor.css',
                        '<%= paths.css %>CKEditor/CKEditor.min.css',
                        '<%= paths.css %>Frontend/error-page.css',
                        '<%= paths.css %>Frontend/error-page.min.css',
                        '<%= paths.css %>Frontend/Elements/figure-copyright.css',
                        '<%= paths.css %>Frontend/Elements/figure-copyright.min.css',
                        '<%= paths.css %>Frontend/Elements/iconset.css',
                        '<%= paths.css %>Frontend/Elements/iconset.min.css',
                        '<%= paths.css %>Frontend/ContentElement/bootstrap_alert.css',
                        '<%= paths.css %>Frontend/ContentElement/bootstrap_alert.min.css',
                        '<%= paths.css %>Frontend/ContentElement/bootstrap_textmediafloat.css',
                        '<%= paths.css %>Frontend/ContentElement/bootstrap_textmediafloat.min.css',
                    ]
                }
            },
            typescript: {
                files: {
                    src: [
                        // '<%= paths.js %>SvgError.js',
                        '<%= paths.js %>SvgError.min.js',
                    ]
                }
            },
            javascript: {
                files: {
                    src: [
                        '<%= paths.js %>FormEngine/Element/AllEdgesElement.js',
                        '<%= paths.js %>FormEngine/Element/BootstrapBorderElement.js',
                        '<%= paths.js %>FormEngine/Element/BootstrapDevicesElement.js',
                        '<%= paths.js %>FormEngine/Element/BootstrapIconsElement.js',
                    ]
                }
            },
        },
        rebase: {
            error_page: {
                options: {
                    url: "rebase",
                    assetsPath: '../'
                },
                files: {
                    '<%= paths.css %>Frontend/error-page.css': '<%= paths.css %>Frontend/error-page.css'
                }
            },
        },
        formatsass: {
            sass: {
                files: [{
                    expand: true,
                    cwd: '<%= paths.sass %>',
                    src: ['**/*.scss'],
                    dest: '<%= paths.sass %>'
                }]
            }
        },
        cssmin: {
            options: {
                keepSpecialComments: '*',
                advanced: false
            },
            FormElements: {
                src: '<%= paths.css %>Backend/FormElements.css',
                dest: '<%= paths.css %>Backend/FormElements.min.css'
            },
            CKEditor: {
                src: '<%= paths.css %>CKEditor/CKEditor.css',
                dest: '<%= paths.css %>CKEditor/CKEditor.min.css'
            },
            error_page: {
                src: '<%= paths.css %>Frontend/error-page.css',
                dest: '<%= paths.css %>Frontend/error-page.min.css'
            },
            figure_copyright: {
                src: '<%= paths.css %>Frontend/Elements/figure-copyright.css',
                dest: '<%= paths.css %>Frontend/Elements/figure-copyright.min.css'
            },
            iconset: {
                src: '<%= paths.css %>Frontend/Elements/iconset.css',
                dest: '<%= paths.css %>Frontend/Elements/iconset.min.css'
            },
            ce_bootstrap_alert: {
                src: '<%= paths.css %>Frontend/ContentElement/bootstrap_alert.css',
                dest: '<%= paths.css %>Frontend/ContentElement/bootstrap_alert.min.css'
            },
            ce_bootstrap_textmediafloat: {
                src: '<%= paths.css %>Frontend/ContentElement/bootstrap_textmediafloat.css',
                dest: '<%= paths.css %>Frontend/ContentElement/bootstrap_textmediafloat.min.css'
            }
        },
        sass: {
            options: {
                implementation: sass,
                outputStyle: 'expanded',
                precision: 8,
                sourceMap: false
            },
            FormElements: {
                files: {
                    '<%= paths.css %>Backend/FormElements.css': '<%= paths.sass %>Backend/FormElements.scss',
                }
            },
            CKEditor: {
                files: {
                    '<%= paths.css %>CKEditor/CKEditor.css': '<%= paths.sass %>CKEditor/CKEditor.scss',
                }
            },
            error_page: {
                files: {
                    '<%= paths.css %>Frontend/error-page.css': '<%= paths.sass %>Frontend/error-page.scss',
                }
            },
            figure_copyright: {
                files: {
                    '<%= paths.css %>Frontend/Elements/figure-copyright.css': '<%= paths.sass %>Frontend/Elements/figure-copyright.scss'
                }
            },
            iconset: {
                files: {
                    '<%= paths.css %>Frontend/Elements/iconset.css': '<%= paths.sass %>Frontend/Elements/iconset.scss'
                }
            },
            ce_bootstrap_alert: {
                files: {
                    '<%= paths.css %>Frontend/ContentElement/bootstrap_alert.css': '<%= paths.sass %>Frontend/ContentElement/bootstrap_alert.scss'
                }
            },
            ce_bootstrap_textmediafloat: {
                files: {
                    '<%= paths.css %>Frontend/ContentElement/bootstrap_textmediafloat.css': '<%= paths.sass %>Frontend/ContentElement/bootstrap_textmediafloat.scss'
                }
            }
        },
        eslint: {
            options: {
                cache: true,
                cacheLocation: './.cache/eslintcache/',
                overrideConfigFile: 'eslintrc.json'
            },
            files: {
                src: [
                    '<%= paths.typescript %>/**/*.ts',
                ]
            }
        },
        stylelint: {
            options: {
                customSyntax: require("postcss-scss"),
                configFile: '<%= paths.root %>.stylelintrc',
                fix: true,
            },
            sass: ['<%= paths.sass %>**/*.scss'],
        },
        lintspaces: {
            options: {
                editorconfig: '<%= paths.root %>.editorconfig'
            },
            html: {
                src: [
                    '<%= paths.root %>/Resources/Private/**/*.html',
                    '<%= paths.root %>/Resources/Public/*.html'
                ]
            },
            xlf: {
                src: [
                    '<%= paths.root %>/Resources/Private/Language/**/*.xlf',
                ]
            },
            typoscript: {
                src: [
                    '../Configuration/**/*.typoscript',
                ]
            }
        },
        exec: {
            ts: ((process.platform === 'win32') ? 'node_modules\\.bin\\tsc.cmd' : './node_modules/.bin/tsc') + ' --project tsconfig.json'
        },
        watch: {
            // JavaScript
            AllEdgesElement: {
                files: '<%= paths.js_source %>FormEngine/Element/AllEdgesElement.js',
                tasks: ['terser:javascript','newer:usebanner:javascript']
            },
            BootstrapBorderElement: {
                files: '<%= paths.js_source %>FormEngine/Element/BootstrapBorderElement.js',
                tasks: ['terser:javascript','newer:usebanner:javascript']
            },
            BootstrapDevicesElement: {
                files: '<%= paths.js_source %>FormEngine/Element/BootstrapDevicesElement.js',
                tasks: ['terser:javascript','newer:usebanner:javascript']
            },
            BootstrapIconsElement: {
                files: '<%= paths.js_source %>FormEngine/Element/BootstrapIconsElement.js',
                tasks: ['terser:javascript','newer:usebanner:javascript']
            },

            // SCSS
            scss: {
                files: '<%= paths.scss %>**/*.scss',
                tasks: 'css'
            },

            // TypeScript
            typescript: {
                files: '<%= paths.typescript %>**/*.ts',
                tasks: 'compile-typescript'
            }
        },
        copy: {
            masonry: {
                files: [
                    {
                        cwd: '<%= paths.node %>masonry-layout/dist/',
                        src: 'masonry.pkgd.min.js',
                        dest: '<%= paths.js %>lib/',
                        expand: true
                    }
                ]
            }
        },
        terser: {
            options: {
                output: {
                    ecma: 8
                }
            },
            typescript: {
                files: {
                    '<%= paths.js %>SvgError.min.js': ['<%= paths.js %>SvgError.js'],
                }
            },
            javascript: {
                files: {
                    '<%= paths.js %>FormEngine/Element/AllEdgesElement.js': ['<%= paths.js_source %>FormEngine/Element/AllEdgesElement.js'],
                    '<%= paths.js %>FormEngine/Element/BootstrapBorderElement.js': ['<%= paths.js_source %>FormEngine/Element/BootstrapBorderElement.js'],
                    '<%= paths.js %>FormEngine/Element/BootstrapDevicesElement.js': ['<%= paths.js_source %>FormEngine/Element/BootstrapDevicesElement.js'],
                    '<%= paths.js %>FormEngine/Element/BootstrapIconsElement.js': ['<%= paths.js_source %>FormEngine/Element/BootstrapIconsElement.js'],
                }
            },
        }
    });

    /**
     * Grunt correct scss urls
     */
    grunt.registerMultiTask('rebase', 'Grunt task to rebase urls after sass processing', function () {
        var options = this.options(),
            done = this.async(),
            postcss = require('postcss'),
            url = require('postcss-url'),
            files = this.filesSrc.filter(function (file) {
                return grunt.file.isFile(file);
            }),
            counter = 0;
        this.files.forEach(function (file) {
            file.src.filter(function (filepath) {
                var content = grunt.file.read(filepath);
                postcss().use(url(options)).process(content, { from: undefined }).then(function (result) {
                    grunt.file.write(file.dest, result.css);
                    grunt.log.success('Source file "' + filepath + '" was processed.');
                    counter++;
                    if (counter >= files.length) done(true);
                });
            });
        });
    });

    /**
     * Grunt stylefmt task
     */
    grunt.registerMultiTask('formatsass', 'Grunt task for stylefmt', function () {
        var options = this.options(),
            done = this.async(),
            stylefmt = require('stylefmt'),
            scss = require('postcss-scss'),
            files = this.filesSrc.filter(function (file) {
                return grunt.file.isFile(file);
            }),
            counter = 0;

        this.files.forEach(function (file) {
            file.src.filter(function (filepath) {
                var content = grunt.file.read(filepath);
                var settings = {
                    from: filepath,
                    syntax: scss
                };
                stylefmt.process(content, settings).then(function (result) {
                    grunt.file.write(file.dest, result.css);
                    grunt.log.success('Source file "' + filepath + '" was processed.');
                    counter++;
                    if (counter >= files.length) done(true);
                });
            });
        });
    });

    /**
     * Register grunt tasks
     */
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.loadNpmTasks('grunt-terser');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-sass');
    grunt.loadNpmTasks('grunt-eslint');
    grunt.loadNpmTasks('grunt-stylelint');
    grunt.loadNpmTasks('grunt-lintspaces');
    grunt.loadNpmTasks('grunt-exec');
    grunt.loadNpmTasks('grunt-newer');
    grunt.loadNpmTasks('grunt-banner');

    /**
     * Register main tasks
     */
    // typescript
    grunt.registerTask('compile-typescript', ['eslint', 'exec:ts', 'terser:typescript','newer:usebanner:typescript']);

    // javascript
    grunt.registerTask('js', ['terser:javascript','newer:usebanner:javascript']);

    // stylesheets
    grunt.registerTask('css', ['formatsass', 'newer:sass', 'newer:rebase', 'newer:cssmin', 'newer:usebanner:css']);

    // linting
    grunt.registerTask('lint', ['eslint', 'stylelint', 'lintspaces']);

    // build
    grunt.registerTask('build', ['css', 'js', 'compile-typescript', 'copy']);
    grunt.registerTask('default', ['build']);

    /**
     * Show some help about the available tasks
     */
    grunt.registerTask('help', function () {
        grunt.log.subhead('Available main tasks:');
        grunt.log.ok("grunt clean --force");
        grunt.log.writeln("   Removes the built assets in Resource/Public/...");
        grunt.log.writeln("   Sub-tasks:");
        grunt.log.writeln("   - grunt clean:build --force");
        grunt.log.writeln("   - grunt clean:css --force");
        grunt.log.writeln("   - grunt clean:javascript --force");
        grunt.log.writeln("   - grunt clean:typescript --force");
        grunt.log.writeln("   - grunt clean:copy --force");
        grunt.log.ok("grunt build");
        grunt.log.writeln("   Compile and build all the assets.");
        grunt.log.ok("grunt compile-typescript");
        grunt.log.writeln("   Compile and minify TypeScript.");
        grunt.log.ok("grunt js");
        grunt.log.writeln("   Minify JavaScript.");
        grunt.log.ok("grunt css");
        grunt.log.writeln("   Compile SASS/SCSS to CSS and minify.");
        grunt.log.ok("grunt lint");
        grunt.log.writeln("   Show lints for typescript, stylesheets and spaces");
        grunt.log.ok("grunt watch");
        grunt.log.writeln("   Watch for changes in sources and builds the assets again.");
    });
};