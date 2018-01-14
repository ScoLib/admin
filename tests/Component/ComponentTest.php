<?php

namespace Sco\Admin\Component;

use Illuminate\Database\Eloquent\Model;
use Sco\Admin\TestCase;

class ComponentTest extends TestCase
{
    public function testGetModel()
    {
        $this->assertTrue(true);
    }
}


class ComponentTestModel extends Model
{

}
