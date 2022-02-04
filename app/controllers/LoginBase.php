<?php
namespace controllers;
use Ubiquity\attributes\items\router\Get;
use Ubiquity\attributes\items\router\Post;
use Ubiquity\attributes\items\router\Route;
use Ubiquity\cache\CacheManager;
use controllers\auth\files\LoginBaseFiles;
use Ubiquity\controllers\auth\AuthFiles;
use Ubiquity\orm\DAO;
use Ubiquity\utils\flash\FlashMessage;
use Ubiquity\utils\http\UResponse;
use Ubiquity\utils\http\USession;
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
            UResponse::header('location', '/');
		}
	}

	protected function _connect() {
        if(URequest::isPost()){
            $email=URequest::post($this->_getLoginInputName());
            $password=URequest::post($this->_getPasswordInputName());
            return DAO::uGetOne(User_::class, "email=? and password= ?",false,[$email,$password]);
        }
        return;
	}
	
	/**
	 * {@inheritDoc}
	 * @see \Ubiquity\controllers\auth\AuthController::isValidUser()
	 */
	public function _isValidUser($action=null) {
		return USession::exists($this->_getUserSessionKey());
	}

	public function _getBaseRoute() {
		return '/connection';
	}

    public function _getLoginInputName() {
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

    #[Get(path: "newUser",name: "LoginBase.newUserForm")]
    public function newUserForm(){

        $this->loadView('LoginBase/newUserForm.html');

    }

    protected function terminateMessage(FlashMessage $fMessage)
    {
        $fMessage->setIcon("checkmark");
        $fMessage->setTitle("Déconnexion");
        $fMessage->setContent("vous avez été déconnecté de l'application");
    }


    public function _displayInfoAsString()
    {
        return true;
    }

    #[Post(path: "newUser",name: "LoginBase.newUser")]
    public function newUser(){
        $email=URequest::post('email');
        $key='datas/users'.md5($email);
        if (!CacheManager::$cache->exists($key)){
            CacheManager::$cache->store($key,['login'=>$email,'password'=>URequest::password_hash('password')]);
            $this->showMessage('Création de compte', "votre compte a été créé avec l'email <b>$email</b>", 'succes');
        }else{
            $this->showMessage('Création de compte', "Compte déjà associé a l'email : <b>$email</b>", 'error', 'user');
        }
    }

}
