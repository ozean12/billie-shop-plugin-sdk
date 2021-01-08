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

    /**
     * @param BillieClient $billieClient
     */
    public function __construct(BillieClient $billieClient)
    {
        $this->client = $billieClient;
    }

    final public function execute(AbstractRequestModel $requestModel)
    {
        try {
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
     * @param AbstractRequestModel $requestModel
     * @return string
     */
    abstract protected function getPath(AbstractRequestModel $requestModel);

    /**
     * @param AbstractRequestModel $requestModel
     * @param array|null $responseData
     * @return AbstractResponseModel
     */
    abstract protected function processSuccess(AbstractRequestModel $requestModel, $responseData);

    /**
     * @param AbstractRequestModel $requestModel
     * @param Exception $exception
     */
    protected function processFailed(AbstractRequestModel $requestModel, Exception $exception)
    {
    }

    /**
     * @param AbstractRequestModel $requestModel
     * @return string
     */
    protected function getMethod(AbstractRequestModel $requestModel)
    {
        return BillieClient::METHOD_GET;
    }

    /**
     * @param AbstractRequestModel $requestModel
     * @return bool
     */
    protected function isAuthorisationRequired(AbstractRequestModel $requestModel)
    {
        return true;
    }

}