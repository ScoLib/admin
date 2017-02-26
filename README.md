# Laravel Admin

[![StyleCI][ico-styleci]][link-styleci]
[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Total Downloads][ico-downloads]][link-downloads]

基于Laravel5.4的一个后台管理包


## Install

Via Composer

``` bash
"scolib/admin": "1.0.0@dev",
"zizaco/entrust": "5.2.x-dev"
```

## Usage

``` php
Zizaco\Entrust\EntrustServiceProvider::class,

'Entrust'   => Zizaco\Entrust\EntrustFacade::class,
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
[ico-downloads]: https://img.shields.io/packagist/dt/ScoLib/admin.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/82435198/shield?branch=master

[link-packagist]: https://packagist.org/packages/ScoLib/admin
[link-travis]: https://travis-ci.org/ScoLib/admin
[link-downloads]: https://packagist.org/packages/ScoLib/admin
[link-styleci]: https://styleci.io/repos/82435198
[link-author]: https://github.com/klgd
[link-contributors]: ../../contributors
