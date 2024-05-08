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
use DateTime;
use DateTimeInterface;

/**
 * @method string   getTokenType()
 * @method DateTime getExpires()
 * @method string   getAccessToken()
 */
class GetTokenResponseModel extends AbstractResponseModel
{
    protected string $tokenType;

    protected DateTimeInterface $expires;

    protected ?string $accessToken = null;

    protected function prepareModelData(array $data): array
    {
        return [
            'expires' => (new DateTime())->modify('+' . $data['expires_in'] . ' seconds'),
        ];
    }
}
