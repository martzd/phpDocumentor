<?php

declare(strict_types=1);

namespace phpDocumentor\Descriptor\Builder\Reflector\Tags;

use phpDocumentor\Descriptor\ProjectDescriptorBuilder;
use phpDocumentor\Reflection\DocBlock\Description;
use phpDocumentor\Reflection\DocBlock\Tags\Param;
use phpDocumentor\Reflection\Types\String_;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;

class ParamAssemblerTest extends TestCase
{
    /** @var ParamAssembler */
    private $fixture;

    /** @var ProjectDescriptorBuilder|ObjectProphecy */
    private $builder;

    /**
     * Initializes the fixture for this test.
     */
    protected function setUp() : void
    {
        $this->builder = $this->prophesize(ProjectDescriptorBuilder::class);
        $this->fixture = new ParamAssembler();
        $this->fixture->setBuilder($this->builder->reveal());
    }

    /**
     * @covers \phpDocumentor\Descriptor\Builder\Reflector\Tags\ParamAssembler::create
     * @covers \phpDocumentor\Descriptor\Builder\Reflector\Tags\ParamAssembler::buildDescriptor
     */
    public function testCreatingParamDescriptorFromReflector() : void
    {
        $reflector = new Param(
            '$myParameter', new String_(),
            false,
            new Description('This is a description')
        );

        $descriptor = $this->fixture->create($reflector);

        $this->assertSame('param', $descriptor->getName());
        $this->assertSame('This is a description', (string) $descriptor->getDescription());
        $this->assertSame('$myParameter', $descriptor->getVariableName());
        $this->assertEquals(new String_(), $descriptor->getType());
    }
}
