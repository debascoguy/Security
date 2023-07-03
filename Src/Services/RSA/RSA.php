<?php
namespace Emma\Security\Services\RSA;

/**
 * @Author: Ademola Aina
 * Email: debascoguy@gmail.com
 */
class RSA
{
    /**
     * @param string $data
     * @param string $crypted
     * @param $key
     * @param int $padding using for example OPENSSL_PKCS1_PADDING as default padding
     * @return bool
     */
    public static function private_encrypt($key, string $data = "", string &$crypted = "", int $padding = OPENSSL_PKCS1_PADDING): bool
    {
        return openssl_private_encrypt($data, $crypted, $key, $padding);
    }

    /**
     * @param string $data
     * @param string $decrypted
     * @param $key
     * @param int $padding using for example OPENSSL_PKCS1_PADDING as default padding
     * BUT be sure to match padding used during private_encrypt()
     * @return bool
     */
    public static function public_decrypt($key, string $data = "", string &$decrypted = "", int $padding = OPENSSL_PKCS1_PADDING)
    {
        return openssl_public_decrypt($data, $decrypted, $key, $padding);
    }

    /**
     * @param string $data
     * @param string $crypted
     * @param $key
     * @param int $padding using for example OPENSSL_PKCS1_PADDING as default padding
     * @return bool
     */
    public static function public_encrypt($key, string $data = "", string &$crypted = "", int $padding = OPENSSL_PKCS1_PADDING): bool
    {
        return openssl_public_encrypt($data, $crypted, $key, $padding);
    }

    /**
     * @param string $data
     * @param string $decrypted
     * @param $key
     * @param int $padding using for example OPENSSL_PKCS1_PADDING as default padding
     * @return bool
     */
    public static function private_decrypt($key, string $data = "", string &$decrypted = "", int $padding = OPENSSL_PKCS1_PADDING): bool
    {
        return openssl_private_decrypt($data, $decrypted, $key, $padding);
    }

    /**
     * @param $plainData
     * @param $privatePEMKey
     * @param int $blockSize
     * @return bool|string
     */
    protected static function encrypt_RSA($plainData, $privatePEMKey, int $blockSize = Keys::ENCRYPT_BLOCK_SIZE): bool|string
    {
        $encrypted = '';
        $plainData = str_split($plainData, $blockSize);
        $encryptionOk = true;
        foreach ($plainData as $chunk) {
            $partialEncrypted = '';
            if (self::private_encrypt($privatePEMKey, $chunk, $partialEncrypted, ) == $encryptionOk) {
                $encrypted .= $partialEncrypted;
            } else {
                return false;   //also you can return and error. If too big this will be false
            }
        }
        return base64_encode($encrypted);//encoding the whole binary String as MIME base 64
    }

    /**
     * @param $publicPEMKey
     * @param $data
     * @param int $blockSize
     * @return bool|string
     */
    protected static function decrypt_RSA($publicPEMKey, $data, int $blockSize = Keys::DECRYPT_BLOCK_SIZE): bool|string
    {
        $decrypted = '';
        $decryptionOK = true;
        $data = base64_decode($data);   //decode must be done before spliting for getting the binary String
        $data = str_split($data, $blockSize);

        foreach ($data as $chunk) {
            $partial = '';
            if (self::public_decrypt($publicPEMKey, $chunk, $partial) == $decryptionOK) {
                $decrypted .= $partial;
            } else {
                return false;   //here also processed errors in decryption. If too big this will be false
            }
        }
        return $decrypted;
    }

}