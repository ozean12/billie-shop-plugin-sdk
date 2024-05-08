<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Model\Response;

/**
 * @method string getUuid()
 */
class CreateInvoiceResponseModel extends AbstractResponseModel
{
    protected string $uuid;

    protected function _toArray(): array
    {
        return [];
    }
}
