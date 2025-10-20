<?php

namespace App\Helpers;

use App\Models\Notification;

class NotificationHelper
{
    public static function send($employeeId, $title, $message)
    {
        Notification::create([
            'employee_id' => $employeeId,
            'title' => $title,
            'message' => $message,
            'is_read' => false,
        ]);
    }
}
