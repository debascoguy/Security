<?php
namespace Emma\Security\Access\Interfaces;

/**
 * @Author: Ademola Aina
 * Email: debascoguy@gmail.com
 */
interface UserInterface
{
    public function getId(): int;

    /**
     * @return string
     */
    public function getUsername(): string;

    /**
     * @param string $username
     * @return UserInterface
     */
    public function setUsername(string $username): static;

    /**
     * @return string
     */
    public function getPassword(): string;

    /**
     * @param string $password
     * @return UserInterface
     */
    public function setPassword(string $password): static;

    /**
     * @param array $AuthorityInterface
     * @return $this
     */
    public function setAuthorities(array $AuthorityInterface): static;

    /**
     * @return array
     */
    public function getAuthorities(): array;

    /**
     * @return boolean
     */
    public function isAccountExpired(): bool;

    /**
     * @param boolean $accountExpired
     * @return UserInterface
     */
    public function setAccountExpired(bool $accountExpired): static;

    /**
     * @return boolean
     */
    public function isAccountLocked(): bool;

    /**
     * @param boolean $accountLocked
     * @return UserInterface
     */
    public function setAccountLocked(bool $accountLocked): static;

    /**
     * @return boolean
     */
    public function isCredentialsExpired(): bool;

    /**
     * @param boolean $credentialsExpired
     * @return UserInterface
     */
    public function setCredentialsExpired(bool $credentialsExpired): static;

    /**
     * @return boolean
     */
    public function isAccountDisabled(): bool;

    /**
     * @param boolean $accountDisabled
     * @return UserInterface
     */
    public function setAccountDisabled(bool $accountDisabled): static;
}