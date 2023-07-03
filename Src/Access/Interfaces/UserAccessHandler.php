<?php
/**
 * @Author: Ademola Aina
 * Email: debascoguy@gmail.com
 */

namespace Emma\Security\Access\Interfaces;

use Emma\Security\Access\LoginStatus;

Interface UserAccessHandler
{
    /**
     * @param $username
     * @param $password
     * @return UserInterface|bool
     */
    public function loadUser($username, $password): UserInterface|false;

    /**
     * @param UserInterface $user
     * @return mixed
     */
    public function onAccessGranted(UserInterface $user): mixed;

    /**
     * @param LoginStatus $loginStatus
     * @return mixed
     */
    public function onAccessDenied(LoginStatus $loginStatus): mixed;
    

}