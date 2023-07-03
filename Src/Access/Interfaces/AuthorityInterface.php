<?php

namespace Emma\Security\Access\Interfaces;

/**
 * @Author: Ademola Aina
 * Email: debascoguy@gmail.com
 * Date: 1/15/2019
 * Time: 9:40 PM
 */
interface AuthorityInterface
{
    /**
     * @return String
     */
    public function getPermission(): string;

}