<?php
namespace controllers;
use Ajax\php\ubiquity\JsUtils;
use models\Groupe;
use models\Route;
use models\Serveur;
use models\User_;
use Ubiquity\attributes\items\router\Post;
use Ubiquity\controllers\Router;
use Ubiquity\orm\DAO;
use Ubiquity\utils\http\URequest;
use Ubiquity\utils\http\UResponse;
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

    #[Route("/documentation", name: "documentation.home")]
    public function documentation(){
        $this->jquery->renderView('IndexController/Documentation.html');
    }

    #[POST('ModifMdp/update',name: 'orgas.submit')]
    public function update(){
        $mdp=DAO::getOne(User_::class, 'login=login',false,['login'=>$login]);
        if($mdp){
            URequest::setValuesToObject($mdp);
            $this->save($mdp);
        }
        UResponse::header('location', '/DashBoard');
    }
}
