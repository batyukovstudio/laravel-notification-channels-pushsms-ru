<?php


namespace NotificationChannels\PushSMS\ApiActions;


use NotificationChannels\PushSMS\ApiActions\Interfaces\ApiAction;

abstract class CoreApiAction implements ApiAction
{

    private function __construct()
    {
        //
    }

    public static function create()
    {
        return new static();
    }

}
