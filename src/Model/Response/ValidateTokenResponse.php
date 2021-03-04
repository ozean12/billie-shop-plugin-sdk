<?php

namespace Billie\Sdk\Model\Response;

use Billie\Sdk\Util\ResponseHelper;

/**
 * @method string getClientId()
 * @method array  getScopes()
 */
class ValidateTokenResponse extends AbstractResponseModel
{
    /**
     * @var string
     */
    protected $clientId;

    /**
     * @var string[]
     */
    protected $scopes;

    public function fromArray($data)
    {
        $this->clientId = ResponseHelper::getValue($data, 'client_id');
        $this->scopes = ResponseHelper::getValue($data, 'scopes');

        return $this;
    }
}
