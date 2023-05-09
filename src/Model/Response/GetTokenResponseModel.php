<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Model\Response;

use Billie\Sdk\Util\ResponseHelper;
use DateTime;

/**
 * @method string   getTokenType()
 * @method DateTime getExpires()
 * @method string   getAccessToken()
 */
class GetTokenResponseModel extends AbstractResponseModel
{
    protected ?string $tokenType = null;

    protected ?DateTime $expires = null;

    protected ?string $accessToken = null;

    public function fromArray(array $data): self
    {
        $this->tokenType = ResponseHelper::getString($data, 'token_type');
        $this->expires = (new DateTime())->modify('+' . $data['expires_in'] . ' seconds');
        $this->accessToken = ResponseHelper::getString($data, 'access_token');

        return $this;
    }
}
