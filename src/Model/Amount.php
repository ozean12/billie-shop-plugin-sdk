<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Model;

use Billie\Sdk\Exception\Validation\InvalidFieldValueException;
use RuntimeException;

/**
 * @method $this  setNet(float $net)
 * @method float getNet()
 * @method $this  setGross(float $gross)
 * @method float getGross()
 * @method $this  setTax(float $tax)
 */
class Amount extends AbstractModel
{
    protected ?float $net;

    protected ?float $gross;

    protected ?float $tax;

    /**
     * @throws InvalidFieldValueException
     */
    public function setTaxRate(float $taxRate): self
    {
        if (isset($this->net)) {
            $this->tax = $this->net * ($taxRate / 100);

            $gross = $this->net + $this->tax;
            if (!isset($this->gross)) {
                $this->gross = $gross;
            } elseif ($this->gross !== $gross) {
                throw new InvalidFieldValueException('the set value of `gross` does not match the calculated value of ' . $gross . '. Please do net set the `gross` value, or set the correct value');
            }
        } elseif ($this->gross ?? false) {
            $this->tax = $this->gross - ($this->gross / ($taxRate / 100 + 1));

            $this->net = $this->gross - $this->tax;
        } else {
            throw new RuntimeException('please set the `net` or `gross` value first.');
        }

        return $this;
    }

    public function getTax(): float
    {
        return $this->tax ?? ($this->gross - $this->net);
    }

    protected function prepareValuesForGateway(array $data): array
    {
        $data['tax'] ??= $this->getTax();

        return $data;
    }

    protected function getFieldValidations(): array
    {
        return [
            'net' => 'float',
            'gross' => 'float',
        ];
    }
}
