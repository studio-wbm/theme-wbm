const { src, dest, watch, series, parallel } = require("gulp");
const sass = require("gulp-sass")(require("sass"));
const babel = require("gulp-babel");
const browserSync = require("browser-sync").create();
const imagemin = require("gulp-imagemin");
const webp = require("imagemin-webp");
const autoprefixer = require("gulp-autoprefixer");
const cssnano = require("gulp-cssnano");
const uglify = require("gulp-uglify");
const concat = require("gulp-concat");
const rename = require("gulp-rename");

function compileScss() {
    return src("assets/scss/**/*.scss")
        .pipe(sass())
        .pipe(autoprefixer())
        .pipe(cssnano())
        .pipe(rename({ suffix: ".min" }))
        .pipe(dest("dist/css"))
        .pipe(browserSync.stream());
}

function compileJs() {
    return src("assets/js/**/*.js")
        .pipe(babel({ presets: ["@babel/env"] }))
        .pipe(uglify())
        .pipe(concat("app.js"))
        .pipe(rename({ suffix: ".min" }))
        .pipe(dest("dist/js"))
        .pipe(browserSync.stream());
}

function optimizeImages() {
    return src("assets/images/**/*.{jpg, jpeg, png}")
        .pipe(imagemin([webp({ quality: 50 })]))
        .pipe(rename({ extname: ".webp" }))
        .pipe(dest(function (file) {
            return file.base;
        }));
}

function serve() {
    browserSync.init({ proxy: "wbm.local" });

    watch("assets/scss/**/*.scss", compileScss);
    watch("assets/js/**/*.js", compileJs);
    watch("assets/images/**/*", optimizeImages);
    watch("**/*.php").on("change", browserSync.reload);
}

exports.default = series(
    parallel(compileScss, compileJs, optimizeImages,),
    serve
);
