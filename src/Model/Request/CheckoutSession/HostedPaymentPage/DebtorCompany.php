<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Model\Request\CheckoutSession\HostedPaymentPage;

use BadMethodCallException;
use Billie\Sdk\Model\Address;
use Billie\Sdk\Model\AddressWithAddition;
use Billie\Sdk\Model\Request\Order\CreateOrder\Debtor;
use Billie\Sdk\Util\ArrayHelper;

/**
 * @method AddressWithAddition getCompanyAddress()
 * @method $this setCompanyAddress(AddressWithAddition $companyAddress)
 * @method string getOrganisationType()
 * @method $this setOrganisationType(string $organisationType)
 */
class DebtorCompany extends Debtor
{
    protected ?string $organisationType = null;

    /**
     * @deprecated
     * @return never
     */
    public function getBillingAddress()
    {
        throw new BadMethodCallException('this method is not callable. please use `getCompanyAddress`.');
    }

    /**
     * @deprecated
     * @return never
     */
    public function setBillingAddress(Address $billingAddress): Debtor
    {
        throw new BadMethodCallException('this method is not callable. please use `setCompanyAddress`.');
    }

    protected function prepareValuesForGateway(array $data): array
    {
        $data = array_merge(
            parent::prepareValuesForGateway($data),
            ArrayHelper::addPrefixToKeys($this->companyAddress->toArray(), 'address_'),
        );
        unset($data['companyAddress']);
        unset($data['billingAddress']);

        return $data;
    }
}
