# FAQ

# 执行 npm 报错

```javascript
WARNING in ./node_modules/css-loader?{"url":true,"sourceMap":false,"importLoaders":1}!./node_modules/postcss-loader/lib?{"sourceMap":false,"ident":"postcss","plugins":[null,null]}!./node_modules/resolve-url-loader?{"sourceMap":true,"root":"D://Users//www//admin-demo-by-entrust//node_modules"}!./node_modules/sass-loader/lib/loader.js?{"precision":8,"outputStyle":"expanded","sourceMap":true}!./resources/assets/sass/app.scss
(Emitted value instead of an instance of Error) 

 ⚠️  PostCSS Loader

Previous source map found, but options.sourceMap isn't set.
In this case the loader will discard the source map entirely for performance reasons.
See https://github.com/postcss/postcss-loader#sourcemap for more information.


 @ ./resources/assets/sass/app.scss 4:14-266
 @ multi ./resources/assets/js/app.js ./resources/assets/sass/app.scss ./resources/assets/vendor/admin/less/admin.less
```

这是一个 `Warning` 可以忽略，如果你介意这个，可以在 `webpack.mix.js` 中添加命令：

```javascript
mix.sourceMaps();
```

> 注意：增加该命令后，所有的css和js文件会产生对应的 `.map` 文件