<?php

declare(strict_types=1);

namespace Billie\Sdk\Model\Request;

/**
 * @method self   setClientId(string $clientId)
 * @method string getClientId()
 * @method self   setClientSecret(string $clientSecret)
 * @method string getClientSecret()
 */
class GetTokenRequestModel extends AbstractRequestModel
{
    protected ?string $clientId = null;

    protected ?string $clientSecret = null;

    public function toArray(): array
    {
        return [
            'grant_type' => 'client_credentials',
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
        ];
    }

    public function getFieldValidations(): array
    {
        return [
            'clientId' => 'string',
            'clientSecret' => 'string',
        ];
    }
}
