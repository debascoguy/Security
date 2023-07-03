<?php
/**
 * @Author: Ademola Aina
 * Email: debascoguy@gmail.com
 */
namespace Emma\Security\Access;


use Emma\Security\Access\Interfaces\AuthorityInterface;
use Emma\Security\Access\Interfaces\UserInterface;

class User implements UserInterface
{
    /**
     * @var int|null
     */
    private ?int $id;

    /**
     * @var string|null
     */
    private ?string $username;

    /**
     * @var string|null
     */
    private ?string $password;

    /**
     * @var array|AuthorityInterface[]
     */
    private array $authorities = [];

    /**
     * @var bool
     */
    private bool $accountExpired = false;

    /**
     * @var bool
     */
    private bool $accountLocked = false;

    /**
     * @var bool
     */
    private bool $credentialsExpired = false;

    /**
     * @var bool
     */
    private bool $accountDisabled = false;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string|null $username
     * @return User
     */
    public function setUsername(?string $username): static
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string|null $password
     * @return User
     */
    public function setPassword(?string $password): static
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return array
     */
    public function getAuthorities(): array
    {
        return $this->authorities;
    }

    /**
     * @param array $authorities
     * @return User
     */
    public function setAuthorities(array $authorities): static
    {
        $this->authorities = $authorities;
        return $this;
    }

    /**
     * @return bool
     */
    public function isAccountExpired(): bool
    {
        return $this->accountExpired;
    }

    /**
     * @param bool $accountExpired
     * @return User
     */
    public function setAccountExpired(bool $accountExpired): static
    {
        $this->accountExpired = $accountExpired;
        return $this;
    }

    /**
     * @return bool
     */
    public function isAccountLocked(): bool
    {
        return $this->accountLocked;
    }

    /**
     * @param bool $accountLocked
     * @return User
     */
    public function setAccountLocked(bool $accountLocked): static
    {
        $this->accountLocked = $accountLocked;
        return $this;
    }

    /**
     * @return bool
     */
    public function isCredentialsExpired(): bool
    {
        return $this->credentialsExpired;
    }

    /**
     * @param bool $credentialsExpired
     * @return User
     */
    public function setCredentialsExpired(bool $credentialsExpired): static
    {
        $this->credentialsExpired = $credentialsExpired;
        return $this;
    }

    /**
     * @return bool
     */
    public function isAccountDisabled(): bool
    {
        return $this->accountDisabled;
    }

    /**
     * @param bool $accountDisabled
     * @return User
     */
    public function setAccountDisabled(bool $accountDisabled): static
    {
        $this->accountDisabled = $accountDisabled;
        return $this;
    }

}