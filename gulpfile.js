// Load plugins
var	gulp = require('gulp'),
	concat = require('gulp-concat'),
	less = require('gulp-less'),
	autoprefixer = require('gulp-autoprefixer'),
	minifyCSS = require('gulp-minify-css'),
	rename = require('gulp-rename'),
	notify = require('gulp-notify'),
	minifyHTML = require('gulp-minify-html'),
	livereload = require('gulp-livereload');

	// uglify = require('gulp-uglify'),
	// minifyCSS = require('gulp-minify-css'),
	// concatCss = require('gulp-concat-css'),
	// concat = require('gulp-concat');
	// jshint = require('gulp-jshint'),
	// imagemin = require('gulp-imagemin'),
	// cache = require('gulp-cache'),
	// del = require('del');


// TASK :: Concat ALL LESS files into single file called 'styles.less'
gulp.task('concat', function() {
	return gulp.src(['css/styles_global.less', 'css/styles_sections.less'])
	.pipe(concat('styles.less'))
	.pipe(gulp.dest('css'));
});


// TASK :: Process 'styles.less' file into CSS file
gulp.task('less', function (){
	gulp.src('css/styles.less')
	.pipe(less())
	.pipe(autoprefixer('last 2 versions'))
	.pipe(minifyCSS())
	.pipe(rename('styles.css'))
	.pipe(gulp.dest('dist/css'))
	.pipe(notify('Less Compiled, Prefixed and Minified'))
	.pipe(livereload());
});


// Task :: minify HTML files
gulp.task('html', function (){
	gulp.src('application/views/site/**/*.php')
	//.pipe(minifyHTML())
	//.pipe(gulp.dest('dist/html'))
	//.pipe(notify('HTML, Prefixed and Minified'))
	.pipe(livereload());
});





gulp.task('watch', function() {
	livereload.listen();
	gulp.watch(['css/styles_global.less', 'css/styles_sections.less'], ['concat']),
	gulp.watch('css/styles.less', ['less'])
	//gulp.watch('application/views/**/**/*.php', ['html'])
});

gulp.task('default', ['concat', 'less', 'html', 'watch']);







// Task :: Uglifies all js files
// gulp.task('scripts', function (){
// 	gulp.src('public/js/lib/**/*.js')
// 	.pipe(uglify())
// 	.pipe(concat('main.js'))
// 	.pipe(gulp.dest('public/dist/js'));
// });


// Copy fonts to /dist directory
// gulp.task('copyfonts', function() {
//    gulp.src(['public/fonts/**/*.{eot,svg,ttf,woff,woff2}', 'public/fonts/**/*.css'])
//    .pipe(gulp.dest('public/dist/fonts'));
// });





// Task :: concat and minify all CSS files
// gulp.task('css', ['less'], function () {
//     gulp.src('public/css/*.css')
//         .pipe(concatCss('styles.css'))
//         .pipe(minifyCSS())
//         .pipe(rename('style.min.css'))
//         .pipe(gulp.dest('public/dist/css'))
//         .pipe(notify('CSS concatenated and minified'));
// });


// TASK :: concat all js files
// gulp.task('concatjs', function(){
// 	gulp.src([
// 		'public/lib/aangular.min.js',
// 		'public/lib/angular-animate.min.js',
// 		'public/lib/angular-cookies.min.js',
// 		'public/lib/angular-resource.min.js',
// 		'public/lib/angular-route.min.js',
// 		'public/lib/angular-sanitize.min.js',
// 		'public/lib/angular-dragdrop.min.js',
// 		'public/lib/bootstrap.min.js',
// 		'public/lib/jquery-ui-1.10.4.custom.js',
// 		'public/lib/underscore-min.js'
// 	])
// 	.pipe(concat('main.js'))
// 	.pipe(gulp.dest('public/dist/js'));
// });


// Watch Task
// Watches JS
// gulp.task('watch', function(){
// 	gulp.watch('public/js/lib/**/*.js', ['scripts']),
// 	gulp.watch('css/styles.less', ['less'])
// 	gulp.watch('public/css/*.css', ['css']);
// });





