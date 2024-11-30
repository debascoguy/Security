<?php

namespace Emma\Security\Services;

use Emma\Common\Utils\StringManagement;

/**
 * @author Ademola Aina
 */
class PasswordEncoder
{
    public const PASSWORD_ALGORITHM = [
        PASSWORD_DEFAULT => PASSWORD_DEFAULT,
        PASSWORD_BCRYPT => PASSWORD_BCRYPT,
        PASSWORD_ARGON2I => PASSWORD_ARGON2I,
        PASSWORD_ARGON2ID => PASSWORD_ARGON2ID
    ];

    /**
     * @param string $passwordText
     * @return string
     */
    public static function encodePassword(string $passwordText, string $algo = PASSWORD_BCRYPT, array $options = []): string
    {
        return password_hash($passwordText, $algo, $options);
    }
    
    /**
     * 
     */
    public static function validatePassword(string $encodedPassword, string $passwordText): bool
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
