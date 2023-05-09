<?php

declare(strict_types=1);

namespace Billie\Sdk\Service\Request;

use Billie\Sdk\Exception\BillieException;
use Billie\Sdk\Exception\Validation\InvalidFieldValueCollectionException;
use Billie\Sdk\HttpClient\BillieClient;
use Billie\Sdk\Model\AbstractModel;
use Billie\Sdk\Model\Request\AbstractRequestModel;
use Exception;
use InvalidArgumentException;

/**
 * @template T_RequestModel of AbstractRequestModel
 * @template T_ResponseModel of AbstractModel|bool
 */
abstract class AbstractRequest
{
    protected ?BillieClient $client;

    protected bool $cacheable = false;

    protected int $cacheTtl = 3600;

    public function __construct(BillieClient $billieClient = null)
    {
        $this->client = $billieClient;
    }

    final public function setClient(BillieClient $client): void
    {
        $this->client = $client;
    }

    /**
     * @param T_RequestModel $requestModel
     * @return T_ResponseModel
     * @throws InvalidFieldValueCollectionException
     * @throws BillieException
     */
    public function execute($requestModel)
    {
        try {
            if (!$this->client instanceof BillieClient) {
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

    protected function loadFromCache(AbstractRequestModel $requestModel): ?array
    {
        if ($this->cacheable) {
            $file = sys_get_temp_dir() . '/' . $this->getCacheFileName($requestModel);
            if (file_exists($file) && is_readable($file)) {
                if (filemtime($file) + $this->cacheTtl > time()) {
                    try {
                        $content = unserialize((string) file_get_contents($file), [
                            'allowed_classes' => false,
                        ]);

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

    protected function writeToCache(AbstractRequestModel $requestModel, array $data): void
    {
        if ($this->cacheable) {
            $file = sys_get_temp_dir() . '/' . $this->getCacheFileName($requestModel);
            if (!file_exists($file)) {
                try {
                    $content = serialize($data);
                    file_put_contents($file, $content);
                } catch (Exception $exception) {
                }
            }
        }
    }

    protected function getCacheFileName(AbstractRequestModel $requestModel): string
    {
        $cacheFile = static::class . '_' . md5(serialize($requestModel->toArray())) . '.txt';

        return str_replace('\\', '_', $cacheFile);
    }

    /**
     * @param T_RequestModel $requestModel
     */
    abstract protected function getPath($requestModel): string;

    /**
     * @param T_RequestModel $requestModel
     * @return T_ResponseModel
     */
    protected function processSuccess($requestModel, ?array $responseData = null)
    {
        return true;
    }

    /**
     * @param T_RequestModel $requestModel
     */
    protected function processFailed($requestModel, Exception $exception): void
    {
    }

    /**
     * @param T_RequestModel $requestModel
     */
    protected function getMethod($requestModel): string
    {
        return BillieClient::METHOD_GET;
    }

    /**
     * @param T_RequestModel $requestModel
     */
    protected function isAuthorisationRequired($requestModel): bool
    {
        return true;
    }
}
