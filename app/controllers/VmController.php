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
 use Ubiquity\orm\repositories\ViewRepository;
 use Ubiquity\utils\http\URequest;
 use Ubiquity\utils\http\USession;
 use Ubiquity\utils\models\UArrayModels;

 /**
  * Controller VmController
  * @property JsUtils $jquery
  */

 #[\Ubiquity\attributes\items\router\Route("DashBoard/VM")]
class VmController extends ControllerBase{

    private ViewRepository $repo;

    public function initialize() {
        parent::initialize();
        $this->repo??=new ViewRepository($this,Vm::class);
    }

     #[\Ubiquity\attributes\items\router\Route("/")]
	public function index(){
        $listVM = DAO::getAll(Vm::class);
		$this->loadView("VmController/index.html", ['listVMS' => $listVM]);
	}

     //Fonction qui permettent de récupérer les données de la BDD

     #[\Ubiquity\attributes\items\router\Route("/vmUser", name: "vmUser.home")]
     public function vmUser() {
         $user_id = USession::get('user_id');
         $vm = DAO::getAll(Vm::class, 'idUser = :idUser', false, ['idUser' => $user_id]);
         $this->jquery->renderView('VmController/listVMUser.html', ['vms' => $vm]);
     }

     #[\Ubiquity\attributes\items\router\Route("/listVM", name: "listVM.home")]
     public function listVM() {
         $listVM = DAO::getAll(Vm::class);
         $this->jquery->renderView('VmController/listVM.html', ['listVMS' => $listVM]);
     }

    //Fonction formulaire et ajout d'une VM

    #[Get(path: "/addVm",name: "vm.addVm")]
    public function addVm(){
        $vm=new Vm();
        $frm=$this->jquery->semantic()->dataForm('vm-form',$vm);
        $frm->setActionTarget(Router::path('vm.postVm'), '');
        $frm->setProperty('method','post');
        $frm->setFields(['Number','Name', 'Ip', 'Sshport','Os', 'Groupe', 'Serveur', 'User_', 'submit']);
        $frm->fieldAsDropDown('Groupe', UArrayModels::asKeyValues(DAO::getAll(Groupe::class),'getId'));
        $frm->fieldAsDropDown('Serveur', UArrayModels::asKeyValues(DAO::getAll(Serveur::class), 'getId'));
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


     #[Get(path: "update/{id}",name: "vm.update")]
     public function updateForm($id){
         $vm=$this->repo->byId($id, false);
         $df=$this->jquery->semantic()->dataForm('frm-vm', $vm);
         $df->setActionTarget(Router::path('vm-update.submit'), '');
         $df->setProperty('method', 'post');
         $df->setFields(['id','Number','Name', 'Ip', 'Sshport','Os', 'Groupe', 'Serveur', 'User_', 'submit']);
         $df->fieldAsDropDown('Groupe', UArrayModels::asKeyValues(DAO::getAll(Groupe::class),'getId'));
         $df->fieldAsDropDown('Serveur', UArrayModels::asKeyValues(DAO::getAll(Serveur::class), 'getId'));
         $df->fieldAsDropDown('User_', UArrayModels::asKeyValues(DAO::getAll(User_::class), 'getId'));
         $df->fieldAsHidden('id');
         $df->fieldAsSubmit('submit', 'green fluid');
         $this->jquery->renderView('VmController/updateForm.html');
     }

     #[Post('update', name: 'vm-update.submit')]
     public function update(){
         $vm=$this->repo->byId(URequest::post('id'));
         if ($vm){
             URequest::setValuesToObject($vm);
             $this->repo->save($vm);
         }
         $this->index();
     }

     #[Get(path: "delete/{id}",name: "vm.delete")]
     public function delete($id){
         $vm=$this->repo->byId($id);
         if($vm){
             $this->repo->remove($vm);
         }
         $this->index();

     }
}
