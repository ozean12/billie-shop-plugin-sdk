<?php


namespace Billie\Sdk\Model\Request;


/**
 * @method self setClientId(string $clientId)
 * @method string getClientId()
 * @method self setClientSecret(string $clientSecret)
 * @method string getClientSecret()
 */
class GetTokenRequestModel extends AbstractRequestModel
{

    /**
     * @var string
     */
    protected $clientId;

    /**
     * @var string
     */
    protected $clientSecret;

    /**
     * @return string[]
     */
    public function toArray()
    {
        return [
            'grant_type' => 'client_credentials',
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret
        ];
    }

    public function getFieldValidations()
    {
        return [
            'clientId' => 'string',
            'clientSecret' => 'string',
        ];
    }
}