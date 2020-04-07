'use strict';

const gulp = require('gulp');
const sass = require('gulp-dart-sass');
const autoprefixer = require('gulp-autoprefixer');
const cleanCSS = require('gulp-clean-css');
const ts = require('gulp-typescript');
const minify = require('gulp-minify');

gulp.task('sass', () => gulp.src(['./sass/*.scss', './sass/**/*.scss'])
    .pipe(sass().on('error', sass.logError))
    .pipe(autoprefixer({
        supports: true,
        grid: "autoplace"
    }))
    .pipe(cleanCSS())
    .pipe(gulp.dest('../css'))
);

gulp.task('sass:watch', () => gulp.watch(['./sass/*.scss', './sass/**/*.scss'], gulp.series('sass')));

gulp.task('tsc', () => gulp.src(['./ts/**/*.ts', './ts/*.ts'])
    .pipe(ts({
        lib: ['es2020', 'dom'],
        target: 'es5'
    }))
    .pipe(minify({
        ext: {min: '.min.js'}
    }))
    .pipe(gulp.dest('../js/'))
);

gulp.task('tsc:watch', () => gulp.watch(['./ts/**/*.ts', './ts/*.ts'], gulp.series('tsc')));

gulp.task('default', gulp.parallel('sass', 'tsc'));

gulp.task('watch', gulp.parallel('sass:watch', 'tsc:watch'));