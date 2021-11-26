## 项目简介

The Aliyun dkms sdk for Laravel(Lumen).

## 安装

```bash
composer require "talk-lucky/dkms-laravel"
```

## 使用

```php
/**
 * @var DkmsClient $kmsClient
 */
$dkmsClient = app("dkms");
$encryptStr = $dkmsClient->encrypt(config("kms.keyId"), "明文");
$decryptStr = $dkmsClient->decrypt(config("kms.keyId"), "密文");
$bool = $dkmsClient->isValidEncryptVal("明文/密文");
```

## 配置

### .env

`.env` 中新增相关配置

```bash
KMS_ENDPOINT=
KMS_PASSWORD=
KMS_CLIENT_KEY_CONTENT=
KMS_CAINFO_PATH=
KMS_CIPHERTEXT_BLOB=
```

### kms.php

新增 `config/dkms.php`

```php
<?php

return [
    "keyId" => env("KMS_KEY_ID", ""),

    "default" => "online",

    "drivers" => [
        "online" => [
            "protocol"         => "https",
            "endpoint"         => env("KMS_ENDPOINT", ""),
            "password"         => env("KMS_PASSWORD", ""),
            "clientKeyContent" => env("KMS_CLIENT_KEY_CONTENT", ""),
            "cainfo"           => env("KMS_CAINFO_PATH", ""),
        ],

        "mail" => [
            "protocol"         => "https",
            "endpoint"         => env("KMS_ENDPOINT", ""),
            "password"         => env("KMS_PASSWORD", ""),
            "clientKeyContent" => env("KMS_CLIENT_KEY_CONTENT", ""),
            "cainfo"           => env("KMS_CAINFO_PATH", ""),
            "keyId"            => env("KMS_KEY_ID", ""),
            "ciphertextBlob"   => env("KMS_CIPHERTEXT_BLOB", ""),
        ]
    ],
];
```

## 注册DKmsServiceProvider

### Laravel

在 `app.php` 中，`providers` 数组最后新增 `\Lucky\Dkms\DKmsServiceProvider::class,`

### Lumen

在 `bootstrap/app.php` 中，新增 `$app->register(\Lucky\Dkms\DKmsServiceProvider::class);`