<?php

namespace Seshpulatov\AuthTm;

/**
 * @property-read int|string $id
 * @property-read int|string $full_name
 * @property-read int|string $phone
 */
class User
{
    public function __construct(public readonly array $data = [])
    {
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function __get(string $name)
    {
        return $this->data[$name] ?? null;
    }

}
