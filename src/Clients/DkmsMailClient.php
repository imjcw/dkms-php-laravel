<?php

namespace Lucky\Dkms\Clients;

use Lucky\Dkms\DkmsInterface;
use Lucky\Encryption\AESEncrypter;

/**
 * DkmsMailClient
 */
class DkmsMailClient implements DkmsInterface
{
    /**
     * @var AESEncrypter
     */
    protected $client;

    /**
     * construct
     *
     * @param array $config 配置
     * @throws \Exception
     */
    function __construct(array $config)
    {
        $client = new DKmsClient($config);

        $this->client = new AESEncrypter(base64_decode($client->decrypt($config["keyId"], $config["ciphertextBlob"])));
    }

    /**
     * encrypt
     *
     * @param  string $keyId
     * @param  string $val 明文
     * @throws \Exception
     *
     * @return string 密文
     */
    public function encrypt($keyId, $val)
    {
        unset($keyId);
        return $this->client->encrypt($val);
    }

    /**
     * decrypt
     *
     * @param  string $keyId
     * @param  string $val 密文
     * @throws \Exception
     *
     * @return string 明文
     */
    public function decrypt($keyId, $val)
    {
        unset($keyId);
        return $this->client->decrypt($val);
    }

    /**
     * 是否合法的加密值
     *
     * @param string $val
     * @return boolean
     */
    public function isValidEncryptVal($val)
    {
        $json = base64_decode($val);
        $data = @json_decode($json, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return false;
        }
        return isset($data["iv"]) && isset($data["value"]) && isset($data["mac"]);
    }
}
