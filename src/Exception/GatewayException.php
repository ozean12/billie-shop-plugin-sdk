<?php

namespace Billie\Sdk\Exception;

class GatewayException extends BillieException
{
    /**
     * @var array
     */
    private $responseData;

    public function __construct($defaultMessage, $httpCode, $responseData = [])
    {
        parent::__construct($defaultMessage, $httpCode);
        $this->responseData = $responseData;

        if (isset($responseData['errors']) && count($responseData['errors']) === 1) {
            $messages = [];
            $codes = [];
            foreach ($responseData['errors'] as $error) {
                $message = $error['title'];

                if (isset($error['source'])) {
                    $message = $error['source'] . ': ' . $message;
                }
                $messages[] = $message;
                $codes[] = $error['title'];
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
}
