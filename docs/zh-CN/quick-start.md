# 快速开始


## 方式1：使用演示示例

- [admin-demo-by-entrust](https://github.com/ScoLib/admin-demo-by-entrust.git)

    基于 `entrust`

- [admin-demo-by-laravel-permission](https://github.com/ScoLib/admin-demo-by-laravel-permission.git)
    
    基于 `laravel-permission`

### 安装

Clone 演示仓库

```sh
$ git clone 上述示例git URL
```

复制 `.env.example` 为 `.env`并填写数据库设置。

分别运行以下命令

```sh
$ composer install -vvv
$ php artisan key:generate
$ php artisan migrate --seed
$ npm install
$ npm run prod
```

演示示例已安装完毕。


## 方式2：Artisan 创建 Sco-Admin 组件

使用 Artisan 命令快速创建组件。