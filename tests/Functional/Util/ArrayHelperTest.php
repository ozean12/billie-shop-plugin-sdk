<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Tests\Functional\Util;

use Billie\Sdk\Util\ArrayHelper;
use PHPUnit\Framework\TestCase;

class ArrayHelperTest extends TestCase
{
    public function testReplacePrefixFromKeys(): void
    {
        $prefixedArray = [
            'pReFIX-key1' => 'value1',
            'pReFIX-key2' => 'value2',
            'pReFIX-key3' => 'value3',
            'key4' => 'value4',
            'key5' => 'value5',
        ];

        $result = ArrayHelper::replacePrefixFromKeys($prefixedArray, 'pReFIX-', 'diff-');

        $expected = [
            'diff-key1' => 'value1',
            'diff-key2' => 'value2',
            'diff-key3' => 'value3',
            'key4' => 'value4',
            'key5' => 'value5',
        ];

        static::assertEquals($expected, $result);
    }

    public function testRemovePrefixFromKeys(): void
    {
        $prefixedArray = [
            'pReFIX-key1' => 'value1',
            'pReFIX-key2' => 'value2',
            'pReFIX-key3' => 'value3',
            'key4' => 'value4',
            'key5' => 'value5',
        ];

        $result = ArrayHelper::removePrefixFromKeys($prefixedArray, 'pReFIX-');

        $expected = [
            'key1' => 'value1',
            'key2' => 'value2',
            'key3' => 'value3',
            'key4' => 'value4',
            'key5' => 'value5',
        ];

        static::assertEquals($expected, $result);
    }

    public function testAddPrefix(): void
    {
        $prefixedArray = [
            'key1' => 'value1',
            'key2' => 'value2',
            'key3' => 'value3',
            'key4' => 'value4',
            'key5' => 'value5',
        ];

        $result = ArrayHelper::addPrefixToKeys($prefixedArray, 'pReFIX-');

        $expected = [
            'pReFIX-key1' => 'value1',
            'pReFIX-key2' => 'value2',
            'pReFIX-key3' => 'value3',
            'pReFIX-key4' => 'value4',
            'pReFIX-key5' => 'value5',
        ];

        static::assertEquals($expected, $result);
    }
}
