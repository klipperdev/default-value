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

use Klipper\Component\DefaultValue\Exception\InvalidArgumentException;
use Klipper\Component\DefaultValue\Exception\UnexpectedTypeException;

/**
 * @author François Pluchino <francois.pluchino@klipper.dev>
 */
abstract class AbstractExtension implements ObjectExtensionInterface
{
    /**
     * The types provided by this extension.
     *
     * @var array An array of ObjectTypeInterface
     */
    protected $types;

    /**
     * The type extensions provided by this extension.
     *
     * @var array An array of ObjectTypeExtensionInterface
     */
    protected $typeExtensions;

    /**
     * {@inheritdoc}
     */
    public function getType($name)
    {
        if (null === $this->types) {
            $this->initTypes();
        }

        if (!isset($this->types[$name])) {
            throw new InvalidArgumentException(sprintf('The object default value type "%s" can not be loaded by this extension', $name));
        }

        return $this->types[$name];
    }

    /**
     * {@inheritdoc}
     */
    public function hasType($name)
    {
        if (null === $this->types) {
            $this->initTypes();
        }

        return isset($this->types[$name]);
    }

    /**
     * {@inheritdoc}
     */
    public function getTypeExtensions($name)
    {
        if (null === $this->typeExtensions) {
            $this->initTypeExtensions();
        }

        return isset($this->typeExtensions[$name])
            ? $this->typeExtensions[$name]
            : [];
    }

    /**
     * {@inheritdoc}
     */
    public function hasTypeExtensions($name)
    {
        return \count($this->getTypeExtensions($name)) > 0;
    }

    /**
     * Registers the types.
     *
     * @return array An array of ObjectTypeInterface instances
     */
    protected function loadTypes()
    {
        return [];
    }

    /**
     * Registers the type extensions.
     *
     * @return array An array of ObjectTypeExtensionInterface instances
     */
    protected function loadTypeExtensions()
    {
        return [];
    }

    /**
     * Initializes the types.
     *
     * @throws UnexpectedTypeException if any registered type is not an instance of ObjectTypeInterface
     */
    private function initTypes(): void
    {
        $this->types = [];

        foreach ($this->loadTypes() as $type) {
            if (!$type instanceof ObjectTypeInterface) {
                throw new UnexpectedTypeException($type, 'Klipper\Component\DefaultValue\ObjectTypeInterface');
            }

            $this->types[$type->getClass()] = $type;
        }
    }

    /**
     * Initializes the type extensions.
     *
     * @throws UnexpectedTypeException if any registered type extension is not
     *                                 an instance of ObjectTypeExtensionInterface
     */
    private function initTypeExtensions(): void
    {
        $this->typeExtensions = [];

        foreach ($this->loadTypeExtensions() as $extension) {
            if (!$extension instanceof ObjectTypeExtensionInterface) {
                throw new UnexpectedTypeException($extension, 'Klipper\Component\DefaultValue\ObjectTypeExtensionInterface');
            }

            $type = $extension->getExtendedType();

            $this->typeExtensions[$type][] = $extension;
        }
    }
}
