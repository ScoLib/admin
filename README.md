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

install `babel-plugin-transform-vue-jsx` [link](https://github.com/vuejs/babel-plugin-transform-vue-jsx)

NPM
```json
  "dependencies": {
    "axios": "^0.*",
    "bootstrap": "^3.3.7",
    "element-ui": "^1.*",
    "font-awesome": "^4.7.0",
    "jquery": "^2.2.4",
    "jquery-slimscroll": "^1.3.8",
    "vue": "^2.*",
    "vue-i18n": "^6.*",
    "vue-progressbar": "^0.*",
    "vue-router": "^2.*",
    "vuex": "^2.*",
  }
```


In your `webpack.mix.js`:
```javascript
var adminPublicPath = 'vendor/admin/';
mix.autoload({
    jquery: ['$', 'window.jQuery', 'jQuery'],
    vue: ['Vue']
});

mix.webpackConfig({
    output: {
        chunkFilename: `${adminPublicPath}js/[name]${mix.config.inProduction ? '.[chunkhash].chunk.js' : '.chunk.js'}`,
        publicPath: '/',
    },
    module: {
        rules: [
            {
                test: /\.(woff2?|ttf|eot|svg|otf)$/,
                loader: 'file-loader',
                options: {
                    name: `${adminPublicPath}fonts/[name].[ext]?[hash]`,
                    publicPath: '/'
                }
            },
            {
                test: /\.(png|jpe?g|gif)$/,
                loaders: [
                    {
                        loader: 'file-loader',
                        options: {
                            name: `${adminPublicPath}images/[name].[ext]?[hash]`,
                            publicPath: '/'
                        }
                    },
                ]
            },
        ],
    },
});

mix.js('resources/assets/vendor/admin/main.js', `public/${adminPublicPath}js/app.js`)
    .extract(['vue', 'jquery', 'bootstrap', 'vue-router', 'element-ui'])

mix.less('resources/assets/vendor/admin/less/admin.less', `public/${adminPublicPath}css/app.css`);

if (mix.config.inProduction) {
    mix.version();
}
```

```sh
npm install 
npm run production
```


Via Composer

``` bash
"scolib/admin": "1.0.x@dev"
```

## Usage

``` php
Sco\Admin\Providers\AdminServiceProvider::class,
    
```

编辑auth.php
```php
    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => \Sco\Admin\Models\User::class,
        ],
    ],
```

`--tag: assets/config/views/lang/routes`
```php
php artisan vendor:publish --provider="Sco\Admin\Providers\PublishServiceProvider" --force
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
