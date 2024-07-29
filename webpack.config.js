import MiniCssExtractPlugin from "mini-css-extract-plugin";
import Path from "path";

export default {
  name: "build",
  mode: "production",
  entry: ["./client/js/index.jsx", "./client/scss/main.scss"],
  output: { path: Path.resolve("."), filename: "js/gallery.js" },
  resolve: { extensions: [".jsx"] },
  plugins: [new MiniCssExtractPlugin({ filename: "css/main.css" })],
  module: {
    rules: [
      {
        test: /\.jsx$/,
        exclude: /node_modules/,
        use: [
          {
            loader: "babel-loader",
            options: {
              presets: ["@babel/preset-env", "@babel/preset-react"],
            },
          },
        ],
      },
      {
        test: /\.scss$/,
        exclude: /node_modules/,
        use: [MiniCssExtractPlugin.loader, "css-loader", "sass-loader"],
      },
    ],
  },
};
