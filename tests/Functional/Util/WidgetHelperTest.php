<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Tests\Functional\Util;

use Billie\Sdk\Util\WidgetHelper;
use PHPUnit\Framework\TestCase;

class WidgetHelperTest extends TestCase
{
    public function testValidUrl(): void
    {
        static::assertIsArray(parse_url(WidgetHelper::getWidgetUrl(true)), 'Sandbox url should be valid');
        static::assertIsArray(parse_url(WidgetHelper::getWidgetUrl(false)), 'Production url should be valid');
    }
}
