<?php

/*
 * This file is part of the Klipper package.
 *
 * (c) François Pluchino <francois.pluchino@klipper.dev>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Klipper\Component\DefaultValue\Tests;

use Klipper\Component\DefaultValue\Extension\Core\Type\DefaultType;
use Klipper\Component\DefaultValue\ObjectFactoryInterface;
use Klipper\Component\DefaultValue\ObjectTypeInterface;
use Klipper\Component\DefaultValue\ResolvedObjectType;
use Klipper\Component\DefaultValue\Tests\Fixtures\Extension\UserExtension;
use Klipper\Component\DefaultValue\Tests\Fixtures\Type\FooType;
use Klipper\Component\DefaultValue\Tests\Fixtures\Type\UserType;
use PHPUnit\Framework\TestCase;

/**
 * @author François Pluchino <francois.pluchino@klipper.dev>
 *
 * @internal
 */
final class ResolvedObjectTypeTest extends TestCase
{
    public function testClassUnexist(): void
    {
        $this->expectException(\Klipper\Component\DefaultValue\Exception\InvalidArgumentException::class);

        $type = $this->getMockBuilder('Klipper\Component\DefaultValue\ObjectTypeInterface')->getMock();
        $type->expects(static::any())
            ->method('getClass')
            ->willReturn('Klipper\Component\DefaultValue\Tests\Fixtures\Object\UnexistClass')
        ;

        /* @var ObjectTypeInterface $type */
        new ResolvedObjectType($type);
    }

    public function testWrongExtensions(): void
    {
        $this->expectException(\Klipper\Component\DefaultValue\Exception\UnexpectedTypeException::class);

        $type = new UserType();

        new ResolvedObjectType($type, ['wrong_extension']);
    }

    public function testBasicOperations(): void
    {
        $parentType = new DefaultType();
        $type = new UserType();
        $rType = new ResolvedObjectType($type, [new UserExtension()], new ResolvedObjectType($parentType));

        static::assertEquals($type->getClass(), $rType->getClass());
        static::assertInstanceOf('Klipper\Component\DefaultValue\ResolvedObjectTypeInterface', $rType->getParent());
        static::assertEquals($type, $rType->getInnerType());

        $exts = $rType->getTypeExtensions();
        static::assertIsArray($exts);
        static::assertCount(1, $exts);

        $options = $rType->getOptionsResolver();
        static::assertInstanceOf('Symfony\Component\OptionsResolver\OptionsResolver', $options);
    }

    public function testInstanceBuilder(): void
    {
        $rType = $this->getResolvedType();
        /** @var ObjectFactoryInterface $factory */
        $factory = $this->getMockBuilder('Klipper\Component\DefaultValue\ObjectFactoryInterface')->getMock();
        $builder = $rType->createBuilder($factory, []);

        static::assertInstanceOf('Klipper\Component\DefaultValue\ObjectBuilderInterface', $builder);
        static::assertEquals($rType, $builder->getType());

        $instance = $rType->newInstance($builder, $builder->getOptions());

        $rType->buildObject($builder, $builder->getOptions());
        $rType->finishObject($builder, $builder->getOptions());

        static::assertInstanceOf($rType->getClass(), $instance);
        static::assertEquals('test', $instance->getUsername());
        static::assertEquals('password', $instance->getPassword());
    }

    public function testInstanceBuilderWithDefaultType(): void
    {
        $type = new FooType();
        $parentType = new DefaultType($type->getClass());
        $rType = new ResolvedObjectType($type, [], new ResolvedObjectType($parentType));

        /** @var ObjectFactoryInterface $factory */
        $factory = $this->getMockBuilder('Klipper\Component\DefaultValue\ObjectFactoryInterface')->getMock();
        $builder = $rType->createBuilder($factory, []);

        static::assertInstanceOf('Klipper\Component\DefaultValue\ObjectBuilderInterface', $builder);
        static::assertEquals($rType, $builder->getType());

        $instance = $rType->newInstance($builder, $builder->getOptions());

        $rType->buildObject($builder, $builder->getOptions());
        $rType->finishObject($builder, $builder->getOptions());

        static::assertInstanceOf($rType->getClass(), $instance);
    }

    /**
     * Gets resolved type.
     *
     * @return ResolvedObjectType
     */
    private function getResolvedType()
    {
        $type = new UserType();
        $parentType = new DefaultType($type->getClass());

        return new ResolvedObjectType($type, [new UserExtension()], new ResolvedObjectType($parentType));
    }
}
