<?php

namespace Lucky\Dkms\Clients;

use Dkms\Config;
use Dkms\Dkms;
use Dkms\Models\DecryptRequest;
use Dkms\Models\DecryptResponse;
use Dkms\Models\EncryptRequest;
use Dkms\Models\EncryptResponse;
use InvalidArgumentException;
use Lucky\Dkms\DkmsInterface;

/**
 * DOnlineClient
 */
class DkmsClient implements DkmsInterface
{
    /**
     * @var Kms
     */
    protected $client;

    /**
     * kms key id
     *
     * @var string
     */
    protected $keyId;

    /**
     * construct
     *
     * @param array $config 配置
     */
    function __construct(array $config)
    {
        $configCls = new Config();
        $configCls->setProtocol($config["protocol"]);
        $configCls->setEndpoint($config["endpoint"]);
        $configCls->setPassword($config["password"]);
        $configCls->setClientKeyContent($config["clientKeyContent"]);
        $configCls->setCainfo($config["cainfo"]);
        $configCls->setUserAgent($config["userAgent"]);
        $configCls->setReadTimeout($config["readTimeout"]);
        $configCls->setConnectTimeout($config["connectTimeout"]);
        $configCls->setHttpProxy($config["httpProxy"]);
        $configCls->setHttpsProxy($config["httpsProxy"]);
        $configCls->setNoProxy($config["noProxy"]);
        $configCls->setMaxIdleConns($config["maxIdleConns"]);
        $this->client = new Dkms($configCls);
    }

    /**
     * encrypt
     *
     * @param  string $keyId
     * @param  string $val   明文
     * @throws \Exception
     *
     * @return string 密文
     */
    public function encrypt($keyId, $val)
    {
        $request = new EncryptRequest();
        $request->setKeyId($keyId);
        $request->setPlaintext($val);
        /**
         * @var EncryptResponse
         */
        $response = $this->client->encrypt($request);
        $data = json_decode($response->serializeToJsonString(), true);
        return base64_encode(json_encode([
            "CiphertextBlob" => $data["CiphertextBlob"],
            "Iv"             => $data["Iv"],
        ]));
    }

    /**
     * decrypt
     *
     * @param  string $keyId
     * @param  string $val   明文
     * @throws \Exception
     *
     * @return string 明文
     */
    public function decrypt($keyId, $val)
    {
        $data = base64_decode($val);
        if (!$data || !@json_decode($data, true)) {
            throw new InvalidArgumentException("Decrypt parameter is invalid.");
        }
        $request = new DecryptRequest();
        $request->mergeFromJsonString($data);
        $request->setKeyId($keyId);
        /**
         * @var DecryptResponse
         */
        $response = $this->client->decrypt($request);
        return $response->getPlaintext();
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
        return isset($data["CiphertextBlob"]) && isset($data["Iv"]);
    }
}
