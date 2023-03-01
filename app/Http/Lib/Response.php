<?php

namespace App\Http\Lib;


class Response {
    private $status = "success",
    $message = "Success",
    $data = [],
    $code = 200;

    public function send() {
        return response()->json([
            "status" => $this->status,
            "message" => $this->message,
            "data" => $this->data
        ], $this->code);
    }

    public function data(Array $data) {
        $this->data = $data;
        return $this;
    }

    public function message(string $message) {
        $this->message = $message;
        return $this;
    }

    public function status(string $status) {
        $this->status = $status;
        return $this;
    }

    public function code(string $code) {
        $this->code = $code;
        return $this;
    }
}
