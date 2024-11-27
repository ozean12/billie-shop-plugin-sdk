<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Model\Request\Invoice;

use Billie\Sdk\Model\Amount;
use Billie\Sdk\Util\ArrayHelper;

class LineItem extends \Billie\Sdk\Model\LineItem
{
    protected static array $_additionalFieldMapping = [
        'amount' => false,
    ];

    /**
     * @deprecated do not use the constructor anymore. will be removed in the future
     */
    public function __construct(string $externalId = null, int $quantity = null)
    {
        parent::__construct();

        $this->externalId = $externalId;
        $this->quantity = $quantity;
    }

    protected function prepareValuesForGateway(array $data): array
    {
        return array_merge(
            parent::prepareValuesForGateway($data),
            ($this->amount ?? null) instanceof Amount ? ArrayHelper::addPrefixToKeys($this->amount->toArray($this->_validateOnSet), 'amount_') : []
        );
    }

    protected function getFieldValidations(): array
    {
        return array_merge(
            parent::getFieldValidations(),
            [
                'amount' => '?' . Amount::class,
            ]
        );
    }
}
