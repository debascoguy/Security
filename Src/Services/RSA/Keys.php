<?php
namespace Emma\Security\Services\RSA;

/**
 * @Author: Ademola Aina
 * Email: debascoguy@gmail.com
 */
class Keys
{
    /**
     * @var string
     */
    protected $resource;

    /**
     * @var string
     */
    protected string $privateKey;

    /**
     * @var string
     */
    protected string $publicKey;

    /**
     * @var string
     */
    protected string $details;

    /**
     * @var array
     * this again for 2048 bit key
     */
    private $defaultConfigArgs = array(
        "private_key_bits" => 2048,
        "private_key_type" => OPENSSL_KEYTYPE_RSA,
    );

    /**
     * Block size for encryption block cipher
     * this for 2048 bit key for example, leaving some room
     */
    const ENCRYPT_BLOCK_SIZE = 200;

    /**
     * Block size for decryption block cipher
     * this again for 2048 bit key
     */
    const DECRYPT_BLOCK_SIZE = 256;

    /**
     * @param bool $generateNewKeys
     * @param array $configArgs
     */
    public function __construct(bool $generateNewKeys = true, array $configArgs = [])
    {
        if ($generateNewKeys) {
            $this->generateKeys($configArgs);
        }
    }

    /**
     * Create the private and public key
     * @param array $configArgs
     * @return $this
     */
    public function generateKeys(array $configArgs = array()): static
    {
        if (empty($configArgs)) {
            $configArgs = $this->defaultConfigArgs;
        }

        /** Generate Private Key Resource */
        $resource = openssl_pkey_new($configArgs);

        /** Get Private Key */
        openssl_pkey_export($resource, $private_key);

        /** Get Private Key Details */
        $details = openssl_pkey_get_details($resource);

        /** Extract Public Key From Details */
        $public_key = $details["key"];

        /** Set All Fields and Return Key Object */
        return $this->setDetails($details)->setPrivateKey($private_key)->setPublicKey($public_key)->setResource($resource);
    }

    /**
     * @return string
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * @param string $resource
     * @return Keys
     */
    public function setResource($resource)
    {
        $this->resource = $resource;
        return $this;
    }

    /**
     * @return string
     */
    public function getPrivateKey(): string
    {
        return $this->privateKey;
    }

    /**
     * @param string $privateKey
     * @return $this
     */
    public function setPrivateKey(string $privateKey): static
    {
        $this->privateKey = $privateKey;
        return $this;
    }

    /**
     * @return string
     */
    public function getPublicKey(): string
    {
        return $this->publicKey;
    }

    /**
     * @param string $publicKey
     * @return $this
     */
    public function setPublicKey(string $publicKey): static
    {
        $this->publicKey = $publicKey;
        return $this;
    }

    /**
     * @return string
     */
    public function getDetails(): string
    {
        return $this->details;
    }

    /**
     * @param string $details
     * @return $this
     */
    public function setDetails(string $details): static
    {
        $this->details = $details;
        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return json_encode(get_object_vars($this));
    }

    /**
     * @param $filename
     * @return int
     */
    public function exportKeys($filename): int
    {
        if (is_file($filename)){
            return file_put_contents($filename, $this->__toString());
        }
        else{
            throw new \InvalidArgumentException("Invalid Filename for RSA Key Export");
        }
    }

}