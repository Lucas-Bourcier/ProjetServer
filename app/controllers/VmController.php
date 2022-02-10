<?php
namespace controllers;
 use Ajax\php\ubiquity\JsUtils;
 use models\Groupe;
 use models\Serveur;
 use models\User_;
 use models\Vm;
 use Ubiquity\attributes\items\router\Get;
 use Ubiquity\attributes\items\router\Post;
 use Ubiquity\controllers\Router;
 use Ubiquity\orm\DAO;
 use Ubiquity\orm\repositories\ViewRepository;
 use Ubiquity\utils\http\URequest;
 use Ubiquity\utils\models\UArrayModels;

 /**
  * Controller VmController
  * @property JsUtils $jquery
  */
class VmController extends \controllers\ControllerBase{

    private ViewRepository $repo;

    public function initialize() {
        parent::initialize();
        $this->repo??=new ViewRepository($this,Vm::class);
    }
	public function index(){
		$this->loadView("VmController/index.html");
	}

    //Fonction formulaire et ajout d'une VM

    #[Get(path: "/addVm",name: "vm.addVm")]
    public function addVm(){
        $vm=new Vm();
        $frm=$this->jquery->semantic()->dataForm('vm-form',$vm);
        $frm->setActionTarget(Router::path('vm.postVm'), '');
        $frm->setProperty('method','post');
        $frm->setFields(['Number','Name', 'Ip', 'Sshport','Os', 'Groupe', 'Server', 'User_', 'submit']);
        $frm->fieldAsDropDown('Groupe', UArrayModels::asKeyValues(DAO::getAll(Groupe::class),'getId'));
        $frm->fieldAsDropDown('Server', UArrayModels::asKeyValues(DAO::getAll(Serveur::class), 'getId'));
        $frm->fieldAsDropDown('User_', UArrayModels::asKeyValues(DAO::getAll(User_::class), 'getId'));
        $frm->fieldAsSubmit('submit', 'green','');
        $this->jquery->renderView('VmController/addVm.html');
    }


    #[Post(path: "addVm/resultPost",name: "vm.postVm")]
    public function postVm(){
        $vm= new Vm();
        if ($vm){
            URequest::setValuesToObject($vm);
            $this->repo->insert($vm,true);
        }
        $this->index();
    }
}
