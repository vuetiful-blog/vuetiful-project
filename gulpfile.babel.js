import gulp from "gulp";
import browserify from "browserify";
import source from "vinyl-source-stream";
import sass from "gulp-sass";
import hmr from 'browserify-hmr';
import watchify from 'watchify';
import util from 'gulp-util';
import { argv } from 'yargs';
import flatten from 'gulp-flatten';

var entry = (argv.f !== undefined) ? argv.f : "resources/assets/js/app.js";
var dest = (argv.d !== undefined) ? argv.d : "public/js";

gulp.task('default', () => {
    return browserify({
            entries: 'resources/assets/js/app.js',
            debug: true
        })
        .bundle()
        .pipe(source('app.js'))
        .pipe(gulp.dest('public/js'));
});

gulp.task('hmr', () => {
    const b = browserify({
        entries: entry,
        plugin: [hmr, watchify],
        debug: true
    })

    b.on('update', bundle);
    bundle();

    function bundle() {
        b.bundle()
            .on('error', err => {
                util.log("Browserify Error", util.colors.red(err.message))
            })
            .pipe(source(entry))
            .pipe(flatten())
            .pipe(gulp.dest(dest));
    }
});

gulp.task('sass', function() {
    return gulp.src('./resources/assets/sass/app.scss')
        .pipe(sass().on('error', sass.logError))
        .pipe(gulp.dest('./public/css'));
});
