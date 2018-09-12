<?php

namespace Gina\Controllers;

class CrappyResponse
{
    private $data = [];
    private $err = true;

    private function __construct($data, $err)
    {
        $this->data = $data;
        $this->err = $err;
    }

    public static function json($data, $ok)
    {
        return new self($data, $ok);
    }

    public static function unexpectedError($msg)
    {
        return new self($msg, false);
    }

    public function execute()
    {
        $encoded = json_encode(['data' => $this->data, 'ok' => $this->err,]);
        header('Content-type: application/json');

        exit($encoded);
    }

    public function getData()
    {
        return $this->data;
    }

    public function getErr()
    {
        return !$this->err;

    }
}
