<?php

/*
 * This file is part of the Klipper package.
 *
 * (c) François Pluchino <francois.pluchino@klipper.dev>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Klipper\Component\DefaultValue\Extension\Core;

use Klipper\Component\DefaultValue\AbstractExtension;

/**
 * Represents the main object extension extension, which loads the core functionality.
 *
 * @author François Pluchino <francois.pluchino@klipper.dev>
 */
class CoreExtension extends AbstractExtension
{
    /**
     * {@inheritdoc}
     */
    protected function loadTypes()
    {
        return [];
    }
}
