<?php

namespace ahmedWeb\LivePlatformManager\Response;

class DataFailed extends DataStatus
{
    public function __construct(array $errors = [], bool $status = false, int $statusCode = 500, string $message = '', $data = null)
    {
        // dd($status);
        parent::setData($data);
        parent::setErrors($errors);
        parent::setStatus($status);
        parent::setStatusCode($statusCode);
        parent::setMessage($message);
    }
}
