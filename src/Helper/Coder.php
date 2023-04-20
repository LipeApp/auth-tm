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
        return config('auth-tm.key');
    }


    public function getCipher(): string
    {
        return 'aes-256-cbc';
    }

    /**
     * @param string|null $text
     * @return string
     */
    public function encrypt($text): string
    {
        if (empty($text) || !is_string($text)) {
            return '';
        }
        return $this->model->encrypt($text);
    }


    /**
     * @param string|null $text
     * @return string
     */
    public function decrypt($text): string
    {
        if (empty($text) || !is_string($text)) {
            return '';
        }
        return $this->model->decrypt($text);
    }
}
