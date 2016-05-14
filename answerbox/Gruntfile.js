module.exports = function(grunt) {
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks( 'grunt-wp-i18n' );
	grunt.loadNpmTasks("grunt-phplint");
	grunt.loadNpmTasks('grunt-contrib-less');

	grunt.initConfig({
	    makepot: {
	        target: {
	            options: {
	            	domainPath: '/languages',
	                potHeaders: {
	                    poedit: true,                 // Includes common Poedit headers.
	                    'x-poedit-keywordslist': true // Include a list of all possible gettext functions.
	                },                                // Headers to add to the generated POT file.
	                type: 'wp-theme',                // Type of project (wp-plugin or wp-theme).
	                updateTimestamp: true             // Whether the POT-Creation-Date should be updated without other changes.
	            }
	        }
	    },

	    phplint: {
	        good: ["test/rsrc/*-good.php"],
	        bad: ["test/rsrc/*-fail.php"]
	    },

	    less: {
		  development: {
		    options: {
		      paths: ["less"]
		    },
		    files: {
		      "anspress/css/overrides.css": "less/anspress/anspress.less",
		      "css/theme.css": "less/theme.less",
		      //"css/bootstrap.css": "less/bs/bootstrap.less",
		      "css/buddypress.css": "less/buddypress/buddypress.less"
		    }
		  },
		  production: {
		    options: {
		      paths: ["less"],
		      plugins: [
		        //new (require('less-plugin-autoprefix'))({browsers: ["last 2 versions"]}),
		        //new (require('less-plugin-clean-css'))(cleanCssOptions)
		      ],
		      /*modifyVars: {
		        imgPath: '"http://mycdn.com/path/to/images"',
		        bgColor: 'red'
		      }*/
		    },
		    files: {
		      "anspress/css/overrides.css": "less/anspress/anspress.less",
		      "css/theme.css": "less/theme.less",
		      "css/buddypress.css": "less/buddypress/buddypress.less"
		    }
		  }
		},

		watch: {
			less: {
				files: ['**/*.less'],
				tasks: ['less'],
			}
		},
	});

}