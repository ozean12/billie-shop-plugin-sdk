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
 * @method string getCheckoutSessionId()
 */
class CreateSessionResponseModel extends AbstractResponseModel
{
    protected string $checkoutSessionId;

    public function fromArray(array $data): self
    {
        $this->checkoutSessionId = ResponseHelper::getStringNN($data, 'id');

        return $this;
    }
}
