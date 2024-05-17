<?php

namespace App\Http\Controllers\Traits\General;

trait Responseable
{
    public function validateResponseFail($validate)
    {
        return response(
            [
                'code' => 0,
                'data' => [],
                'message' => $validate->errors()->first()
            ]
        );
    }

    public function response($code, $data, $meta, $message, $type = null)
    {
        return response(
            [
                'code' => (int)$code,
                'data' => $data,
                'meta' => $meta,
                'message' => $message,
                'type' => $type
            ]
        );
    }
}
