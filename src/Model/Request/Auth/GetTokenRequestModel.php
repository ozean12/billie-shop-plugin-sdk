<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Model\Request\Auth;

use Billie\Sdk\Model\Request\AbstractRequestModel;

/**
 * @method self   setClientId(string $clientId)
 * @method string getClientId()
 * @method self   setClientSecret(string $clientSecret)
 * @method string getClientSecret()
 */
class GetTokenRequestModel extends AbstractRequestModel
{
    protected string $clientId;

    protected string $clientSecret;

    protected function _toArray(): array
    {
        return [
            'grant_type' => 'client_credentials',
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
        ];
    }
}
