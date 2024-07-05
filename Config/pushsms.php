<?php
return [
    'access_token'    => env('PUSHSMS_TOKEN', null),
    'sender_name'     => env('PUSHSMS_SENDER_NAME', null),
    'timeout'         => 5,
    'connect_timeout' => 5,
    'content_prefix'  => env('PUSHSMS_CONTENT_PREFIX', null),
];
