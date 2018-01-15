<?php

namespace Sco\Admin\Component;

use Mockery as m;
use Illuminate\Database\Eloquent\Model;
use Sco\Admin\Contracts\RepositoryInterface;
use Sco\Admin\TestCase;

class ComponentTest extends TestCase
{
    /**
     * @return Component|\PHPUnit\Framework\MockObject\MockObject
     */
    protected function getComponent()
    {
        $stub = $this->getMockForAbstractClass(Component::class, [$this->app]);
        $stub->expects($this->any())
            ->method('model')
            ->willReturn(ComponentTestModel::class);

        return $stub;
    }

    /*protected function getComponentMock()
    {
        return $this->app['admin.instance.component'] = m::mock(ComponentInterface::class);
    }*/

    public function testGetModelExceptionOfNotDefineModelMethod()
    {
        $this->expectException(\InvalidArgumentException::class);
        $stub = $this->getMockForAbstractClass(Component::class, [$this->app]);
        $stub->getModel();
    }

    public function testGetModelExceptionOfNotModelClass()
    {
        $this->expectException(\InvalidArgumentException::class);
        $stub = $this->getMockForAbstractClass(Component::class, [$this->app]);

        $stub->expects($this->any())
            ->method('model')
            ->willReturn(WrongComponentTestModel::class);

        $stub->getModel();
    }

    public function testGetModel()
    {
        $this->assertInstanceOf(Model::class, $this->getComponent()->getModel());
    }

    public function testSetAndGetName()
    {
        $component = $this->getComponent();
        $this->assertEquals('component_test_models', $component->getName());

        $this->assertEquals($component, $component->setName('test'));
        $this->assertEquals('test', $component->getName());
    }

    public function testSetAndGetTitle()
    {
        $component = $this->getComponent();

        $this->assertEquals($component, $component->setTitle('title'));
        $this->assertEquals('title', $component->getTitle());
    }

    public function testGetAndSetRepository()
    {
        $component = $this->getComponent();
        $this->assertInstanceOf(RepositoryInterface::class, $component->getRepository());

        $repository = m::mock(RepositoryInterface::class);
        $this->assertEquals($component, $component->setRepository($repository));
        $this->assertInstanceOf(RepositoryInterface::class, $component->getRepository());
    }
}

class ComponentTestModel extends Model
{

}

class WrongComponentTestModel
{

}
