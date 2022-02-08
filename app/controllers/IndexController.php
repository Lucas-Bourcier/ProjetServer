<?php
namespace controllers;

use Ajax\JsUtils;
use models\Groupe;
use models\Route;
use models\Serveur;
use models\User_;
use Ubiquity\core\postinstall\Display;
use Ubiquity\log\Logger;
use Ubiquity\orm\DAO;
use Ubiquity\themes\ThemesManager;

/**
 * Controller IndexController
 *  @property JsUtils $jquery
 */
class IndexController extends ControllerBase {

	public function index() {
        $this->jquery->renderView('Index/index.html');
	}

    public function listVMUser() {
        $user_id = USession::get('user_id');
        $vm = DAO::getAll(Vm::class, 'idUser = :idUser', false, ['idUser' => $user_id]);
        $this->jquery->renderView('Index/index.html', ['vms' => $vm]);
    }

    public function listServeurAll() {
        $server = DAO::getAll(Serveur::class);
        $this->jquery->renderView('Index/index.html', ['servers' => $server]);
    }

    public function listUser(){
        $user = DAO::getAll(User_::class);
        $this->jquery->renderView('Index/index.html', ['users' => $user]);
    }

    public function listGroup(){
        $groupAll = DAO::getAll(Groupe::class);
        $this->jquery->renderView('Index/index.html', ['groups' => $groupAll]);
    }

    public function listRoute(){
        $route = DAO::getAll(Route::class);
        $this->jquery->renderView('Index/index.html', ['routes' => $route]);
    }
}
