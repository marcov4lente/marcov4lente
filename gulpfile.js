var gulp = require('gulp');
var sass = require('gulp-sass');
var cleancss = require('gulp-clean-css');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var sourcemaps = require('gulp-sourcemaps');
var jekyll = require('gulp-jekyll');


// compile scss to css
gulp.task('styles', function() {
    gulp.src('./assets/scss/*.scss')
        .pipe(sass())
        .pipe(concat('app.css'))
        .pipe(cleancss({compatibility: 'ie8'}))
        .pipe(gulp.dest('./public'))
});

// concatenate and minify javascript
gulp.task('scripts', function() {
    gulp.src('./assets/js/*.js')
        .pipe(sourcemaps.init())
        // .pipe(uglify())
        .pipe(concat('app.js'))
        .pipe(sourcemaps.write())
        .pipe(gulp.dest('./public'));
});


gulp.task('default', function () {
    gulp.src(['./content/index.html', './_layouts/*.html', './_posts/*.{markdown,md}'])
        .pipe(jekyll({
            source: './content',
            destination: './articles/',
            bundleExec: true
        }))
        .pipe(gulp.dest('./articles/'));
});


// Rerun the task when a file changes
gulp.task('watch', function() {
    gulp.watch('assets/js', ['scripts']);
    gulp.watch('assets/scss', ['styles']);
});


// The default task (called when you run `gulp` from cli)
gulp.task('default', ['watch', 'scripts', 'styles']);
