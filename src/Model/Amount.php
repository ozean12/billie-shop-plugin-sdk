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
use Billie\Sdk\Util\ResponseHelper;
use RuntimeException;

/**
 * @method self  setNet(float $net)
 * @method float getNet()
 * @method self  setGross(float $gross)
 * @method float getGross()
 * @method self  setTax(float $tax)
 */
class Amount extends AbstractModel
{
    protected ?float $net = null;

    protected ?float $gross = null;

    protected ?float $tax = null;

    /**
     * @throws InvalidFieldValueException
     */
    public function setTaxRate(float $taxRate): self
    {
        if ($this->net !== null) {
            $this->tax = $this->net * ($taxRate / 100);

            $gross = $this->net + $this->tax;
            if ($this->gross === null) {
                $this->gross = $gross;
            } elseif ($this->gross !== $gross) {
                throw new InvalidFieldValueException('the set value of `gross` does not match the calculated value of ' . $gross . '. Please do net set the `gross` value, or set the correct value');
            }
        } elseif ($this->gross !== null) {
            $this->tax = $this->gross - ($this->gross / ($taxRate / 100 + 1));

            $this->net = $this->gross - $this->tax;
        } else {
            throw new RuntimeException('please set the `net` or `gross` value first.');
        }

        return $this;
    }

    public function getTax(): float
    {
        return $this->tax ?: ($this->gross - $this->net);
    }

    public function fromArray(array $data): self
    {
        $this->net = ResponseHelper::getFloatNN($data, 'net');
        $this->gross = ResponseHelper::getFloatNN($data, 'gross');
        $this->tax = ResponseHelper::getFloatNN($data, 'tax');

        return $this;
    }

    protected function getFieldValidations(): array
    {
        return [
            'net' => 'float',
            'gross' => 'float',
        ];
    }

    protected function _toArray(): array
    {
        return [
            'net' => round($this->getNet(), 2),
            'gross' => round($this->getGross(), 2),
            'tax' => round($this->getTax(), 2),
        ];
    }
}
