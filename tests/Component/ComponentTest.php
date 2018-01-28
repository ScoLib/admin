<?php

namespace Sco\Admin\Component;

use Mockery as m;
use Illuminate\Database\Eloquent\Model;
use Sco\Admin\Contracts\Display\DisplayInterface;
use Sco\Admin\Contracts\RepositoryInterface;
use Sco\Admin\TestCase;

class ComponentTest extends TestCase
{
    /**
     * @return Component|\PHPUnit\Framework\MockObject\MockObject
     */
    protected function getComponentMockNoMethods()
    {
        return $this->getMockForAbstractClass(Component::class, [$this->app]);
    }

    /**
     * @return Component|\PHPUnit\Framework\MockObject\MockObject
     */
    protected function getComponentMockWithMethods()
    {
        $methods = ['callDisplay', 'callCreate', 'callEdit'];

        return $this->getMockBuilder(Component::class)
            ->setConstructorArgs([$this->app])
            ->setMethods($methods)
            ->getMockForAbstractClass();
    }

    /**
     * @param bool $withMethods
     * @param string $model
     * @return \PHPUnit\Framework\MockObject\MockObject|\Sco\Admin\Component\Component
     * @throws \ReflectionException
     */
    protected function getComponentMockWithModel(
        $withMethods = true,
        $model = ComponentTestModel::class
    ) {
        $component = $withMethods
            ? $this->getComponentMockWithMethods()
            : $this->getComponentMockNoMethods();

        $component->expects($this->any())
            ->method('model')
            ->will($this->returnValue($model));

        $p = new \ReflectionProperty($component, 'booted');
        $p->setAccessible(true);
        $p->setValue($component, []);

        return $component;
    }

    protected function getComponentMockWithCallDisplay($display = '')
    {
        $component = $this->getComponentMockWithModel();
        $component->expects($this->any())
            ->method('callDisplay')
            ->will($this->returnValue($display));

        return $component;
    }

    protected function getDisplayMock()
    {
        $display = m::mock(DisplayInterface::class);
        $display->shouldReceive('setModel')->once();

        return $display;
    }

    public function testGetModelExceptionOfNotDefineModelMethod()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->getComponentMockNoMethods()->getModel();
    }

    public function testGetModelExceptionOfNotModelClass()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->getComponentMockWithModel(false, WrongComponentTestModel::class)
            ->getModel();
    }

    public function testGetModel()
    {
        $this->assertInstanceOf(Model::class,
            $this->getComponentMockWithModel()->getModel());
    }

    public function testSetAndGetName()
    {
        $component = $this->getComponentMockWithModel();
        $this->assertEquals('component_test_models', $component->getName());

        $this->assertEquals($component, $component->setName('test'));
        $this->assertEquals('test', $component->getName());
    }

    public function testSetAndGetTitle()
    {
        $component = $this->getComponentMockWithModel();

        $this->assertEquals($component, $component->setTitle('title'));
        $this->assertEquals('title', $component->getTitle());
    }

    public function testGetAndSetRepository()
    {
        $component = $this->getComponentMockWithModel();
        $this->assertInstanceOf(RepositoryInterface::class, $component->getRepository());

        $repository = m::mock(RepositoryInterface::class);
        $this->assertEquals($component, $component->setRepository($repository));
        $this->assertInstanceOf(RepositoryInterface::class, $component->getRepository());
    }

    public function testDisplayNotWithCallDisplay()
    {
        $component = $this->getComponentMockWithModel(false);

        $this->assertNull($component->fireDisplay());
    }

    public function testDisplayWrongWithCallDisplay()
    {
        $component = $this->getComponentMockWithCallDisplay('wrong_display');

        $this->expectException(\InvalidArgumentException::class);
        $component->fireDisplay();
    }

    public function testFireDisplay()
    {
        $display = $this->getDisplayMock();
        $component = $this->getComponentMockWithCallDisplay($display);

        $this->assertEquals($display, $component->fireDisplay());
    }

    public function testGetConfigs()
    {
        $display = $this->getDisplayMock();

        $component = $this->getComponentMockWithCallDisplay($display);

        $configs = $component->getConfigs();

        $this->assertArrayHasKey('title', $configs);
        $this->assertArrayHasKey('accesses', $configs);
        $this->assertArrayHasKey('display', $configs);
    }
}

class ComponentTestModel extends Model
{
}

class WrongComponentTestModel
{
}
