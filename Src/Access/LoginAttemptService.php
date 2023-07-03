<?php

namespace Emma\Security\Access;

use Emma\App\Config;
use Emma\App\Constants;
use Emma\Di\Container\ContainerManager;
use Emma\Http\Request\RequestInterface;

abstract class LoginAttemptService
{
    use ContainerManager;

    private string $ipAddress;

    private string $computerName = "";

    /**
     * @var array
     */
    private array $suspensionRules = [
         /** numberOfAttempts => minutes  [Mapping Number of Attempts Allowed Per Minutes] */
    ];
    
    
    public function __construct()
    {
        /** @var RequestInterface $request */
        $request = $this->getContainer()->get(Constants::REQUEST);
        /** @var Config $config */
        $config = $this->getContainer()->get(Constants::CONFIG);
        $login_attempt_rules = (array)$config->appConfig["login_attempt_rules"];
        $this->setIpAddress($request->getServer()->getClientIpAddress());
        $this->setComputerName($this->getComputerName());
        $this->setSuspensionRules($login_attempt_rules);
    }

    /**
     * @param string $username
     * @return mixed
     */
    public abstract function save(string $username): mixed;

    /**
     * @param int $minutes
     */
    public abstract function purge(int $minutes = 120);

    /**
     * @param string $username
     * @param int $minutesAgo
     * @return int
     */
    public abstract function countAttempt(string $username, int $sinceMinutesAgo = 1): int;

    /**
     * @param string $username
     * @param int $minutesAgo
     * @return bool
     */
    public abstract function validate(string $username, int $minutesAgo = 1, int $MAX_ALLOWED_NUMBER_OF_ATTEMPT = 5): bool;

    /**
     * @param string $username
     * @return LoginStatus
     */
    public abstract function authenticate(string $username): LoginStatus;

    /**
     * @return array
     */
    public abstract function getFailedRule(): array;

    /**
     * @return  string
     */ 
    public function getIpAddress()
    {
        return $this->ipAddress;
    }

    /**
     * @param  string  $ipAddress  ipAddress
     * @return  self
     */ 
    public function setIpAddress(string $ipAddress): static
    {
        $this->ipAddress = $ipAddress;
        return $this;
    }

    /**
     * @return  string
     */ 
    public function getComputerName(): string
    {
        if (empty($this->computerName)) {
            $this->computerName = ((double)\phpversion() >= 5.3) ? \gethostname() : \php_uname('n');
        }
        return $this->computerName;
    }

    /**
     * @param  string  $computerName
     * @return  self
     */ 
    public function setComputerName(string $computerName): static
    {
        $this->computerName = $computerName;
        return $this;
    }

    /**
     * @param int $numberOfAttempts
     * @param int $minutes
     * @return $this
     */
    public function registerSuspensionRule(int $numberOfAttempts, int $minutes): static
    {
        $this->suspensionRules[$numberOfAttempts] = $minutes;
        return $this;
    }

    /**
     * @return array
     * numberOfAttempts => minutes  [Mapping Number of Attempts Allowed Per Minutes]
     */ 
    public function getSuspensionRules(): array
    {
        return $this->suspensionRules;
    }

    /**
     * numberOfAttempts => minutes  [Number of Attempts Allowed Per Minutes]
     * @param array $suspensionRules
     * @return $this
     */
    public function setSuspensionRules(array $suspensionRules): static
    {
        $this->suspensionRules = $suspensionRules;
        return $this;
    }
}