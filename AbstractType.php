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

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author François Pluchino <francois.pluchino@klipper.dev>
 */
abstract class AbstractType implements ObjectTypeInterface
{
    /**
     * {@inheritdoc}
     */
    public function newInstance(ObjectBuilderInterface $builder, array $options)
    {
        $class = $this->getClass();

        return new $class();
    }

    /**
     * {@inheritdoc}
     */
    public function buildObject(ObjectBuilderInterface $builder, array $options): void
    {
    }

    /**
     * {@inheritdoc}
     */
    public function finishObject(ObjectBuilderInterface $builder, array $options): void
    {
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'default';
    }
}
