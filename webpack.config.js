const { log } = require('console');

const path = require('path'),
    webpack = require('webpack'),
    MiniCssExtractPlugin = require('mini-css-extract-plugin'),
    UglifyJsPlugin = require('uglifyjs-webpack-plugin'),
    ImageminWebpWebpackPlugin = require("imagemin-webp-webpack-plugin"),
    Dotenv = require('dotenv-webpack'),
    library = 'WbmFunctions',
    directoriesPath = {theme:path.resolve(__dirname + '/../'), plugin:path.resolve(__dirname + '/../../plugins')},
    configs = {
        wbmtheme : {jsName:'functions', jsPath:'/assets/js/', jsExportPath:'js/', cssExportPath:'css/main.min.css', cssDependenciesOutputPath:'../', directoryPath:`${directoriesPath.theme}/wbm`},
    },
    modulesToExport = [];

for(const config in configs) {
    modulesToExport.push(defineConfig(configs[config]));
}

console.log(directoriesPath.plugin);

// Return Array of Configurations
module.exports = modulesToExport;

function defineConfig(config) {
    return { 
        ...{
            name: config.jsName,
            entry: `${config.directoryPath}${config.jsPath}${config.jsName}.js`,
            output: {
                filename: `${config.jsExportPath}${config.jsName}.min.js`,
                path: `${config.directoryPath}/build`,
                library: library,
                libraryTarget: 'var'
            },
        },
        ...definePlugins(config.cssExportPath), 
        ...defineModules(config.directoryPath, config.cssDependenciesOutputPath), 
        ...defineOptimization(), 
    }
}

function definePlugins(cssExportPath) {
    return {
        plugins: [
            //Use .env
            new Dotenv(),
            // Compile CSS
            new MiniCssExtractPlugin({
                filename: cssExportPath,
                chunkFilename: cssExportPath,
            }),
            // WebP
            new ImageminWebpWebpackPlugin({
                config: [{
                    test: /\.(jp(e)g|png)/,
                    options: {
                        quality: 75
                    }
                }],
                overrideExtension: false,
                detailedLogs: true,
                silent: false,
                strict: true
            }),
            // Generate SourceMap for all
            new webpack.SourceMapDevToolPlugin({
                test: /\.css$/i,
                filename: `${cssExportPath}.map`,
                exclude: /node_modules/, // Exclude les modules nodes
            }),

        ].filter(Boolean)
    }
}

function defineModules(path, dependenciesOutputPath) {
    return {
        module: {
            rules: [
                {
                    test: /\.js$/, // Check all JS files
                    exclude: /node_modules/, // Exclude les modules nodes
                    loader: "babel-loader" // On passe babel
                },
                {
                    test: /\.(sa|sc|c)ss$/,
                    use: [
                        MiniCssExtractPlugin.loader,
                            {
                                loader: 'css-loader',
                                options: {
                                    sourceMap: true
                                }
                            },
                            {
                                loader: 'sass-loader',
                                options: {
                                    sourceMap: true,
                                    sassOptions: {
                                        indentWidth: 4,
                                        includePaths: [__dirname, 'node_modules/compass-mixins/lib'],
                                    }
                                }
                            }
                    ],
                },
                {
                    test: /\.(woff(2)?|ttf|eot|svg)/,
                    include: [`${path}/assets/fonts/`],
                    use: [
                        {
                            loader: 'file-loader',
                            options: {
                                name: '[name].[ext]',
                                publicPath: `${dependenciesOutputPath}fonts/`,
                                outputPath: '/fonts/'
                            }
                        }
                    ]
                },
                {
                    test: /\.(png|svg|jpeg|jpg|gif)(\?v=[0-9]\.[0-9]\.[0-9])?$/,
                    include: [`${path}/assets/images/`],
                    use: [{
                        loader: 'file-loader',
                        options: {
                            name: '[name].[ext]',
                            publicPath: `${dependenciesOutputPath}images/`,
                            outputPath: '/images/'
                        }
                    }]
                }
            ]
        }
    }
}

function defineOptimization() {
    return {
        optimization: {
            minimizer: [
                new UglifyJsPlugin({
                    test: /\.js(\?.*)?$/i,
                    sourceMap: true,
                })
            ]
        }
    }
}