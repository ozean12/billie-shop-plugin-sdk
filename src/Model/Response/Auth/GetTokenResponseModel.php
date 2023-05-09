<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Model\Response\Auth;

use Billie\Sdk\Model\Response\AbstractResponseModel;
use Billie\Sdk\Util\ResponseHelper;
use DateTime;

/**
 * @method string   getTokenType()
 * @method DateTime getExpires()
 * @method string   getAccessToken()
 */
class GetTokenResponseModel extends AbstractResponseModel
{
    protected string $tokenType;

    protected DateTime $expires;

    protected ?string $accessToken = null;

    public function fromArray(array $data): self
    {
        $this->tokenType = ResponseHelper::getStringNN($data, 'token_type');
        $this->expires = (new DateTime())->modify('+' . $data['expires_in'] . ' seconds');
        $this->accessToken = ResponseHelper::getStringNN($data, 'access_token');

        return $this;
    }
}
