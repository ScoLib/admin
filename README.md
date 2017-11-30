# Laravel Admin

[![StyleCI][ico-styleci]][link-styleci]
[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

基于Laravel5.*的一个后台管理包


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


### install `babel-plugin-transform-vue-jsx` [link](https://github.com/vuejs/babel-plugin-transform-vue-jsx)

### NPM
```bash
$ npm install\
  bootstrap@"^3.3.7"\
  element-ui@"^2.*"\
  font-awesome@"^4.7.0"\
  jquery-slimscroll@"^1.3.8"\
  nestable2@"^1.*"\
  v-viewer@"^0.*"\
  vue-i18n@"^6.*"\
  vue-progressbar@"^0.*"\
  vue-router@"^2.*"\
  vuex@"^2.*"\
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

- [klgd][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-styleci]: https://styleci.io/repos/82435198/shield?branch=master
[ico-version]: https://img.shields.io/packagist/v/ScoLib/admin.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/ScoLib/admin/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/ScoLib/admin.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/ScoLib/admin.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/ScoLib/admin.svg?style=flat-square

[link-styleci]: https://styleci.io/repos/82435198
[link-packagist]: https://packagist.org/packages/ScoLib/admin
[link-travis]: https://travis-ci.org/ScoLib/admin
[link-scrutinizer]: https://scrutinizer-ci.com/g/ScoLib/admin/?branch=master
[link-code-quality]: https://scrutinizer-ci.com/g/ScoLib/admin
[link-downloads]: https://packagist.org/packages/ScoLib/admin
[link-author]: https://github.com/klgd
[link-contributors]: ../../contributors
