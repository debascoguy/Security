<?php
/**
 * @Author: Ademola Aina
 * Email: debascoguy@gmail.com
 */

namespace Emma\Security\Access;

use Emma\App\Constants;
use Emma\App\Controller\Service\BaseController;
use Emma\Di\Attribute\Inject;
use Emma\Di\Container\ContainerManager;
use Emma\Http\HttpStatus;
use Emma\Http\Request\RequestInterface;
use Emma\Http\Response\ResponseInterface;
use Emma\Security\Access\Interfaces\UserInterface;

class LoginManager
{
    use ContainerManager;

    /**
     * @var LoginCredentials|null
     */
    #[Inject(LoginCredentials::class)]
    protected ?LoginCredentials $loginCredentials = null;

    /**
     * @var LoginAttemptService|null
     */
    protected ?LoginAttemptService $loginAttemptService = null;

    /**
     * @param BaseController $controller
     * @return ResponseInterface|LoginStatus
     */
    public function handleLogin(BaseController $controller): ResponseInterface|LoginStatus
    {
        return $this->processLoginStatus(
            $this->processLogin(), 
            $controller
        );
    }

    /**
     * @return LoginStatus
     */
    public function processLogin(): LoginStatus
    {
        /** @var RequestInterface $request */
        $request = $this->getContainer()->get(Constants::REQUEST);
        $loginCredentials = $this->getLoginCredentials();
        $username = $request->fromPost($loginCredentials->getUserNameField());
        $password = $request->fromPost($loginCredentials->getPasswordField());
        $loginAttemptService = $this->getLoginAttemptService();

        if ($loginAttemptService instanceof  LoginAttemptService) {
            $loginStatus = $loginAttemptService->authenticate($username);
            if ($loginStatus->isError()) {
                /**
                 * TODO: Disable potential user account based on the failedRule.
                 * $failedRule = $loginStatus->getFailedRule();
                 * $loginStatus->setMessage("Account access is blocked, please contact support.");
                 */
                return $this->updateLoginStatusFailedUrl($loginCredentials, $loginStatus);
            }
        }

        $user = $loginCredentials->getUserAccess()->loadUser($username, $password);
        if ($user instanceof UserInterface) {
            if ($user->isAccountDisabled()) {
                return $this->updateLoginStatusFailedUrl($loginCredentials, new LoginStatus(true, HttpStatus::HTTP_UNAUTHORIZED, LoginStatus::ACCOUNT_DISABLED));
            }
            if ($user->isAccountExpired()) {
                return $this->updateLoginStatusFailedUrl($loginCredentials, new LoginStatus(true, HttpStatus::HTTP_UNAUTHORIZED, LoginStatus::ACCOUNT_EXPIRED));
            }
            if ($user->isAccountLocked()) {
                return $this->updateLoginStatusFailedUrl($loginCredentials, new LoginStatus(true, HttpStatus::HTTP_UNAUTHORIZED, LoginStatus::ACCOUNT_LOCKED));
            }
            if ($user->isCredentialsExpired()) {
                return $this->updateLoginStatusFailedUrl($loginCredentials, new LoginStatus(true, HttpStatus::HTTP_UNAUTHORIZED, LoginStatus::ACCOUNT_CREDENTIALS_EXPIRED));
            }
        }
        else {
            return $this->updateLoginStatusFailedUrl($loginCredentials, new LoginStatus(true, HttpStatus::HTTP_UNAUTHORIZED, LoginStatus::_ACCESS_DENIED));
        }
        return $this->updateLoginStatusSuccessUrl($loginCredentials, $user, new LoginStatus(false, HttpStatus::HTTP_OK, LoginStatus::_ACCESS_GRANTED));
    }

    /**
     * @param LoginStatus $loginStatus
     * @param BaseController $controller
     * @return ResponseInterface|LoginStatus
     */
    private function processLoginStatus(LoginStatus $loginStatus, BaseController $controller): ResponseInterface|LoginStatus
    {
        if ($this->getLoginCredentials()->isApi()){
            return $loginStatus;
        }
        return $controller->redirect()->toUrl($loginStatus->getGotoPage());
    }

    /**
     * @param LoginCredentials $loginCredentials
     * @param LoginStatus $loginStatus
     * @return LoginStatus
     */
    private function updateLoginStatusFailedUrl(LoginCredentials $loginCredentials, LoginStatus $loginStatus): LoginStatus
    {
        $url = $loginCredentials->getFailedUrl();
        $url2 = $loginCredentials->getUserAccess()->onAccessDenied($loginStatus);
        return $loginStatus->setGotoPage(($url2 != null) ? $url2 : $url);
    }
    
    /**
     * @param LoginCredentials $loginCredentials
     * @param UserInterface $user
     * @param LoginStatus $loginStatus
     * @return LoginStatus
     */
    private function updateLoginStatusSuccessUrl(LoginCredentials $loginCredentials, UserInterface $user, LoginStatus $loginStatus): LoginStatus
    {
        $url = $loginCredentials->getSuccessUrl();
        $url2 = $loginCredentials->getUserAccess()->onAccessGranted($user);
        $loginStatus->setUser($user);
        return $loginStatus->setGotoPage(($url2 != null) ? $url2 : $url);
    }

    /**
     * @return LoginCredentials|null
     */
    public function getLoginCredentials(): ?LoginCredentials
    {
        return $this->loginCredentials;
    }
    
    /**
     * @param LoginCredentials $loginCredentials
     * @return LoginManager
     */
    public function setLoginCredentials(LoginCredentials $loginCredentials): static
    {
        $this->loginCredentials = $loginCredentials;
        return $this;
    }

    /**
     * @return LoginAttemptService|null
     */
    public function getLoginAttemptService(): ?LoginAttemptService
    {
        return $this->loginAttemptService;
    }

    /**
     * @param  LoginAttemptService  $loginAttemptService  $loginAttemptService
     * @return  self
     */ 
    public function setLoginAttemptService(LoginAttemptService $loginAttemptService): static
    {
        $this->loginAttemptService = $loginAttemptService;
        return $this;
    }
}