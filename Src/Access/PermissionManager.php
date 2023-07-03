<?php
namespace Emma\Security\Access;

use Emma\Modules\Api\Model\Entity\AppPrivilege;
use Emma\Security\Access\Interfaces\AuthorityInterface;
use Emma\Security\Access\Interfaces\PrivilegeInterface;
use Emma\Security\Access\Interfaces\RoleInterface;
use Emma\Security\Access\Interfaces\UserInterface;

/**
 * @Author: Ademola Aina
 * Email: debascoguy@gmail.com
 */
class PermissionManager
{
    /**
     * @param array $appRoles
     * @return array
     */
    public function getRoleNames(array $appRoles): array
    {
        if (empty($appRoles)) {
            return array();
        }
        $roleNames = array();
        foreach($appRoles as $role){
            if ($role instanceof RoleInterface){
                $roleNames[] = $role->getName();
            }
        }
        return $roleNames;
    }

    /**
     * @param array $appPrivileges
     * @return array
     */
    public function getPrivilegeNames(array $appPrivileges): array
    {
        if (empty($appPrivileges)) {
            return array();
        }
        $privilegeNames = array();
        foreach($appPrivileges as $privilege){
            if ($privilege instanceof PrivilegeInterface){
                $privilegeNames[] = $privilege->getName();
            }
        }
        return $privilegeNames;
    }

    /**
     * @param array $permissions
     * @return array|null
     */
    public static function createAuthorities(array $permissions = array()): ?array
    {
        if (empty($permissions)) {
            return null;
        }
        $authority = array();
        foreach ($permissions as $perm) {
            $authority[] = (!$perm instanceof AuthorityInterface) ? new Authority($perm) : $perm;
        }
        return $authority;
    }

    /**
     * @param Authority[]|AppPrivilege[] $authorities
     * @return array|null
     */
    public static function getPermissions(array $authorities = []): ?array
    {
        if (empty($authorities)) {
            return null;
        }

        $permissions = array();
        foreach ($authorities as $authority) {
            $permissions[] = ($authority instanceof AuthorityInterface) ? 
                            $authority->getPermission() : 
                            ($authority instanceof AppPrivilege ? $authority->getName() : $authority);
        }
        return $permissions;
    }

    /**
     * @param UserInterface $user
     * @param $permission
     * @return bool
     */
    public static function hasPermission(UserInterface $user, $permission): bool
    {
        return !(empty($permission)) && in_array($permission, self::getPermissions($user->getAuthorities()));
    }
    
    /**
     * @param UserInterface $user
     * @param AuthorityInterface $authority
     * @return bool
     */
    public static function hasAuthority(UserInterface $user, AuthorityInterface $authority): bool
    {
        return in_array($authority, $user->getAuthorities());
    }


}
