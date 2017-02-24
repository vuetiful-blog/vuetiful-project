import gulp from "gulp";
import browserify from "browserify";
import source from "vinyl-source-stream";
import sass from "gulp-sass";
import hmr from 'browserify-hmr';
import watchify from 'watchify';

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
        entries: 'resources/assets/js/app.js',
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
            .pipe(source('app.js'))
            .pipe(gulp.dest('public/js'));
    }
});

gulp.task('sass', function() {
    return gulp.src('./resources/assets/sass/app.scss')
        .pipe(sass().on('error', sass.logError))
        .pipe(gulp.dest('./public/css'));
});
