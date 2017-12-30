# Sco Admin

[![StyleCI](https://styleci.io/repos/82435198/shield?branch=master)](https://styleci.io/repos/82435198)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/ScoLib/admin.svg?style=flat-square)](https://packagist.org/packages/ScoLib/admin)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](https://github.com/ScoLib/admin/blob/master/LICENSE.md)
[![Build Status](https://img.shields.io/travis/ScoLib/admin/master.svg?style=flat-square)](https://travis-ci.org/ScoLib/admin)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/ScoLib/admin.svg?style=flat-square)](https://scrutinizer-ci.com/g/ScoLib/admin/?branch=master)
[![Quality Score](https://img.shields.io/scrutinizer/g/ScoLib/admin.svg?style=flat-square)](https://scrutinizer-ci.com/g/ScoLib/admin)
[![Total Downloads](https://img.shields.io/packagist/dt/ScoLib/admin.svg?style=flat-square)](https://packagist.org/packages/ScoLib/admin)


`Sco Admin` is an administrative interface builder for [`Laravel`](http://laravel.com/).

Inspired by [SleepingOwlAdmin](https://github.com/LaravelRUS/SleepingOwlAdmin) , [FrozenNode/Laravel-Administrator](https://github.com/FrozenNode/Laravel-Administrator) and [Voyager](https://github.com/the-control-group/voyager)


## Install

### Laravel 5.5.*

``` bash
$ composer require scolib/admin:1.1.x@dev
```

Laravel 5.5 uses Package Auto-Discovery, so doesn't require you to manually add the ServiceProvider.

### Laravel5.4
``` bash
$ composer require scolib/admin:1.0.x@dev
```

Add the ServiceProvider to the `providers` array in `config/app.php`
``` php
Sco\Admin\Providers\AdminServiceProvider::class,
```

## Publish resources file

Copy the package resources to your local with the publish command:

>Has tags: `assets/config/views/lang`

```bash
$ php artisan vendor:publish --provider="Sco\Admin\Providers\ResourcesServiceProvider"
```


### install [`babel-plugin-transform-vue-jsx`](https://github.com/vuejs/babel-plugin-transform-vue-jsx)

### NPM
```bash
$ npm install\
  bootstrap\
  element-ui\
  font-awesome\
  jquery-slimscroll\
  nestable2\
  v-viewer\
  vue-i18n\
  vue-progressbar\
  vue-router\
  vuex\
  v-tinymce\
  --save-dev
```

In your `webpack.mix.js`:
```javascript
mix.webpackConfig({
    output: {
        chunkFilename: `js/[name]${
            mix.inProduction() ? '.[chunkhash].chunk.js' : '.chunk.js'
        }`
    }
})
    .js('resources/assets/vendor/admin/main.js', `public/js/admin.js`)
    .autoload({
        jquery: ['$', 'window.jQuery', 'jQuery', 'jquery'],
        vue: 'Vue'
    })
    .less(
        'resources/assets/vendor/admin/less/admin.less',
        `public/css/admin.css`
    );

if (mix.inProduction()) {
    mix.version();
}
```

```sh
npm install 
npm run prod
```

## Usage

See [Document](http://scoadmin.scophp.com/) 

## 更新日志

 [CHANGELOG](CHANGELOG.md) 

## Testing

``` bash
$ composer test
```

## 贡献

 [CONTRIBUTING](CONTRIBUTING.md) 和 [CONDUCT](CONDUCT.md) 

## 安全

如果你发现任何安全相关的问题，请发邮件 slice1213@gmail.com

## Credits

- [klgd](https://github.com/klgd)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

