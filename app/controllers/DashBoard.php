<?php
namespace controllers;
 use Ajax\php\ubiquity\JsUtils;
 use models\Groupe;
 use models\Serveur;
 use models\User_;
 use models\Vm;
 use Ubiquity\attributes\items\acl\Allow;
 use Ubiquity\attributes\items\router\Route;
 use Ubiquity\controllers\auth\AuthController;
 use Ubiquity\controllers\auth\WithAuthTrait;
 use Ubiquity\orm\DAO;
 use Ubiquity\security\acl\controllers\AclControllerTrait;
 use Ubiquity\utils\http\URequest;
 use Ubiquity\utils\http\USession;

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
        $this->loadView("DashBoard/Dashprofil.html", ['users' => $user]);
    }

    #[Route('/DashBoard/Serveurs', name: 'dash.server')]
    #[Allow(['@ADMIN','@PROF'])]
    public function DashServers(){
        $server = DAO::getAll(Serveur::class);
        $this->loadView("DashBoard/DashServers.html", ['servers' => $server]);
    }





}
