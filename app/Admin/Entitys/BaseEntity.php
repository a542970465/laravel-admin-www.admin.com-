<?php

namespace App\Admin\Entitys;

use Illuminate\Database\Eloquent\Model;

class BaseEntity extends Model
{
    //
    public static function json($status, string $message = '')
    {
        if ($status && $message == null) {
            return ['status' => $status, 'message' => trans('res.OperationSuccess')];
        }

        if (!$status && $message == '') {
            return ['status' => $status, 'message' => trans('res.OperationFailure')];
        }

        return ['status' => $status, 'message' => $message];
    }
}
