<?php

namespace Billie\Sdk\Service\Request;

use Billie\Sdk\Model\Request\AbstractRequestModel;
use Billie\Sdk\Model\Request\GetBankDataRequestModel;
use Billie\Sdk\Model\Response\GetBankDataResponseModel;

/**
 * Note: This is not a real request. This api endpoint is currently in development.
 * Bank data will be provided by a static file in the SDK
 *
 * @method GetBankDataResponseModel execute(GetBankDataRequestModel $requestModel)
 *
 * @internal Please note, that this request will vary in the future
 */
class GetBankDataRequest extends AbstractRequest
{
    /**
     * @var GetBankDataResponseModel
     */
    private $_cache;

    public function execute(AbstractRequestModel $requestModel)
    {
        if ($this->_cache === null) {
            $bankData = $this->parseCsv(__DIR__ . '/../../../assets/bankdata.csv');
            $this->_cache = (new GetBankDataResponseModel())->setItems($bankData);
        }

        return $this->_cache;
    }

    protected function getPath(AbstractRequestModel $requestModel)
    {
        return ''; // api route not implemented yet
    }

    /**
     * @param string $fileName file to parse
     *
     * @return array
     */
    protected function parseCsv($fileName)
    {
        $data = [];
        if (($handle = fopen($fileName, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, ';')) !== false) {
                $data[$row[0]] = [
                    'BIC' => $row[0],
                    'Name' => $row[1],
                ];
            }
            fclose($handle);
        }

        return $data;
    }
}
