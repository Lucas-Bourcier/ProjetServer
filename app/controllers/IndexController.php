<?php
namespace controllers;
use Ajax\php\ubiquity\JsUtils;
use models\Groupe;
use models\Route;
use models\Serveur;
use models\User_;
use models\Vm;
use Ubiquity\attributes\items\router\Get;
use Ubiquity\attributes\items\router\Post;
use Ubiquity\controllers\Router;
use Ubiquity\orm\DAO;
use Ubiquity\utils\http\URequest;
use Ubiquity\utils\http\USession;
use Ubiquity\utils\models\UArrayModels;


/**
 * Controller IndexController
 *  @property JsUtils $jquery
 */
class IndexController extends ControllerBase {


	public function index() {
        $this->jquery->renderView('IndexController/index.html');
	}

    //Fonction qui permettent de récupérer les données de la BDD

    #[Route("/vmUser", name: "vmUser.home")]
    public function vmUser() {
        $user_id = USession::get('user_id');
        $vm = DAO::getAll(Vm::class, 'idUser = :idUser', false, ['idUser' => $user_id]);
        $this->jquery->renderView('IndexController/listVMUser.html', ['vms' => $vm]);
    }

    #[Route("/listVM", name: "listVM.home")]
    public function listVM() {
        $listVM = DAO::getAll(Vm::class);
        $this->jquery->renderView('IndexController/listVM.html', ['listVMS' => $listVM]);
    }

    #[Route("/listServer", name: "server.home")]
    public function listServer() {
        $server = DAO::getAll(Serveur::class);
        $this->jquery->renderView('IndexController/listServeurAll.html', ['servers' => $server]);
    }

    #[Route("/users", name: "user.home")]
    public function users(){
        $user = DAO::getAll(User_::class);
        $this->jquery->renderView('IndexController/listUser.html', ['users' => $user]);
    }

    #[Route("/listGroups", name: "user.home")]
    public function listGroups(){
        $group = DAO::getAll(Groupe::class);
        $this->jquery->renderView('IndexController/groups.html', ['groups' => $group]);
    }
}
