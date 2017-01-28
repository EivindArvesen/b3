var webpack = require('webpack');
module.exports = function(grunt) {
  grunt.initConfig({
    banner: '/*!\n' +
            ' * B3 Default Theme\n' +
            ' * Copyright 2016-<%= grunt.template.today("yyyy") %> Eivind Arvesen\n' +
            ' * Licensed under BSD-3 (https://opensource.org/licenses/BSD-3-Clause)\n' +
            ' */\n',
    less: {
      compileCore: {
        options: {
          strictMath: true,
          sourceMap: true,
          outputSourceFiles: true,
          sourceMapURL: 'style.css.map',
          sourceMapFilename: 'style.css.map',
        },
        files: {
          './styles/style.css': './styles/main.less'
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
        src: './styles/style.css'
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
          './styles/style.min.css': './styles/style.css'
        }
      }
    },
    usebanner: {
      options: {
        position: 'top',
        banner: '<%= banner %>'
      },
      files: {
        src: './styles/style.css'
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
    clean: {
      dist: [
        './dist/styles/*.css',
        './dist/scripts/*.js',
      ],
      dist_styles: [
        './dist/styles/*.css',
      ],
      dist_scripts: [
        './dist/scripts/*.js',
      ],
      temp: [
        './styles/*.css',
        './*.map'
      ]
    },
    copy: {
      main: {
        cwd: './',
        src: [
          'styles/*.min.css'
        ],
        dest: './dist/',
        expand: true,
      }
    },
    webpack: {
      someName: {
        // webpack options
        entry: "./scripts/main.js",
        output: {
            path: "./dist/scripts/",
            //filename: "script.min.[hash].js",
            filename: "script.min.js",
        },
        plugins: [
          new webpack.optimize.UglifyJsPlugin({minimize: true})
        ],
        stats: {
            // Configure the console output
            colors: true,
            modules: true,
            reasons: true
        },
        watch: false
      }
    },
    replace: {
      styles: {
        src: ['./../views/**/*.blade.php'],
        overwrite: true,
        replacements: [{
        }, {
          from: /(min.).*.css/g,
          to: 'min.css'
        }]
      },
      scripts: {
        src: ['./../views/**/*.blade.php'],
        overwrite: true,
        replacements: [{
        }, {
          from: /(min.).*.js/g,
          to: 'min.js'
        }]
      }
    },
    run: {
      build_content: {
        cmd: 'bash',
        args: ['./../../../../scripts/populate-db.sh']
      }
    },
    cacheBust: {
        styles: {
            options: {
                assets: [
                'styles/*.css'
                ],
                baseDir: './dist/',
                deleteOriginals: true,
                jsonOutput: true
            },
            src: ['./../views/**/*.blade.php']
        },
        scripts: {
            options: {
                assets: [
                'scripts/*.js'
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
                        'dist/styles/*.css',
                        'dist/scripts/*.js',
                        //'./../views/**/*.blade.php',
                        './../../../../**/*.php',
                        '!../../../../public/subsites/**/*',
                        //'./../../../**/*.html',
                        './../../../../.env',
                        './../../../../**/*.htaccess',
                    ]
            },
            options: {
                open: false,
                watchTask: true,
                proxy: 'eivindarvesen.test'
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
            files: ['./scripts/*.js'],
            tasks: ['clean:dist_scripts', 'webpack', 'replace:scripts', 'cacheBust:scripts']
        },
        less: {
            files: ['./styles/*.less'],
            tasks: ['clean:dist_styles', 'less:compileCore', 'autoprefixer', 'usebanner', 'cssmin', 'copy','replace:styles', 'cacheBust:styles', 'clean:temp'],
        },
        run: {
            files: ['./../../../content/**/*.md'],
            tasks: ['run:build_content']
        }
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
  grunt.loadNpmTasks('grunt-run');

  grunt.loadNpmTasks('grunt-contrib-jshint');
  grunt.loadNpmTasks('grunt-contrib-qunit');

  grunt.loadNpmTasks('grunt-browser-sync');

  grunt.loadNpmTasks('grunt-contrib-watch');

  grunt.loadNpmTasks('grunt-webpack');

  // CSS distribution task.
  // grunt.registerTask('default', ['less:compileCore', 'autoprefixer', 'usebanner', 'cssmin']);
  grunt.registerTask('default', ['clean:dist', 'less:compileCore', 'autoprefixer', 'usebanner', 'cssmin', 'copy', 'webpack', 'replace:styles', 'cacheBust:styles', 'replace:scripts', 'cacheBust:scripts', 'clean:temp', 'run', 'browserSync', 'watch']);
  // grunt.registerTask('test', ['jshint', 'qunit']);
};
