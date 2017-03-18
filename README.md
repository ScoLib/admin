# Laravel Admin

[![StyleCI][ico-styleci]][link-styleci]
[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

基于Laravel5.4的一个后台管理包


## Install
NPM
```json
  "dependencies": {
    "bootstrap": "^3.3.7",
    "font-awesome": "^4.7.0",
    "iview": "^2.0.0-rc.5",
    "jquery": "^2.2.4",
    "vue-resource": "^1.2.1",
    "vue-router": "^2.3.0"
  }
```

```javascript
mix.autoload({
    'window.jQuery': 'jquery'
});

mix.copy('resources/assets/admin/js', 'public/js', false);

mix.js('resources/assets/admin/main.js', 'public/js/admin.js');
mix.less('resources/assets/admin/less/ace.less', 'public/css/admin.css');

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
php artisan migrate
php artisan db:seed --class=AdminTableSeeder
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
