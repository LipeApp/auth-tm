<?php

namespace Seshpulatov\AuthTm;

use http\Exception\InvalidArgumentException;

/**
 * @property-read int|string $id
 * @property-read int|string $full_name
 * @property-read int|string $phone
 */
class User
{
    public array $data = [];

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function __get(string $name)
    {

        if (isset($this->data[$name])) {
            return $this->data[$name];
        }

        throw new InvalidArgumentException();

    }

}
