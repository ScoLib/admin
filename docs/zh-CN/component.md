# 组件

**组件是`Sco-Admin`的核心概念**。
权限、对数据的操作、菜单、数据显示、表单等页面布局，都是通过在组件类中配置来实现的。

## 创建组件类

执行以下命令，并根据命令提示操作：
```php
php artisan make:component [options] [--] <name>
```

### 可选 options：

#### -o, --observer[=OBSERVER]

指定组件权限的观察者类。
不存在，则会被创建。

#### -m, --model[=MODEL]

指定组件对应的 `Model` 类。
不存在，则会被创建

#### -d, --display[=DISPLAY]

指定组件数据展示的类型，默认 `table` 类型
可选值：`table|tree|image`


## 组件类示例

```php

namespace App\Components;

use App\Components\Observers\PostObserver;
use Sco\Admin\Component\Component;
use Sco\Admin\Contracts\Form\FormInterface;
use Sco\Admin\Contracts\Display\DisplayInterface;
use Sco\Admin\Facades\AdminColumn;
use Sco\Admin\Facades\AdminDisplay;
use Sco\Admin\Facades\AdminDisplayFilter;
use Sco\Admin\Facades\AdminElement;
use Sco\Admin\Facades\AdminForm;

class Post extends Component
{
    /**
     * The page icon class name.
     *
     * @var string|null
     */
    protected $icon = 'fa-book';

    /**
     * The component display name
     *
     * @var string
     */
    protected $title = 'Title';

    /**
     * Access observer class
     *
     * @var string
     */
    protected $observer = PostObserver::class;

    public function model()
    {
        return \App\Post::class;
    }

    /**
     * @return \Sco\Admin\Contracts\Display\DisplayInterface
     */
    public function callDisplay(): DisplayInterface
    {
        $display = AdminDisplay::table()->orderBy('id', 'desc');

        $display->setColumns([
            AdminColumn::text('id', 'ID')->setWidth(80),
            AdminColumn::link('title', 'Title')->setWidth(120),
        ]);

        $display->setFilters([
            AdminDisplayFilter::text('id', 'ID'),
            AdminDisplayFilter::text('title', 'Title')->setOperator('like'),
        ]);

        return $display;
    }

    /**
     * @param mixed $id
     *
     * @return \Sco\Admin\Contracts\Form\FormInterface
     */
    public function callEdit($id): FormInterface
    {
        return AdminForm::form()->setElements([
            AdminElement::text('title', 'Title')->required()->unique(),
            AdminElement::tinymce('content', 'Content'),
        ]);
    }

    /**
     * @return \Sco\Admin\Contracts\Form\FormInterface
     */
    public function callCreate(): FormInterface
    {
        return $this->callEdit(null);
    }
}

```

