<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Service\Request;

use Billie\Sdk\Model\Request\GetBankDataRequestModel;
use Billie\Sdk\Model\Response\GetBankDataResponseModel;

/**
 * Note: This is not a real request. This api endpoint is currently in development.
 * Bank data will be provided by a static file in the SDK
 * @extends AbstractRequest<GetBankDataRequestModel, GetBankDataResponseModel>
 * @internal Please note, that this request will vary in the future
 */
class GetBankDataRequest extends AbstractRequest
{
    private GetBankDataResponseModel $_cache;

    public function execute($requestModel): GetBankDataResponseModel
    {
        if (!isset($this->_cache)) {
            $bankData = $this->parseCsv(__DIR__ . '/../../../assets/bankdata.csv');
            $this->_cache = (new GetBankDataResponseModel())->setItems($bankData);
        }

        return $this->_cache;
    }

    protected function getPath($requestModel): string
    {
        return ''; // api route not implemented yet
    }

    protected function parseCsv(string $fileName): array
    {
        $data = [];
        if (($handle = fopen($fileName, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, ';')) !== false) {
                if (is_countable($row) && count($row) === 2 && isset($row[0], $row[1])) {
                    $data[$row[0]] = [
                        'BIC' => $row[0],
                        'Name' => $row[1],
                    ];
                }
            }

            fclose($handle);
        }

        return $data;
    }
}
