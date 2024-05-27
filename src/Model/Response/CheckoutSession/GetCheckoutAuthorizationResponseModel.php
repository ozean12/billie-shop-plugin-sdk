<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Model\Response\CheckoutSession;

use Billie\Sdk\Model\AbstractModel;
use Billie\Sdk\Model\Amount;
use Billie\Sdk\Model\Debtor;
use Billie\Sdk\Model\Response\AbstractResponseModel;
use Billie\Sdk\Util\ArrayHelper;

/**
 * @method string getState()
 * @method string getDeclineReason()
 * @method Amount getAmount()
 * @method Debtor getDebtor()
 */
class GetCheckoutAuthorizationResponseModel extends AbstractResponseModel
{
    protected string $state;

    protected string $declineReason;

    protected Amount $amount;

    protected Debtor $debtor;

    public function fromArray(array $data): AbstractModel
    {
        if (isset($data['debtor']['company_address'])) {
            $data['debtor']['company_address'] = ArrayHelper::removePrefixFromKeys($data['debtor']['company_address'], 'address_');
        }

        return parent::fromArray($data);
    }#
}
