<?php
namespace controllers;
use models\User;
use Ubiquity\attributes\items\router\Post;
use Ubiquity\attributes\items\router\Route;
use Ubiquity\cache\CacheManager;
use controllers\auth\files\LoginBaseFiles;
use Ubiquity\controllers\auth\AuthFiles;
use Ubiquity\orm\DAO;
use Ubiquity\utils\flash\FlashMessage;
use Ubiquity\utils\http\UResponse;
use Ubiquity\utils\http\USession;
use models\User_;
use Ubiquity\utils\http\URequest;

#[Route(path: "/connection",inherited: true,automated: true)]
class LoginBase extends \Ubiquity\controllers\auth\AuthController{

    protected $footerView = "@activeTheme/main/vFooter.html";
    protected $headerView = "@activeTheme/main/vHeader.html";

	protected function onConnect($connected) {
		$urlParts=$this->getOriginalURL();
		USession::set($this->_getUserSessionKey(), $connected);
		if(isset($urlParts)){
			$this->_forward(implode("/",$urlParts));
		}else{
            UResponse::header('location', '/DashBoard');
		}
	}

    protected function _connect() {
        if(URequest::isPost()){
            $login=URequest::post($this->_getLoginInputName());
            // $password=URequest::post($this->_getPasswordInputName());
            $user=DAO::getOne(User_::class,'login= :login',false,['login'=>$login]);
            if(isset($user)) {
                $id = $user->getId();
                $name=$user->getLogin();
                $role=$user->getRole();
                USession::set('user_id', $id);
                USession::set('name', $name);
                USession::set('role', $role);
                USession::set('user', $user);
            }
            return $user;
        }
        return;
    }

	/**
	 * {@inheritDoc}
	 * @see \Ubiquity\controllers\auth\AuthController::isValidUser()
	 */
	public function _isValidUser($action=null) :bool{
		return USession::exists($this->_getUserSessionKey());
	}

	public function _getBaseRoute() :string {
		return '/connection';
	}

    public function _getLoginInputName() :string {
        return "email";
    }

    protected function getFiles(): LoginBaseFiles
    {
        return new LoginBaseFiles();
    }

    protected function finalizeAuth()
    {
        if (! URequest::isAjax()) {
            $this->loadView($this->footerView);
        }
    }

    protected function initializeAuth()
    {
        if (! URequest::isAjax()) {
            $this->loadView($this->headerView);
        }
    }

    protected function terminateMessage(FlashMessage $fMessage)
    {
        $fMessage->setIcon("checkmark");
        $fMessage->setTitle("Déconnexion");
        $fMessage->setContent("vous avez été déconnecté de l'application");
    }


    public function _displayInfoAsString():bool
    {
        return true;
    }

    public function hasAccountCreation(): bool
    {
        return true;
    }

    public function _newAccountCreationRule(string $accountName): ?bool
    {
        $excluded=['admin','root','Admin'];
        return \array_search($accountName, $excluded)===false && filter_var($accountName, FILTER_SANITIZE_SPECIAL_CHARS)!==false;
    }

    protected function _create(string $login, string $password): ?bool
    {
        if(!DAO::exists(User_::class,'login= ?', [$login])){
        $user= new User_();
        $user->setLogin($login);
        $user->setPassword(URequest::password_hash('password'));
        return DAO::insert($user);
        }
        return false;
    }
}
