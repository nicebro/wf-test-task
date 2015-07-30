var gulp = require('gulp'),
	less = require('gulp-less'),
	minify = require('gulp-minify-css'),
	concat = require('gulp-concat'),
	uglify = require('gulp-uglify'),
	rename = require('gulp-rename'),
	browserSync = require('browser-sync'),
	jade = require('gulp-jade');

gulp.task('browser-sync', function() {
	browserSync({
		proxy: {
			target: "localhost:8000",
		},
		open: false,
	});
});

var paths = {
	'src': {
		'less': './src/less/',
		'js': './src/js/',
		'assets': {
			'css': '../public/assets/css/',
			'js': '../public/assets/js/',
		}
	},
	'vendor': './bower_components/'
};

function catchError(error) {
	console.log(error.toString());
	this.emit('end');
}

gulp.task('css', function() {
	gulp.src([
		paths.src.less + '*.less',
	])
	.pipe(less()).on('error', catchError)
	.pipe(concat('styles.css'))
	.pipe(minify({keepSpecialComments:0}))
	.pipe(gulp.dest(paths.src.assets.css))
	.pipe(browserSync.reload({stream:true}));
});

gulp.task('js', function() {
	gulp.src([
		paths.src.js + 'app.js',
	])
	.pipe(concat('app.js'))
	.pipe(uglify()).on('error', catchError)
	.pipe(gulp.dest(paths.src.assets.js))
	.pipe(browserSync.reload({stream:true}));
});

gulp.task('watch', ['browser-sync', 'css', 'js'], function() {
	gulp.watch(paths.src.less + '**/*.less', ['css']);
	gulp.watch(paths.src.js + '**/*.js', ['js']);
});