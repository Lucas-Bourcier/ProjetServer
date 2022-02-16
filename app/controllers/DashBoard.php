<?php
namespace controllers;
 use models\Groupe;
 use models\User_;
 use models\Vm;
 use Ubiquity\attributes\items\router\Route;
 use Ubiquity\orm\DAO;
 use Ubiquity\utils\http\URequest;
 use Ubiquity\utils\http\USession;

 /**
  * Controller DashBoard
  */
class DashBoard extends \controllers\ControllerBase{

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

	public function index(){
        $user_id = USession::get('user_id');
        $nbVm=DAO::count(Vm::class, 'idUser = :idUser', ['idUser' => $user_id]);
        $user=DAO::getById(User_::class,1,['groupes']);
        $countGroupes=count($user->getGroupes());
		$this->loadView("DashBoard/index.html", ['name' =>USession::get('name'), 'nbVm' => $nbVm, 'nbGroupes' =>$countGroupes]);
	}

    #[Route('/DashBoard/VM', name: 'dash.vm')]
    public function DashVm(){
        $user_id = USession::get('user_id');
        $vm = DAO::getAll(Vm::class, 'idUser = :idUser', false, ['idUser' => $user_id]);
        $this->loadView("DashBoard/DashVm.html", ['vms' => $vm]);
    }

    #[Route('/DashBoard/Groupes', name: 'dash.groupes')]
    public function DashGroupes(){
        $user_id = USession::get('user_id');
        $groupe = DAO::getAll(Groupe::class, 'idUser = :idUser', false, ['idUser' => $user_id]);
        $this->loadView("DashBoard/DashGroupes.html", ['groupes' => $groupe]);
    }

    #[Route('/DashBoard/Profil', name: 'dash.profil')]
    public function DashProfil(){
        $user_id = USession::get('user_id');
        $user = DAO::getById(User_::class, $user_id);
        $this->loadView("DashBoard/Dashprofil.html", ['users' => $user]);
    }


}
