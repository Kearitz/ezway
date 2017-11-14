const webpack = require('webpack'); 
const ExtractTextPlugin = require("extract-text-webpack-plugin"); //Use to have css in his own file and not in JS file.
const path = require('path');

module.exports = {
    entry: [ path.join(__dirname, "..", "src", "ezway", "assets", "js","app.js"),
             path.join(__dirname, "..", "src", "ezway", "assets", "sass","app.scss")],
    output: {
        path: __dirname+"/../public",
        filename: "js/app.js"
    },
    module: {
        rules: [{
            test: /\.scss$/,
            use: ExtractTextPlugin.extract({
                use: [{
                    loader: "css-loader"
                }, {
                    loader: "sass-loader"
                }],
                fallback: "style-loader"
            })
        }]
    },
    plugins: [
        new ExtractTextPlugin("css/app.css"),
    ]
};