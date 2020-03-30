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
 * The central registry of the Object Default Value component.
 *
 * @author François Pluchino <francois.pluchino@klipper.dev>
 */
interface ObjectRegistryInterface
{
    /**
     * Returns a object default value type by name.
     *
     * This methods registers the type extensions object default value and the object default value extensions.
     *
     * @param string $classname The class name of the type
     *
     * @throws Exception\UnexpectedTypeException If the passed name is not a string
     *
     * @return ResolvedObjectTypeInterface The type
     */
    public function getType($classname);

    /**
     * Returns whether the given object default value type is supported.
     *
     * @param string $classname The class name of the type
     *
     * @return bool Whether the type is supported
     */
    public function hasType($classname);

    /**
     * Returns the extensions loaded by the framework.
     *
     * @return array
     */
    public function getExtensions();
}
