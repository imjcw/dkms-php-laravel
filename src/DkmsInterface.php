<?php

namespace Lucky\Dkms;

/**
 * KmsInterface
 */
interface DkmsInterface
{
    /**
     * construct
     *
     * @param array $config 配置
     */
    function __construct(array $config);

    /**
     * encrypt
     *
     * @param  string $keyId
     * @param  string $val   明文
     * @throws \Exception
     *
     * @return string
     */
    public function encrypt($keyId, $val);

    /**
     * decrypt
     *
     * @param  string $keyId
     * @param  string $val   密文
     * @throws \Exception
     *
     * @return string
     */
    public function decrypt($keyId, $val);

    /**
     * 是否合法的加密值
     *
     * @param string $val
     * @return boolean
     */
    public function isValidEncryptVal($val);
}
