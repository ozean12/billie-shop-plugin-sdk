<?php

namespace Billie\Sdk\Model\Response;

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
        $this->checkoutSessionId = $data['id'];
        return $this;
    }

}
