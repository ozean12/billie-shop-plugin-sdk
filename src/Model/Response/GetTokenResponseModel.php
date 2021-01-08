<?php


namespace Billie\Sdk\Model\Response;


use DateTime;

/**
 * @method string getTokenType()
 * @method DateTime getExpires()
 * @method string getAccessToken()
 */
class GetTokenResponseModel extends AbstractResponseModel
{

    /**
     * @var string
     */
    protected $tokenType;

    /**
     * @var DateTime
     */
    protected $expires;

    /**
     * @var string
     */
    protected $accessToken;


    public function fromArray($data)
    {
        $this->tokenType = $data['token_type'];
        $this->expires = (new \DateTime())->modify('+' . $data['expires_in'] . ' seconds');
        $this->accessToken = $data['access_token'];
        return $this;
    }
}