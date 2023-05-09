<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Model\Response;

use Billie\Sdk\Util\ResponseHelper;

/**
 * @method string getUuid()
 */
class CreateInvoiceResponseModel extends AbstractResponseModel
{
    protected string $uuid;

    public function fromArray(array $data): self
    {
        $this->uuid = ResponseHelper::getStringNN($data, 'uuid');

        return $this;
    }
}
