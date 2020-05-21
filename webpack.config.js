const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');

const production = process.env.NODE_ENV === 'production';

const config = {
    entry: {
        'js/frontend.min.js': path.resolve(__dirname, 'assets/js') + '/frontend.js',
        'js/backend.min.js': path.resolve(__dirname, 'assets/js') + '/backend.js',
    },
    output: {
        filename: '[name]',
        path: path.resolve(__dirname, 'assets/dist'),
    },
    mode: production ? 'production' : 'development',
    module: {
        rules: [
            {
                test: /\.js$/,
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: [
                            [
                                '@babel/preset-env',
                                {
                                    'targets': {
                                        'ie': '10'
                                    }
                                }
                            ]
                        ]
                    }
                },
                include: "/assets/js/",
                exclude: /node_modules/
            },
            {
                test: /\.s[ac]ss$/i,
                use: [
                    production ? MiniCssExtractPlugin.loader : 'style-loader',
                    {
                        loader: 'css-loader',
                        options: {
                            sourceMap: production ? false : true,
                        },
                    },
                    {
                        loader: 'sass-loader',
                        options: {
                            sourceMap: production ? false : true,
                            sassOptions: {
                                outputStyle: 'compressed',
                            },
                        },
                    },
                ],
                exclude: /node_modules/,
                include: [
                    path.resolve(__dirname, 'assets/scss')
                ]
            },
            {
                test: /\.css$/,
                use: [MiniCssExtractPlugin.loader, 'css-loader'],
            },
            {
                test: /\.(png|jpe?g|gif|svg)$/i,
                loader: 'file-loader',
                options: {
                    outputPath: 'images',
                }
            }
        ]
    },
    plugins: [
        new MiniCssExtractPlugin({
            moduleFilename: ({ name }) => {
                let file = `${name.replace('.js', '.css')}`;
                file = file.replace('js', 'css');
                return file;
            }
        }),
    ]
};

// Export the config object.
module.exports = config;
