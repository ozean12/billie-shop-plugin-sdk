<?php

namespace Billie\Sdk\Model\Response;

use Billie\Sdk\Util\ResponseHelper;

/**
 * @method string getCheckoutSessionId()
 */
class CreateSessionResponseModel extends AbstractResponseModel
{
    /**
     * @var string
     */
    protected $checkoutSessionId;

    public function fromArray($data)
    {
        $this->checkoutSessionId = ResponseHelper::getValue($data, 'id');
        return $this;
    }

}
