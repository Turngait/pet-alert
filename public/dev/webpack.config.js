const path = require('path');

module.exports = {
  mode: 'production',

  entry: {
    descPage: './src/app_descPage.ts',
    userAcc: './src/app_userAcc.ts',
    otherPage: './src/app_otherPage.ts',
    articlesPage: './src/app_articles.ts',
    addArticlePage: './src/app_addArticle.ts'
  },

  output: {
    filename: '[name].js',
    path:path.resolve(__dirname, '../js')
  },

  resolve: {
    extensions: ['.js', '.ts']
  },

  module: {
    rules: [
      { 
        test: /\.js$/,
        exclude: /node_modules/,
        loader: "babel-loader", 
        query: {
          presets: ['es2015']
        }
      },
      {
        test: /\.ts?$/,
        use: 'ts-loader',
        exclude: /node_modules/,
      },
    ]
  }
}