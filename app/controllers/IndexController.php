<?php
namespace controllers;
use Ajax\php\ubiquity\JsUtils;
use models\Groupe;
use models\Route;
use models\Serveur;
use models\User_;
use Ubiquity\orm\DAO;


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

    #[Route("/", name: "vm.home")]
    public function listVM() {
        $vm = DAO::getAll(Vm::class);
        $this->jquery->renderView('Index/index.html', ['test' => $vm]);
    }

    #[Route("/", name: "server.home")]
    public function listServeurAll() {
        $server = DAO::getAll(Serveur::class);
        $this->jquery->renderView('Index/index.html', ['servers' => $server]);
    }

    #[Route("/", name: "user.home")]
    public function listUser(){
        $user = DAO::getAll(User_::class);
        $this->jquery->renderView('Index/index.html', ['users' => $user]);
    }
}
