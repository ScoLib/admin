# 安装

## 要求

- Laravel >= 5.5.0

## Composer
创建 `Laravel` 应用后，使用以下命令引入 `Sco Admin` 包：

```bash
composer require scolib/admin
```

## Artisan
执行安装命令：

```bash
php artisan admin:install
```

##### 这个命令做了什么

###### 1. 发布

```bash
php artisan vendor:publish --provider="Sco\Admin\Providers\ResourcesServiceProvider"
```

- 配置文件。`/config/admin.php`

```bash
php artisan vendor:publish --tag=config
```

- 资源文件。 `/resources/assets/vendor/admin`

```bash
php artisan vendor:publish --tag=assets
```

- 视图文件。 `/resources/views/vendor/admin`

```bash
php artisan vendor:publish --tag=views
```

- 语言包。 `/resources/lang/vendor/admin`

```bash
php artisan vendor:publish --tag=lang
```


###### 2. 路由

`routes/web.php` 追加 `Admin::routes();`







