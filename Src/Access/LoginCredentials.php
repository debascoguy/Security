<?php
/**
 * @Author: Ademola Aina
 * Email: debascoguy@gmail.com
 */
namespace Emma\Security\Access;

use Emma\Common\Property\Property;
use Emma\Security\Access\Interfaces\UserAccessHandler;

class LoginCredentials extends Property
{
    const USERNAME_FIELD = "usernameField";
    const PASSWORD_FIELD = "passwordField";

    const KEEP_ME_SIGNED_IN = "keepMeSignedIn";

    const USER_ACCESS = "UserAccessHandler";
    const SUCCESS_URL = "successURl";
    const FAILED_URL = "failedURl";
    const IS_API = "isApi";

    //Create all the getter and setter for all constance property.

    /**
     * @return mixed
     */
    public function isApi()
    {
        return $this->get(self::IS_API);
    }

    /**
     * @param boolean $isApi
     * @return LoginCredentials
     */
    public function setApi($isApi)
    {
        $this->register(self::IS_API, $isApi);
        return $this;
    }

    /**
     * @param UserAccessHandler $userAccessManager
     * @return $this
     */
    public function setUserAccess(UserAccessHandler $userAccessManager)
    {
        $this->register(self::USER_ACCESS, $userAccessManager);
        return $this;
    }

    /**
     * @return UserAccessHandler|null
     */
    public function getUserAccess()
    {
        return $this->get(self::USER_ACCESS);
    }

    /**
     * @param string $username
     * @return LoginCredentials
     */
    public function setUserNameField($username)
    {
        $this->register(self::USERNAME_FIELD, $username);
        return $this;
    }

    /**
     * @return mixed|null
     */
    public function getUserNameField()
    {
        return $this->get(self::USERNAME_FIELD);
    }

    /**
     * @return mixed
     */
    public function getPasswordField()
    {
        return $this->get(self::PASSWORD_FIELD);
    }

    /**
     * @param mixed $passwordField
     * @return LoginCredentials
     */
    public function setPasswordField($passwordField)
    {
        $this->register(self::PASSWORD_FIELD, $passwordField);
        return $this;
    }

    /**
     * @return mixed
     */
    public function isKeepMeSignedIn()
    {
        return $this->get(self::KEEP_ME_SIGNED_IN);
    }

    /**
     * @param mixed $keepMeSignedIn
     * @return LoginCredentials
     */
    public function setKeepMeSignedIn($keepMeSignedIn)
    {
        $this->register(self::KEEP_ME_SIGNED_IN, $keepMeSignedIn);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSuccessUrl()
    {
        return $this->get(self::SUCCESS_URL);
    }

    /**
     * @param mixed $url
     * @return LoginCredentials
     */
    public function setSuccessUrl($url)
    {
        $this->register(self::SUCCESS_URL, $url);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFailedUrl()
    {
        return $this->get(self::FAILED_URL);
    }

    /**
     * @param mixed $url
     * @return LoginCredentials
     */
    public function setFailedUrl($url)
    {
        $this->register(self::FAILED_URL, $url);
        return $this;
    }



}
