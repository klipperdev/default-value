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
abstract class AbstractSimpleType extends AbstractType
{
    /**
     * @var string
     */
    protected $class;

    /**
     * Constructor.
     *
     * @param string $class The class name
     */
    public function __construct($class)
    {
        $this->class = $class;
    }

    /**
     * {@inheritdoc}
     */
    public function getClass()
    {
        return $this->class;
    }
}
