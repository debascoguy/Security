<?php
namespace Emma\Security\Services;

/**
 * Created by Ademola Aina.
 * Date: 3/11/2018
 *
 * A simple Improved Code Developed Based on original publication at -
 * https://aesencryption.net/
 *
 * Advance Encryption Scheme Algorithm Implementation
 * PHP AES encryption with openssl example.(versions 7.x)
 */
class AESopenSSL
{
    /**
     * @var string
     */
    protected string $key;

    /**
     * @var string
     */
    protected string $data;

    /**
     * @var string
     */
    protected string $method;

    /**
     * Available OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING
     *
     * @var $options
     */
    protected int $options = 0;

    /** @BLOCK_SIZE */
    const BLOCK_128 = 128;
    const BLOCK_192 = 192;
    const BLOCK_256 = 256;

    /** @MODE */
    const M_CBC = 'CBC';
    const M_CBC_HMAC_SHA1 = 'CBC-HMAC-SHA1';
    const M_CBC_HMAC_SHA256 = 'CBC-HMAC-SHA256';
    const M_CFB = 'CFB';
    const M_CFB1 = 'CFB1';
    const M_CFB8 = 'CFB8';
    const M_CTR = 'CTR';
    const M_ECB = 'ECB';
    const M_OFB = 'OFB';
    const M_XTS = 'XTS';

    /**
     * @param $data
     * @param $key
     * @param $blockSize
     * @param $mode
     * @throws \Exception
     */
    function __construct($data = null, $key = null, $blockSize = null, $mode = 'CBC')
    {
        $this->setData($data);
        $this->setKey($key);
        $this->setMethod($blockSize, $mode);
    }

    /**
     *
     * @param $data
     */
    public function setData($data): void
    {
        $this->data = $data;
    }

    /**
     *
     * @param $key
     */
    public function setKey($key): void
    {
        $this->key = $key;
    }

    /**
     * @param $blockSize
     * @param string $mode
     * @throws \Exception
     *
     * CBC 128 192 256
     * CBC-HMAC-SHA1 128 256
     * CBC-HMAC-SHA256 128 256
     * CFB 128 192 256
     * CFB1 128 192 256
     * CFB8 128 192 256
     * CTR 128 192 256
     * ECB 128 192 256
     * OFB 128 192 256
     * XTS 128 256
     */
    public function setMethod($blockSize, string $mode = 'CBC'): void
    {
        if ($blockSize == self::BLOCK_192 && in_array($mode, array('CBC-HMAC-SHA1', 'CBC-HMAC-SHA256', 'XTS'))) {
            $this->method = null;
            throw new \Exception('Invalid block size and mode combination!');
        }
        $this->method = 'AES-' . $blockSize . '-' . $mode;
    }

    /**
     *
     * @return boolean
     */
    public function validateParams()
    {
        return ($this->data != null && $this->method != null);
    }

    /**
     * @return string
     * it must be the same when you encrypt and decrypt.
     * So Uncomment this openssl_random_pseudo_bytes when you know you will be saving the IV key somewhere
     */
    protected function getIV()
    {
      return '1234567890123456';
//        return openssl_random_pseudo_bytes(openssl_cipher_iv_length($this->method));
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function encrypt(): string
    {
        if ($this->validateParams()) {
            return trim(\openssl_encrypt($this->data, $this->method, $this->key, $this->options, $this->getIV()));
        } else {
            throw new \Exception('Invalid params!');
        }
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function decrypt(): string
    {
        if ($this->validateParams()) {
            return trim(\openssl_decrypt($this->data, $this->method, $this->key, $this->options, $this->getIV()));
        } else {
            throw new \Exception('Invalid params!');
        }
    }

}