<?php

namespace Billie\Sdk\Service\Request;

use Billie\Sdk\Exception\BillieException;
use Billie\Sdk\Exception\Validation\InvalidFieldValueCollectionException;
use Billie\Sdk\HttpClient\BillieClient;
use Billie\Sdk\Model\Request\AbstractRequestModel;
use Billie\Sdk\Model\Response\AbstractResponseModel;
use Exception;
use InvalidArgumentException;

abstract class AbstractRequest
{
    /**
     * @var BillieClient
     */
    protected $client;

    /**
     * @var bool
     */
    protected $cacheable = false;

    /**
     * @var int
     */
    protected $cacheTtl = 3600;

    public function __construct(BillieClient $billieClient = null)
    {
        $this->client = $billieClient;
    }

    /**
     * @return void
     */
    final public function setClient(BillieClient $client)
    {
        $this->client = $client;
    }

    /**
     * @throws BillieException
     * @throws InvalidFieldValueCollectionException
     *
     * @return AbstractResponseModel|bool
     */
    public function execute(AbstractRequestModel $requestModel)
    {
        try {
            if ($this->client === null) {
                throw new InvalidArgumentException('please set a BillieClient instance to this request-service. Use the parameter in the constructor or use the function `setClient` to set the client-instance.');
            }

            $requestModel->validateFields();

            $response = $this->loadFromCache($requestModel);

            $response = $response ?: $this->client->request(
                $this->getPath($requestModel),
                $requestModel->toArray(),
                $this->getMethod($requestModel),
                $this->isAuthorisationRequired($requestModel)
            );
            $this->writeToCache($requestModel, $response);
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
     * @return array|null
     */
    protected function loadFromCache(AbstractRequestModel $requestModel)
    {
        if ($this->cacheable) {
            $file = sys_get_temp_dir() . '/' . $this->getCacheFileName($requestModel);
            if (file_exists($file)) {
                if (filemtime($file) + $this->cacheTtl > time()) {
                    try {
                        $content = unserialize(file_get_contents($file), ['allowed_classes' => false]);

                        return is_array($content) ? $content : null;
                    } catch (Exception $exception) {
                        return null;
                    }
                } else {
                    unlink($file);
                }
            }
        }

        return null;
    }

    /**
     * @param array $data
     *
     * @return void
     */
    protected function writeToCache(AbstractRequestModel $requestModel, $data)
    {
        if ($this->cacheable) {
            $file = sys_get_temp_dir() . '/' . $this->getCacheFileName($requestModel);
            if (file_exists($file) === false) {
                try {
                    $content = serialize($data);
                    file_put_contents($file, $content);
                } catch (Exception $exception) {
                }
            }
        }
    }

    /**
     * @return string
     */
    protected function getCacheFileName(AbstractRequestModel $requestModel)
    {
        $cacheFile = get_class($this) . '_' . md5(serialize($requestModel->toArray())) . '.txt';

        return str_replace('\\', '_', $cacheFile);
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
    protected function processSuccess(AbstractRequestModel $requestModel, $responseData)
    {
        return true;
    }

    /**
     * @return void
     */
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
