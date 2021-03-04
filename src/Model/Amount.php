<?php

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
    /** @var float */
    protected $net;

    /** @var float */
    protected $gross;

    /** @var float */
    protected $tax;

    /**
     * @param float $taxRate
     *
     * @return self
     * @throws InvalidFieldValueException
     *
     */
    public function setTaxRate($taxRate)
    {
        if ($this->net) {
            $this->tax = $this->net * ($taxRate / 100);

            $gross = $this->net + $this->tax;
            if ($this->gross === null) {
                $this->gross = $gross;
            } elseif ($this->gross !== $gross) {
                throw new InvalidFieldValueException('the set value of `gross` does not match the calculated value of ' . $gross . '. Please do net set the `gross` value, of set the correct value');
            }
        } elseif ($this->gross) {
            $this->tax = $this->gross - ($this->gross / ($taxRate / 100 + 1));

            $net = $this->gross - $this->tax;
            if ($this->net === null) {
                $this->net = $net;
            } elseif ($this->net !== $net) {
                throw new InvalidFieldValueException('the set value of `net` does not match the calculated value of ' . $net . '. Please do net set the `net` value, of set the correct value');
            }
        } else {
            throw new RuntimeException('please set the `net` or `gross` value first.');
        }

        return $this;
    }

    /**
     * @return float
     */
    public function getTax()
    {
        return $this->tax ?: ($this->gross - $this->net);
    }

    public function getFieldValidations()
    {
        return [
            'net' => 'float',
            'gross' => 'float',
        ];
    }

    public function toArray()
    {
        return [
            'net' => (float)round($this->getNet(), 2),
            'gross' => (float)round($this->getGross(), 2),
            'tax' => (float)round($this->getTax(), 2),
        ];
    }

    public function fromArray($data)
    {
        $this->net = ResponseHelper::getValue($data, 'net');
        $this->gross = ResponseHelper::getValue($data, 'gross');
        $this->tax = ResponseHelper::getValue($data, 'tax');
    }
}
