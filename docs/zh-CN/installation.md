# 安装

## 要求

- PHP >= 7.0.0
- Laravel >= 5.5.0

## Composer
创建 `Laravel` 应用后，使用以下命令引入 `Sco-Admin` 包：

```sh
$ composer require scolib/admin
```

## Artisan
执行安装命令：

```sh
$ php artisan admin:install
```

##### 这个命令做了什么

###### 1. 发布

```sh
$ php artisan vendor:publish --provider="Sco\Admin\Providers\ResourcesServiceProvider"
```

- 配置文件。`/config/admin.php`

```sh
$ php artisan vendor:publish --tag=config
```

- 资源文件。 `/resources/assets/vendor/admin`

```sh
$ php artisan vendor:publish --tag=assets
```

- 视图文件。 `/resources/views/vendor/admin`

```sh
$ php artisan vendor:publish --tag=views
```

- 语言包。 `/resources/lang/vendor/admin`

```sh
$ php artisan vendor:publish --tag=lang
```

###### 2. 路由

`routes/web.php` 追加 `Admin::routes();`


## Assets

Install [`babel-plugin-transform-vue-jsx`](https://github.com/vuejs/babel-plugin-transform-vue-jsx)

添加 Sco-Admin 相关的扩展包

```sh
$ npm install\
  bootstrap\
  element-ui\
  font-awesome\
  jquery-slimscroll\
  less\
  less-loader\
  nestable2\
  v-tinymce\
  v-viewer\
  vue-i18n\
  vue-progressbar\
  vue-router\
  vue-simplemde\
  vuex\
  --save-dev
```

编辑 `webpack.mix.js`

```javascript
// mix.sourceMaps();

mix.webpackConfig({
    output: {
        chunkFilename: `js/[name]${
            mix.inProduction() ? '.[chunkhash].chunk.js' : '.chunk.js'
            }`,
        publicPath: '/',
    }
})
    .js('resources/assets/vendor/admin/main.js', 'public/js/admin.js')
    .autoload({
        jquery: ['$', 'window.jQuery', 'jQuery', 'jquery'],
        vue: 'Vue'
    })
    .less(
        'resources/assets/vendor/admin/less/admin.less',
        'public/css/admin.css'
    )
    .copyDirectory('node_modules/tinymce/plugins/visualblocks/css', 'public/js/tinymce/plugins/visualblocks/css')
    .copyDirectory('node_modules/tinymce/plugins/emoticons/img', 'public/js/tinymce/plugins/emoticons/img')

if (mix.inProduction()) {
    mix.version();
}
```

安装扩展包

```sh
$ npm install
```

编译资源文件

```sh
$ npm run dev

// OR

$ npm run watch

// OR

$ npm run production
```
