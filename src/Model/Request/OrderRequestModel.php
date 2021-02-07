<?php


namespace Billie\Sdk\Model\Request;


/**
 * @method string getId()
 * @method self setId(string $id)
 */
class OrderRequestModel extends AbstractRequestModel
{

    /**
     * Uuid or the order-id
     * @var string
     */
    protected $id;

    /**
     * @param string $uuid
     */
    public function __construct($uuid)
    {
        parent::__construct();
        $this->setId($uuid);
    }

    public function getFieldValidations()
    {
        return [
            'id' => 'string'
        ];
    }

    public function toArray()
    {
        return [];
    }
}