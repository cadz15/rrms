<?php

namespace App\Interfaces;

interface NotificationServiceInterface
{
    public function send($to, $from, $content);
}
