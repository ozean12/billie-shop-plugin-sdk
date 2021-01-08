<?php


namespace Billie\Sdk\Model\Request;


/**
 * @link https://developers.billie.io/#operation/oauth_token_create
 *
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
     * RequestTokenModel constructor.
     * @param string $clientId
     * @param string $clientSecret
     */
    public function __construct($clientId, $clientSecret)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
    }

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