<?php


namespace Billie\Sdk\Model;


use BadMethodCallException;
use Billie\Sdk\Exception\Validation\InvalidFieldException;

abstract class AbstractModel
{
    /**
     * @param string $name
     * @return mixed
     * @throws InvalidFieldException
     */
    private function get($name)
    {
        if (property_exists($this, $name)) {
            return $this->{$name};
        }
        throw new InvalidFieldException($name, $this);
    }

    public function __call($name, $arguments)
    {
        $field = lcfirst(substr($name, 3));

        if (strpos($name, 'set') === 0 && method_exists($this, 'set')) {
            return call_user_func_array([$this, 'set'], array_merge([$field], $arguments));
        }
        if (strpos($name, 'get') === 0 || strpos($name, 'is') === 0) {
            return call_user_func_array([$this, 'get'], array_merge([$field], $arguments));
        }
        throw new BadMethodCallException('Method `' . $name . '` does not exists on `' . self::class . '`');
    }
}