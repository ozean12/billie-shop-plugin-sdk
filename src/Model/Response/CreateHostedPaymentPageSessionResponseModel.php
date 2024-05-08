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
use DateTimeInterface;

/**
 * @method string getSessionId()
 * @method DateTime getExpiresAt()
 * @method string getHppUrl()
 */
class CreateHostedPaymentPageSessionResponseModel extends AbstractResponseModel
{
    protected string $sessionId;

    protected DateTimeInterface $expiresAt;

    protected string $hppUrl;

    protected function prepareModelData(array $data): array
    {
        $data['expiresAt'] = ResponseHelper::getDateTime($data, 'expires_at', DateTimeInterface::ATOM);

        return $data;
    }
}
