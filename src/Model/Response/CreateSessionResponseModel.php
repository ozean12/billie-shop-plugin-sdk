<?php

declare(strict_types=1);

namespace Billie\Sdk\Model\Response;

use Billie\Sdk\Util\ResponseHelper;

/**
 * @method string getCheckoutSessionId()
 */
class CreateSessionResponseModel extends AbstractResponseModel
{
    protected ?string $checkoutSessionId = null;

    public function fromArray(array $data): self
    {
        $this->checkoutSessionId = ResponseHelper::getString($data, 'id');

        return $this;
    }
}
