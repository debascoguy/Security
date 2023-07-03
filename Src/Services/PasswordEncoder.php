<?php

namespace Emma\Security\Services;

use Emma\Common\Utils\StringManagement;

/**
 * @author Ademola Aina
 */
class PasswordEncoder
{
    public const SIGNATURE = "$1E_";

    /**
     * @param $value
     * @return string
     */
    public static function signEncryption($value): string
    {
        return self::SIGNATURE . $value . self::SIGNATURE;
    }

    /**
     * @param $value
     * @return string
     */
    public static function unSignEncryption($value): string
    {
        return trim($value, self::SIGNATURE);
    }

    /**
     * @param $value
     * @return bool
     *
     * If a value is not signed, Then it is not encrypted using our system.
     */
    public static function isSigned($value): bool
    {
        return (StringManagement::startsWith($value, self::SIGNATURE) || StringManagement::endsWith($value, self::SIGNATURE));
    }

    /**
     * @param string $passwordText
     * @return string
     */
    public static function encodePassword(string $passwordText): string
    {
        return self::signEncryption(
                substr(
                        sha1(
                                md5($passwordText)
                                ), 0, 28
                        )
                );
    }
    
    /**
     * 
     */
    public static function validatePassword($encodedPassword, $passwordText): bool
    {
        return (self::encodePassword($passwordText) == $encodedPassword);
    }
    
    /**
     * @param string $passwordText
     * @return string
     */
    public function encode(string $passwordText): string
    {
        return self::encodePassword($passwordText);
    }
    
    
    /**
     * @param string $encodedPassword
     * @param string $passwordText
     * @return bool
     */
    public function validate(string $encodedPassword, string $passwordText): bool
    {
        return (self::encodePassword($passwordText) == $encodedPassword);
    }

}
