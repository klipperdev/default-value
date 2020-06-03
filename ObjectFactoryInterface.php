<?php

/*
 * This file is part of the Klipper package.
 *
 * (c) François Pluchino <francois.pluchino@klipper.dev>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Klipper\Component\DefaultValue;

/**
 * @author François Pluchino <francois.pluchino@klipper.dev>
 */
interface ObjectFactoryInterface
{
    /**
     * Returns a object with the default value.
     *
     * @see create()
     *
     * @param mixed $data    The object instance
     * @param array $options The options
     *
     * @throws Exception\UnexpectedTypeException if any given option is not applicable to the given type or data is not
     *                                           an object
     *
     * @return object The object instance defined by the type
     */
    public function inject($data, array $options = []): object;

    /**
     * Returns a object with the default value.
     *
     * @see createBuilder()
     *
     * @param ObjectTypeInterface|string $type    The type of the object default value
     * @param null|object                $data    The object instance
     * @param array                      $options The options
     *
     * @throws Exception\UnexpectedTypeException if any given option is not applicable to the given type
     *
     * @return object The object instance defined by the type
     */
    public function create($type, ?object $data = null, array $options = []): object;

    /**
     * Returns a block builder.
     *
     * @param ObjectTypeInterface|string $type    The type of the object default value
     * @param null|object                $data    The object instance
     * @param array                      $options The options
     *
     * @throws Exception\UnexpectedTypeException if any given option is not applicable to the given type
     *
     * @return ObjectBuilderInterface The object default value builder
     */
    public function createBuilder($type, ?object $data = null, array $options = []): ObjectBuilderInterface;
}
