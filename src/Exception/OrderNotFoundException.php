<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Exception;

class OrderNotFoundException extends EntityNotFoundException
{
    public function getBillieCode(): string
    {
        return 'ORDER_NOT_FOUND';
    }
}
