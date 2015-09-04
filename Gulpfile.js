'use strict';

var config = require('./gulpconfig.json');

var gulp = require('gulp');
var watch = require('gulp-watch');
var sass = require('gulp-sass');
var gutil = require('gulp-util');
var concat = require('gulp-concat');

var input_files = [
    config.scss + 'style.scss'
];

var css_files = [
    config.scss + '**/*'
];

var js_files = [
    config.bower + 'jquery/dist/jquery.js'
];

var css_output_path = config.css;

var js_output_file = 'application.js';
var js_output_path = config.js;

gulp.task('sass', function () {
    gulp.src(input_files)
        .pipe(sass.sync().on('error', sass.logError))
        .pipe(gulp.dest(css_output_path));
});

gulp.task('sass:watch', function () {
    gulp.watch(css_files, ['sass']);
});

gulp.task('scripts', function(){
    gulp.src(js_files)
        .pipe(concat(js_output_file).on('error', gutil.log))
        .pipe(gulp.dest(js_output_path))
});

gulp.task('watch', function(){
    gulp.watch(css_files, ['sass', 'scripts'])
});

gulp.task('default', ['sass', 'scripts']);