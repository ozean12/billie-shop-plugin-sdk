<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Model\Request;

/**
 * @method self setNumberOfDays(int $numberOfDays)
 * @method int  getNumberOfDays()
 */
class PauseOrderDunningProcessRequestModel extends OrderRequestModel
{
    protected ?int $numberOfDays = null;

    protected function getFieldValidations(): array
    {
        return array_merge(parent::getFieldValidations(), [
            'numberOfDays' => 'integer',
        ]);
    }

    protected function _toArray(): array
    {
        return array_merge(parent::_toArray(), [
            'number_of_days' => $this->getNumberOfDays(),
        ]);
    }
}
