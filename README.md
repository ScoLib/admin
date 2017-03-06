# Laravel Admin

[![StyleCI][ico-styleci]][link-styleci]
[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Total Downloads][ico-downloads]][link-downloads]

基于Laravel5.4的一个后台管理包


## Install
NPM
```json
  "devDependencies": {
    "font-awesome": "^4.7.0",
    "jquery": "^2.2.4"
  }
```

```javascript
mix.copy('node_modules/bootstrap-sass/assets/javascripts/bootstrap.min.js', 'public/js')
    .copy('node_modules/jquery/dist/jquery.min.js', 'public/js')
    .copy('resources/assets/admin/js', 'public/js', false);

mix.js('resources/assets/admin/admin.js', 'public/js')
    .sass('node_modules/bootstrap-sass/assets/stylesheets/_bootstrap.scss', 'public/css/bootstrap.css')
    .sass('node_modules/font-awesome/scss/font-awesome.scss', 'public/css')
    .less('resources/assets/admin/AdminLTE/AdminLTE.less', 'public/css/admin.css');

if (mix.config.inProduction) {
    mix.version();
    mix.disableNotifications();
}
```

```sh
npm install 
npm run production
```


Via Composer

``` bash
"scolib/admin": "1.0.x@dev",
"scolib/entrust": "dev-sco"
```

## Usage

``` php
Zizaco\Entrust\EntrustServiceProvider::class,
Sco\Admin\Providers\AdminServiceProvider::class,

'Entrust'   => Zizaco\Entrust\EntrustFacade::class,



    
```

编辑auth.php
```php
    'guards' => [
        'admin' => [
            'driver' => 'session',
            'provider' => 'admin',
        ],
    ],
    
    'providers' => [
        'admin' => [
            'driver' => 'eloquent',
            'model' => \Sco\Admin\Models\AdminUser::class,
        ],
    ],
```

tag: assets/config/views/lang
```php
php artisan vendor:publish --provider="Sco\Admin\Providers\AdminServiceProvider" --tag="config" --force
```

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

[ico-version]: https://img.shields.io/packagist/v/ScoLib/admin.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/ScoLib/admin/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/ScoLib/admin.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/ScoLib/admin.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/82435198/shield?branch=master

[link-packagist]: https://packagist.org/packages/ScoLib/admin
[link-travis]: https://travis-ci.org/ScoLib/admin
[link-scrutinizer]: https://scrutinizer-ci.com/g/ScoLib/admin/code-structure
[link-downloads]: https://packagist.org/packages/ScoLib/admin
[link-styleci]: https://styleci.io/repos/82435198
[link-author]: https://github.com/klgd
[link-contributors]: ../../contributors
