import gulp from "gulp";
import browserify from "browserify";
import source from "vinyl-source-stream";

gulp.task('default', () => {
    return browserify({
            entries: 'resources/assets/js/app.js',
            debug: true
        })
        .bundle()
        .pipe(source('app.js'))
        .pipe(gulp.dest('public/js'));
});
