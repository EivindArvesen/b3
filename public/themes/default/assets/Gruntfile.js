module.exports = function(grunt) {
  grunt.initConfig({
    bspkg: grunt.file.readJSON('bower_components/bootstrap/package.json'),
    bspath: 'bower_components/bootstrap',
    banner: '/*!\n' +
            ' * Bootstrap v<%= bspkg.version %> (<%= bspkg.homepage %>)\n' +
            ' * Copyright 2011-<%= grunt.template.today("yyyy") %> <%= bspkg.author %>\n' +
            ' * Licensed under <%= bspkg.license.type %> (<%= bspkg.license.url %>)\n' +
            ' */\n',
    less: {
      compileCore: {
        options: {
          strictMath: true,
          sourceMap: true,
          outputSourceFiles: true,
          sourceMapURL: 'main.css.map',
          sourceMapFilename: 'main.css.map',
          paths: '<%= bspath %>/less'
        },
        files: {
          'main.css': 'main.less'
        },
      }

    },
    autoprefixer: {
      options: {
        browsers: [
          'Android 2.3',
          'Android >= 4',
          'Chrome >= 20',
          'Firefox >= 24', // Firefox 24 is the latest ESR
          'Explorer >= 8',
          'iOS >= 6',
          'Opera >= 12',
          'Safari >= 6'
        ]
      },
      core: {
        options: {
          map: true
        },
        src: 'main.css'
      }
    },
    cssmin: {
      options: {
        compatibility: 'ie8',
        keepSpecialComments: '*',
        noAdvanced: true
      },
      core: {
        files: {
          'main.min.css': 'main.css'
        }
      }
    },
    usebanner: {
      options: {
        position: 'top',
        banner: '<%= banner %>'
      },
      files: {
        src: 'main.css'
      }
    },
    uglify: {
        build: {
            files: {
                'jquery.min.js': ['bower_components/jquery/dist/jquery.min.js'],
                'base.min.js': ['bower_components/bootstrap/dist/js/bootstrap.min.js'],
                'main.min.js': ['main.js']
            }
        }
    },
    qunit: {
      files: ['test/**/*.html']
    },
    jshint: {
      files: ['Gruntfile.js', 'src/**/*.js', 'test/**/*.js'],
      options: {
        // options here to override JSHint defaults
        globals: {
          jQuery: true,
          console: true,
          module: true,
          document: true
        }
      }
    },
    /*
    htmlhint: {
        build: {
            options: {
                'tag-pair': true,
                'tagname-lowercase': true,
                'attr-lowercase': true,
                'attr-value-double-quotes': true,
                'doctype-first': true,
                'spec-char-escape': true,
                'id-unique': true,
                'head-script-disabled': true,
                'style-disabled': true
            },
            src: ['index.html']
        }
    },
    */
    clean: [ './dist/' ],
    copy: {
      main: {
        cwd: './',
        src: [
          '*.min.css',
          '*.min.js',
          'fonts/**/*',
          'icons/*'
        ],
        dest: './dist/',
        expand: true,
      }
    },
    replace: {
      zerocache: {
        src: ['./../views/**/*.blade.php'],
        overwrite: true,
        replacements: [{
        }, {
          from: /(min.).*(.css|.js)/g,
          to: 'min$2'
        }]
      }
    },
    cacheBust: {
        taskName: {
            options: {
                assets: [
                '*.min.css',
                '*.min.js'
                ],
                baseDir: './dist/',
                deleteOriginals: true,
                jsonOutput: true
            },
            src: ['./../views/**/*.blade.php']
        }
    },
    browserSync: {
        dev: {
            bsFiles: {
                src : [
                        'dis/*.min.css',
                        'dis/*.min.js',
                        '../views/**/*.blade.php',
                        '../../../../**/*.php',
                        '../../../**/*.html',
                        '../../../content/**/*.md'
                    ]
            },
            options: {
                open: false,
                watchTask: true,
                proxy: 'localhost'
            }
        }
    },
    watch: {
        configFiles: {
          files: [ 'Gruntfile.js', 'config/*.js' ],
          options: {
            reload: true
          }
        },
        html: {
            files: ['index.html'],
            tasks: ['htmlhint']
        },
        js: {
            files: ['main.js', 'base.min.js', 'jquery.min.js'],
            tasks: ['uglify', 'clean', 'copy', 'replace:zerocache', 'cacheBust']
        },
        less: {
            files: ['*.less'],
            tasks: ['less', 'cssmin', 'clean', 'copy', 'replace:zerocache', 'cacheBust'],
        },
    }
  });

  // Loading our grunt modules
  grunt.loadNpmTasks('grunt-autoprefixer');
  grunt.loadNpmTasks('grunt-banner');
  grunt.loadNpmTasks('grunt-cache-bust');
  grunt.loadNpmTasks('grunt-contrib-cssmin');
  grunt.loadNpmTasks('grunt-contrib-clean');
  grunt.loadNpmTasks('grunt-contrib-copy');
  grunt.loadNpmTasks('grunt-contrib-less');
  grunt.loadNpmTasks('grunt-text-replace');
  grunt.loadNpmTasks('grunt-contrib-uglify');

  grunt.loadNpmTasks('grunt-contrib-jshint');
  grunt.loadNpmTasks('grunt-contrib-qunit');

  grunt.loadNpmTasks('grunt-browser-sync');

  grunt.loadNpmTasks('grunt-contrib-watch');

  // CSS distribution task.
  // grunt.registerTask('default', ['less:compileCore', 'autoprefixer', 'usebanner', 'cssmin']);
  grunt.registerTask('default', ['less:compileCore', 'autoprefixer', 'usebanner', 'cssmin', 'uglify', 'clean', 'copy', 'replace:zerocache', 'cacheBust', 'browserSync', 'watch']);
  // grunt.registerTask('test', ['jshint', 'qunit']);
};
