<?php

return [
    "default" => "online",

    "drivers" => [
        "online" => [
            "protocol"         => "https",
            "endpoint"         => "",
            "password"         => "",
            "clientKeyContent" => "",
            "cainfo"           => "",
        ],
        "mail" => [
            "protocol"         => "https",
            "endpoint"         => "",
            "password"         => "",
            "clientKeyContent" => "",
            "cainfo"           => "",
            "keyId"            => "",
            "ciphertextBlob"   => "",
        ]
    ],

    // 下面这部分配置可以不填写，依据实际情况引入
    "userAgent"      => "",
    "readTimeout"    => "",
    "connectTimeout" => "",
    "httpProxy"      => "",
    "httpsProxy"     => "",
    "noProxy"        => "",
    "maxIdleConns"   => "",
];
