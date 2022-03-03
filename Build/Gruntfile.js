const sass = require('node-sass');

module.exports = function(grunt) {
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

        // TODO: move uglify to terser
        uglify: {
            options: {
                banner: '/*! <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd") %> */\n',
                output: {
                    comments: false
                }
            },
            AllEdgesElement: {
                src: '<%= paths.js_source %>FormEngine/Element/AllEdgesElement.js',
                dest: '<%= paths.js %>FormEngine/Element/AllEdgesElement.js'
            },
            BootstrapBorderElement: {
                src: '<%= paths.js_source %>FormEngine/Element/BootstrapBorderElement.js',
                dest: '<%= paths.js %>FormEngine/Element/BootstrapBorderElement.js'
            },
            BootstrapDevicesElement: {
                src: '<%= paths.js_source %>FormEngine/Element/BootstrapDevicesElement.js',
                dest: '<%= paths.js %>FormEngine/Element/BootstrapDevicesElement.js'
            },
            BootstrapIconsElement: {
                src: '<%= paths.js_source %>FormEngine/Element/BootstrapIconsElement.js',
                dest: '<%= paths.js %>FormEngine/Element/BootstrapIconsElement.js'
            }
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
        exec: {
            ts: ((process.platform === 'win32') ? 'node_modules\\.bin\\tsc.cmd' : './node_modules/.bin/tsc') + ' --project tsconfig.json'
        },
        watch: {
            // JavaScript
            AllEdgesElement: {
                files: '<%= paths.js_source %>FormEngine/Element/AllEdgesElement.js',
                tasks: 'uglify:AllEdgesElement'
            },
            BootstrapBorderElement: {
                files: '<%= paths.js_source %>FormEngine/Element/BootstrapBorderElement.js',
                tasks: 'uglify:BootstrapBorderElement'
            },
            BootstrapDevicesElement: {
                files: '<%= paths.js_source %>FormEngine/Element/BootstrapDevicesElement.js',
                tasks: 'uglify:BootstrapDevicesElement'
            },
            BootstrapIconsElement: {
                files: '<%= paths.js_source %>FormEngine/Element/BootstrapIconsElement.js',
                tasks: 'uglify:BootstrapIconsElement'
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
     * Register tasks
     */
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-terser');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-sass');
    grunt.loadNpmTasks('grunt-eslint');
    grunt.loadNpmTasks('grunt-stylelint');
    grunt.loadNpmTasks('grunt-lintspaces');
    grunt.loadNpmTasks('grunt-exec');

    grunt.registerTask('compile-typescript', ['eslint', 'exec:ts', 'terser:typescript']);
    grunt.registerTask('css', ['formatsass', 'sass', 'rebase', 'cssmin']);
    grunt.registerTask('js', ['uglify']);
    grunt.registerTask('lint', ['eslint', 'stylelint', 'lintspaces']);
    grunt.registerTask('build', ['css', 'js', 'compile-typescript', 'copy']);
    grunt.registerTask('default', ['build']);
};