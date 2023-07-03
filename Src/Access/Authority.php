<?php
namespace Emma\Security\Access;
use Emma\Common\Utils\AdvancedArrayAccess;
use Emma\Security\Access\Interfaces\AuthorityInterface;

/**
 * @Author: Ademola Aina
 * Email: debascoguy@gmail.com
 */
class Authority extends AdvancedArrayAccess implements AuthorityInterface
{

    /**
     * @var String
     * Can be a PRIVILEGE or a ROLE
     */
    private $permission = null;

    /**
     * @param $authority
     */
    public function __construct($authority)
    {
        $this->permission = $authority;
    }

    /**
     * @return bool
     */
    public function hasPermission(): bool
    {
        return empty($this->permission);
    }

    /**
     * @return String
     */
    public function getPermission(): string
    {
        return $this->permission;
    }

    /**
     * @param string $permission
     * @return Authority
     */
    public function setPermission(string $permission): static
    {
        $this->permission = $permission;
        return $this;
    }

    /**
     * @return String
     */
    public function __toString()
    {
        return $this->permission;
    }

}