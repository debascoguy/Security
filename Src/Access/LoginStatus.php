<?php
/**
 * @Author: Ademola Aina
 * Email: debascoguy@gmail.com
 */


namespace Emma\Security\Access;


use Emma\Security\Access\Interfaces\UserInterface;

class LoginStatus
{
    /**
     * @var bool
     */
    protected bool $error = false;

    /**
     * @var int
     */
    protected int $httpStatusCode = 0;

    /**
     * @var string
     */
    protected ?string $message = "";

    /**
     * @var string
     */
    protected ?string $gotoPage = "";

    /**
     * @var null | UserInterface
     */
    protected ?UserInterface $user = null;

    const LOGIN_ATTEMPT_OK = "Login Attempt OK!";
    const ACCOUNT_DISABLED = "Account Disabled!";
    const ACCOUNT_EXPIRED = "Account Expired!";
    const ACCOUNT_LOCKED = "Account Locked!";
    const ACCOUNT_CREDENTIALS_EXPIRED = "Account Credentials Expired!";
    const _ACCESS_GRANTED = "Access Granted!";
    const _ACCESS_DENIED = "Access Denied!";
    const LOGIN_FAILED = "Login Failed!";
    const LOGIN_FAILED_TOO_MANY_ATTEMPT = "Too Many Attempt. Please try again later.";

    /**
     * @param bool $error
     * @param int $httpStatusCode
     * @param string $message
     * @param string $gotoPage
     */
    public function __construct(bool $error, int $httpStatusCode, string $message, string $gotoPage = "")
    {
        $this->error = $error;
        $this->httpStatusCode = $httpStatusCode;
        $this->message = $message;
        $this->gotoPage = $gotoPage;
    }

    /**
     * @return bool
     */
    public function isError(): bool
    {
        return $this->error;
    }

    /**
     * @param bool $error
     * @return $this
     */
    public function setError(bool $error): static
    {
        $this->error = $error;
        return $this;
    }

    /**
     * @return int
     */
    public function getHttpStatusCode(): int
    {
        return $this->httpStatusCode;
    }

    /**
     * @param int $httpStatusCode
     * @return $this
     */
    public function setHttpStatusCode(int $httpStatusCode): static
    {
        $this->httpStatusCode = $httpStatusCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return $this
     */
    public function setMessage(?string $message): static
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return string
     */
    public function getGotoPage(): string
    {
        return $this->gotoPage;
    }

    /**
     * @param string $gotoPage
     * @return $this
     */
    public function setGotoPage(?string $gotoPage): static
    {
        $this->gotoPage = $gotoPage;
        return $this;
    }

    /**
     * @return UserInterface|null
     */
    public function getUser(): ?UserInterface
    {
        return $this->user;
    }

    /**
     * @param UserInterface|null $user
     * @return $this
     */
    public function setUser(?UserInterface $user): static
    {
        $this->user = $user;
        return $this;
    }

}