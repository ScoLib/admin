# 配置

`config/admin.php`


```php
return [
    /**
     * Sco Admin Title
     */
    'title' => 'Sco Admin',

    'url_prefix' => 'admin',

    'datetime_format' => 'Y-m-d H:i:s',

    'upload' => [
        'disk'       => 'public',
        'extensions' => [
            'file'  => 'jpg,gif,png,jpeg,zip,rar,tar,gz,7z,doc,docx,txt,xml',
            'image' => 'jpg,jpeg,png,gif',
        ],
        'directory'  => 'admin/uploads',
    ],

    'components' => app_path('Components'),
];
```

## 配置选项

### title

显示在页面标题上的文字

### url_prefix

路由前缀，`Sco Admin` 所有的路由都是以这个开头


默认值： `admin`

### datetime_format

时间格式，用于列和表单元素

默认值：`Y-m-d H:i:s`

### upload

上传相关通用参数


- disk
    
    存储disk
    
    默认值：`public`
    
- extensions
    - file 
            
    允许上传的文件扩展名
    
    默认值： `jpg,gif,png,jpeg,zip,rar,tar,gz,7z,doc,docx,txt,xml`
        
    - image
        
    允许上传的图片扩展名
    
    默认值： `jpg,jpeg,png,gif`

- directory
    
    上传文件保存的相对目录
    
    默认值： admin/uploads

### components

组件所在目录

默认值: app/Components