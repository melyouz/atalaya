const Encore = require('@symfony/webpack-encore');
const CaseSensitivePathsPlugin = require('case-sensitive-paths-webpack-plugin');
const path = require('path');

if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')
    .copyFiles([
        {
            from: './assets/images',
            to: 'images/[path][name].[hash:8].[ext]',
        }
    ])
    .addEntry('app', './assets/js/app.js')
    .addStyleEntry('splash_screen', './assets/css/splash_screen.css')
    //.enableStimulusBridge('./assets/controllers.json')
    .splitEntryChunks()
    .enableSingleRuntimeChunk()
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
    .configureBabel((config) => {
        config.plugins.push('@babel/plugin-proposal-class-properties');
    })
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = 3;
    })
    .enableSassLoader(options => {
        options.implementation = require('sass')
    })
    .enableIntegrityHashes(Encore.isProduction())
    .enableVueLoader()
    .addPlugin(new CaseSensitivePathsPlugin())
    .addAliases({
        '@css': path.resolve(__dirname,'./assets/css'),
        '@images': path.resolve(__dirname, './assets/images'),
        '@': path.resolve(__dirname,'./assets/js'),
        '@modules': path.resolve(__dirname,'./assets/js/modules'),
    });

module.exports = Encore.getWebpackConfig();
