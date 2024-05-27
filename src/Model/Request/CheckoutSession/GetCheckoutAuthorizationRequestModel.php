<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Model\Request\CheckoutSession;

use Billie\Sdk\Model\Request\AbstractRequestModel;

/**
 * @method string getSessionUuid()
 * @method $this setSessionUuid(string $sessionUuid)
 */
class GetCheckoutAuthorizationRequestModel extends AbstractRequestModel
{
    protected static array $_additionalFieldMapping = [
        'sessionUuid' => 'sessionId',
    ];

    protected string $sessionUuid;

    protected function prepareValuesForGateway(array $data): array
    {
        unset($data['sessionUuid']);

        return $data;
    }
}
