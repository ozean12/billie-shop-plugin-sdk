<?php

namespace Billie\Sdk\Exception;

class GatewayException extends BillieException
{
    /**
     * @var array
     */
    private $responseData;

    /**
     * @var array
     */
    private $requestData;

    /**
     * @param string $defaultMessage
     * @param int    $httpCode
     * @param array  $responseData
     * @param array  $requestData
     */
    public function __construct($defaultMessage, $httpCode, $responseData = [], $requestData = [])
    {
        parent::__construct($defaultMessage, (string) $httpCode);
        $this->responseData = $responseData;
        $this->requestData = $requestData;

        if (isset($responseData['errors']) && count($responseData['errors']) === 1) {
            $messages = [];
            $codes = [];
            foreach ($responseData['errors'] as $error) {
                $message = $error['title'];

                if (isset($error['source'])) {
                    $message = $error['source'] . ': ' . $message;
                }
                $messages[] = $message;
                $codes[] = $error['code'];
            }

            $this->message = implode(', ', $messages);
            $this->billieCode = implode(', ', $codes);
        }
    }

    /**
     * @return array
     */
    public function getResponseData()
    {
        return $this->responseData;
    }

    /**
     * @return array
     */
    public function getRequestData()
    {
        return $this->requestData;
    }
}
