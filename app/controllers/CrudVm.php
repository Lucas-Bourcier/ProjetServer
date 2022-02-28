<?php
namespace controllers;
use controllers\crud\files\CrudVmFiles;
use models\User_;
use models\Vm;
use Ubiquity\controllers\crud\CRUDFiles;
use Ubiquity\attributes\items\router\Route;
use Ubiquity\orm\DAO;
use Ubiquity\utils\http\URequest;
use Ubiquity\utils\http\USession;

#[Route(path: "/crudVm",inherited: true,automated: true)]
class CrudVm extends \Ubiquity\controllers\crud\CRUDController{

	public function __construct(){
		parent::__construct();
		\Ubiquity\orm\DAO::start();
		$this->model='models\\Vm';
		$this->style='';
	}

	public function _getBaseRoute():string {
		return '/crudVm';
	}
	
	protected function getFiles(): CRUDFiles{
		return new CrudVmFiles();
	}
}
