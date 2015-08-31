var gulp = require('gulp');
var sass = require('gulp-sass');

var config = require('./gulpconfig.json');

var input_files = [
    config.scss + 'style.scss'
];

var watch_files = [
    config.scss + '**/*'
];

var output_path = config.css;

gulp.task('sass', function(){
    gulp.src(input_files)
        .pipe(sass().on('error', sass.logError))
        .pipe(gulp.dest(output_path))
});

gulp.task('watch', function(){
    gulp.watch(watch_files, ['sass'])
});
gulp.task('default', ['sass']);