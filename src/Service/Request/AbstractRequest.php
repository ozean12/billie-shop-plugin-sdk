<?php

namespace Billie\Sdk\Service\Request;

use Billie\Sdk\HttpClient\BillieClient;
use Billie\Sdk\Model\Request\AbstractRequestModel;
use Billie\Sdk\Model\Response\AbstractResponseModel;
use Exception;

abstract class AbstractRequest
{
    /**
     * @var BillieClient
     */
    protected $client;

    public function __construct(BillieClient $billieClient)
    {
        $this->client = $billieClient;
    }

    /**
     * @throws \Billie\Sdk\Exception\BillieException
     * @throws \Billie\Sdk\Exception\Validation\InvalidFieldValueCollectionException
     *
     * @return AbstractResponseModel|bool
     */
    final public function execute(AbstractRequestModel $requestModel)
    {
        try {
            $requestModel->validateFields();

            $response = $this->client->request(
                $this->getPath($requestModel),
                $requestModel->toArray(),
                $this->getMethod($requestModel),
                $this->isAuthorisationRequired($requestModel)
            );
        } catch (Exception $exception) {
            $this->processFailed($requestModel, $exception);
//            throw new BillieException(
//                'An error occurred during the API request to the Billie gateway.',
//                null,
//                $exception
//            );
            throw $exception;
        }

        return $this->processSuccess($requestModel, $response);
    }

    /**
     * @return string
     */
    abstract protected function getPath(AbstractRequestModel $requestModel);

    /**
     * @param array|null $responseData
     *
     * @return AbstractResponseModel|bool
     */
    abstract protected function processSuccess(AbstractRequestModel $requestModel, $responseData);

    protected function processFailed(AbstractRequestModel $requestModel, Exception $exception)
    {
    }

    /**
     * @return string
     */
    protected function getMethod(AbstractRequestModel $requestModel)
    {
        return BillieClient::METHOD_GET;
    }

    /**
     * @return bool
     */
    protected function isAuthorisationRequired(AbstractRequestModel $requestModel)
    {
        return true;
    }
}
