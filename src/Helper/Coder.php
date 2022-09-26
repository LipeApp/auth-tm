<?php

namespace Seshpulatov\AuthTm\Helper;
use Illuminate\Encryption\Encrypter;

class Coder
{
    public Encrypter $model;

    public function __construct()
    {
        $this->model = new Encrypter($this->getSecret(), $this->getCipher());
    }

    public function getSecret(): string
    {
        return config('auth_tm.key');
    }


    public function getCipher(): string
    {
        return 'aes-256-cbc';
    }


    public function encrypt(string $text): string
    {
        return $this->model->encrypt($text);
    }


    public function decrypt(string $text) : string
    {
        return $this->model->decrypt($text);
    }
}
