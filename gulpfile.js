'use strict';

const gulp = require('gulp');
const sass = require('gulp-dart-sass');
const autoprefixer = require('gulp-autoprefixer');
const cleanCSS = require('gulp-clean-css');
const gap = require('gulp-append-prepend');
const ts = require('gulp-typescript');
const minify = require('gulp-minify');
const pkg = require('./package.json');

const themeInfo = [
    ['Theme Name', pkg.name],
    ['Theme URI', `https://${pkg.repository.slice(4, -4).replace(':', '/')}`],
    ['Author', pkg.author.slice(0, pkg.author.indexOf(' <'))],
    ['Author URI', `mailto:${pkg.author.slice(pkg.author.indexOf('<') + 1, -1)}`],
    ['Description', pkg.description],
    ['Version', pkg.version],
    ['License', 'GNU General Public License 3.0 or later'],
    ['License URI', 'http://www.gnu.org/licenses/gpl-3.0']
];

gulp.task('sass', () => gulp.src(['./style.scss'])
    .pipe(sass().on('error', sass.logError))
    .pipe(autoprefixer({
        supports: true,
        grid: "autoplace"
    }))
    .pipe(cleanCSS())
    .pipe(gap.prependText('/*\n' + themeInfo.map(it => it.join(': ')).join('\n') + '\n*/'))
    .pipe(gulp.dest('./'))
);

gulp.task('sass:watch', () => gulp.watch(['./style.scss', './sass/*.scss', './sass/**/*.scss'], gulp.series('sass')));

gulp.task('tsc', () => gulp.src(['./ts/**/*.ts', './ts/*.ts'])
    .pipe(ts({
        lib: ['es2020', 'dom'],
        target: 'es5'
    }))
    .pipe(minify({
        ext: {min: '.min.js'}
    }))
    .pipe(gulp.dest('./js/'))
);

gulp.task('tsc:watch', () => gulp.watch(['./ts/**/*.ts', './ts/*.ts'], gulp.series('tsc')));

gulp.task('default', gulp.parallel('sass', 'tsc'));

gulp.task('watch', gulp.parallel('sass:watch', 'tsc:watch'));