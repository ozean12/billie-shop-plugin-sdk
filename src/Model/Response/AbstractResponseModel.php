<?php


namespace Billie\Sdk\Model\Response;


use Billie\Sdk\Model\AbstractModel;

abstract class AbstractResponseModel extends AbstractModel
{
    /**
     * @param array $data
     * @return self
     */
    abstract public function fromArray($data);

}