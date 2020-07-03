// gulp usage only for optimization on deploy

// order of commands
// npm install --global gulp-cli
// npm install --save-dev
// check if all packages from package.json added - run 'npm install' again if not
// gulp


// define usage of packages
var gulp      = require('gulp'),
    concat    = require('gulp-concat'),
    uglify    = require('gulp-uglify'),
    rename 	  = require('gulp-rename'),
    cleanCSS  = require('gulp-clean-css'),
    imagemin  = require('gulp-imagemin');


// define tasks
gulp.task('scripts', function() {
    return gulp.src([
        'js/libs.js',
        'js/scripts.js',
        /*'js/ajax.js'*/
    ])
        .pipe(concat('main.js'))
        .pipe(uglify())
        .pipe(rename({suffix: '.min'}))
        .pipe(gulp.dest('build'));
});

gulp.task('styles', function() {
    return gulp.src([
        'style/fonts.css',
        'style/libs.css',
        'style/style.css'
    ])
        .pipe(concat('main.css'))
        .pipe(cleanCSS())
        .pipe(rename({suffix: '.min'}))
        .pipe(gulp.dest('build'));
});

gulp.task('images', function() {
    return gulp.src(['images/*.{png,jpg,gif}'])
        .pipe(imagemin())
        .pipe(gulp.dest('images'));
});


// combine all tasks in default
gulp.task('default', gulp.series('scripts', 'styles', 'images'));