<?php


namespace Billie\Sdk\Model\Response;


/**
 * @method string getClientId()
 * @method array getScopes()
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
        $this->clientId = $data['client_id'];
        $this->scopes = $data['scopes'];
        return $this;
    }
}