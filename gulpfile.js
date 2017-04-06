var gulp = require('gulp');
// var sass = require('gulp-sass');
// var cleancss = require('gulp-clean-css');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var sourcemaps = require('gulp-sourcemaps');


// concatenate and minify javascript
gulp.task('scripts', function() {
    gulp.src('./_js/*.js')
        .pipe(sourcemaps.init())
        .pipe(uglify())
        .pipe(concat('app.js'))
        .pipe(sourcemaps.write())
        .pipe(gulp.dest('.'));
});


// Rerun the task when a file changes
gulp.task('watch', function() {
    gulp.watch('assets/js', ['scripts']);
});


// The default task (called when you run `gulp` from cli)
gulp.task('default', ['watch', 'scripts']);
