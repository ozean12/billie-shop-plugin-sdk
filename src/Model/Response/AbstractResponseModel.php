<?php


namespace Billie\Sdk\Model\Response;


use Billie\Sdk\Model\AbstractModel;

abstract class AbstractResponseModel extends AbstractModel
{
    public function __construct($data = [])
    {
        parent::__construct($data, true);
    }
}