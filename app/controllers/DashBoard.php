<?php
namespace controllers;
 use Ajax\php\ubiquity\JsUtils;
 use models\Dns;
 use models\Groupe;
 use models\Serveur;
 use models\User_;
 use models\Vm;
 use PHPMV\ProxmoxApi;
 use Ubiquity\attributes\items\acl\Allow;
 use Ubiquity\attributes\items\router\Get;
 use Ubiquity\attributes\items\router\Route;
 use Ubiquity\controllers\auth\AuthController;
 use Ubiquity\controllers\auth\WithAuthTrait;
 use Ubiquity\controllers\Router;
 use Ubiquity\orm\DAO;
 use Ubiquity\security\acl\controllers\AclControllerTrait;
 use Ubiquity\utils\http\URequest;
 use Ubiquity\utils\http\USession;
 use Ubiquity\attributes\items\router\Post;
 use Ubiquity\utils\models\UArrayModels;

 /**
  * Controller DashBoard
  *  @property JsUtils $jquery
  */

class DashBoard extends ControllerBase{

    protected function getAuthController(): AuthController {
        return new LoginBase($this);
    }

    public function _getRole()
    {
        return USession::get('role', '@ALL');
    }

    public function isValid($action){
        return parent::isValid($action) && $this->isValidAcl($action);
    }

    use AclControllerTrait, WithAuthTrait {
        WithAuthTrait::isValid insteadof AclControllerTrait;
        AclControllerTrait::isValid as isValidAcl;
    }

    protected $headerView = "@activeTheme/main/vHeaderDashBoard.html";

    protected $footerView = "@activeTheme/main/vFooterDashBoard.html";

    public function initialize() {
        if (! URequest::isAjax()) {
            $this->loadView($this->headerView);
        }
    }

    public function finalize() {
        if (! URequest::isAjax()) {
            $this->loadView($this->footerView);
        }
    }

    #[Allow(['@ADMIN','@ETUDIANT', '@PROF'])]
	public function index(){
        $user_id = USession::get('user_id');
        $nbVm=DAO::count(Vm::class, 'idUser = :idUser', ['idUser' => $user_id]);
        $user=DAO::getById(User_::class,1,['groupes']);
        $countGroupes=count($user->getGroupes());
		$this->loadView("DashBoard/index.html", ['name' =>USession::get('name'), 'nbVm' => $nbVm, 'nbGroupes' =>$countGroupes]);
	}

    #[Route('/DashBoard/VM/MesVM', name: 'dash.vm')]
    #[Allow(['@ADMIN','@ETUDIANT','@PROF'])]
    public function DashVm(){
        $user_id = USession::get('user_id');
        $vm = DAO::getAll(Vm::class, 'idUser = :idUser', false, ['idUser' => $user_id]);
        $this->loadView("DashBoard/DashVm.html", ['vms' => $vm]);
    }

    #[Route('/DashBoard/Crud', name: 'dash.crud')]
    #[Allow(['@ADMIN','@PROF'])]
    public function DashGroupes(){
        $this->loadView("DashBoard/DashGroupes.html");
    }

    #[Route('/DashBoard/Profil', name: 'dash.profil')]
    #[Allow(['@ADMIN','@ETUDIANT','@PROF'])]
    public function DashProfil(){
        $user_id = USession::get('user_id');
        $user = DAO::getById(User_::class, $user_id);
        $this->loadView("DashBoard/DashProfil.html", ['users' => $user]);
    }

    #[Route('/DashBoard/Serveurs', name: 'dash.server')]
    #[Allow(['@ADMIN','@PROF'])]
    public function DashServers(){
        $server = DAO::getAll(Serveur::class);

        $this->jquery->renderView("DashBoard/DashServerIndex.html", ['servers' => $server]);
    }

    #[Route('/DashBoard/CreateServer', name: 'dash.serverCreate')]
    #[Allow(['@ADMIN','@PROF'])]
    public function DashServersProx(){
        $this->jquery->postFormOnClick('#btn-connexion',Router::path('dash.postConnexion'),'form-server','#template-server',['hasLoader'=>'internal']);
        $this->jquery->renderView("DashBoard/DashServers.html");
    }

    #[Post(path: "server/connexion",name: "dash.postConnexion")]
    #[Allow(['@ADMIN','@PROF'])]
    public function connexion(){
        $api = new ProxmoxApi(URequest::post("ipaddress"),URequest::post("login"),URequest::post("password"));
        $vms=$api->getVMs();
        $dt=$this->jquery->semantic()->dataTable('dt-vms', \stdClass::class,$vms);
        $dt->setFields(['vmid','name']);
        $dt->setHasCheckboxes(true);
        $dt->setIdentifierFunction(function($i,$o){
            return $o->vmid.'|'.$o->name;
        });
        $dt->fieldAsLabel('vmid', 'server');
        $dt->setCompact(true);
        $this->jquery->renderView("/DashBoard/connexion.html");
    }

    #[Post(path: "add",name: "dash.postAdd")]
    #[Allow(['@ADMIN','@PROF'])]
    public function postAdd(){
    $server = New Serveur();
    URequest::setValuesToObject($server);
    $datas = URequest::post('selection');
    if (DAO::insert($server)){
        foreach ($datas as $data){
            $champs = explode('|',$data);
            $vm = New Vm();
            $vm->setServeur($server->getId());
            $vm->setNumber($champs[0]);
            $vm->setName($champs[1]);
            if(DAO::insert($vm)){

            }
        }
    }
    }

    #[Route(path: "server/addVm",name: "dash.postAddVm")]
    #[Allow(['@ADMIN','@PROF'])]
    public function addVmToServer(){

        $datas = URequest::post('selection');
        foreach ($datas as $data){
            $champs = explode('|',$data);
            $vm = New Vm();
            $vm->setNumber($champs[0]);
            $vm->setName($champs[1]);
            if(DAO::insert($vm)){
                //Faire message succès
            }
        }
    }

    #[Route(path :"edit/profil",name: "dash.editProfil")]
    #[Allow(['@ADMIN','@PROF','@ETUDIANT'])]
    public function editProfil(){
        $user_id = USession::get('user_id');
        $df=$this->jquery->semantic()->dataForm('frm-profil', $user_id );
        $df->setActionTarget(Router::path('profil-update.submit'), '');
        $df->setProperty('method', 'post');
        $df->setFields(['id','Number','Login','Password','Role','Description','Github','Linkedin','Image','groupes','vms','serveurs', 'submit']);
        $df->fieldAsDropDown('groupes', UArrayModels::asKeyValues(DAO::getAll(Groupe::class),'getId'));
        $df->fieldAsDropDown('serveurs', UArrayModels::asKeyValues(DAO::getAll(Serveur::class), 'getId'));
        $df->fieldAsDropDown('vms', UArrayModels::asKeyValues(DAO::getAll(User_::class), 'getId'));
        $df->fieldAsHidden('id');
        $df->fieldAsSubmit('submit', 'green fluid');
        $this->jquery->renderView('DashBoard/updateFormDashProfil.html');
    }

    #[Post('update', name: 'profil-update.submit')]
    public function update(){
        $user = USession::get('user_id');
        if ($user){
            URequest::setValuesToObject($user);
            DAO::save($user);
        }
    }


    #[Get(path: "/addServer",name: "dash.addServer")]
    #[Allow(['@ADMIN','@PROF','@ETUDIANT'])]
    public function addVm(){
        $serveur=new Serveur();
        $frm=$this->jquery->semantic()->dataForm('serv-form',$serveur);
        $frm->setActionTarget(Router::path('dash.postServ'), '#bodyDashBoard');
        $frm->setProperty('method','post');
        $frm->setFields(['id','IpAddress', 'DnsName', 'Login','Password', 'dnss', 'routes', 'vms', 'user_s', 'submit']);
        $frm->fieldAsDropDown('dnss', UArrayModels::asKeyValues(DAO::getAll(Dns::class),'getId'));
        $frm->fieldAsDropDown('vms', UArrayModels::asKeyValues(DAO::getAll(Vm::class), 'getId'));
        $frm->fieldAsDropDown('routes', UArrayModels::asKeyValues(DAO::getAll(\models\Route::class), 'getId'));
        $frm->fieldAsDropDown('user_s', UArrayModels::asKeyValues(DAO::getAll(User_::class), 'getId'));
        $frm->fieldAsSubmit('submit', 'green','');
        $frm->fieldAsHidden('id');
        $this->jquery->renderView('DashBoard/addServer.html');
    }


    #[Post(path: "addVm/resultPost",name: "dash.postServ")]
    #[Allow(['@ADMIN','@PROF','@ETUDIANT'])]
    public function postVm(){
        $serv= new Serveur();
        if ($serv){
            URequest::setValuesToObject($serv);
            DAO::insert($serv);
        }
        $this->DashServers();
    }
}
