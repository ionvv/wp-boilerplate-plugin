module.exports = function( grunt ) {
	const path = require('path');
	const fs = require('fs');
	let package_json = JSON.parse(fs.readFileSync('./package.json', 'utf8'));

	var buildFilesAndDirs = [
		'./**',
		'!./assets/**',
		'./assets/dist/**',
		'!./dist/**',
		'!./node_modules/**',
		'!./composer.json',
		'!./composer.lock',
		'!./package.json',
		'!./package-lock.json',
		'!./Gruntfile.js',
		'!./webpack.config.js'
	];
	var skipExtensionsOnBuild = ['.scss', '.map'];

	grunt.initConfig({
		zip: {
			'skip-files': {
				router: function (filepath) {
					var extname = path.extname(filepath);
					if (skipExtensionsOnBuild.indexOf(extname) != -1) {
						return null;
					}

					return filepath;
				},

				src: buildFilesAndDirs,
				dest: 'dist/' + package_json.name + '.zip'
			}
		},
    });

    // Load required grunt/node modules
    grunt.loadNpmTasks('grunt-zip');
	// run webpack prod command
	grunt.registerTask('webpack-prod', '', function () {
		var exec = require('child_process').execSync;
		var result = exec("npm run prod", { encoding: 'utf8' });
		grunt.log.writeln(result);
	});
	// zip the files
    grunt.registerTask('zip-prod', ['webpack-prod', 'zip'] );

};
