<?php
namespace controllers;
use Ubiquity\attributes\items\router\Route;

#[Route(path: "/crudVm",inherited: true,automated: true)]
class CrudVm extends \Ubiquity\controllers\crud\CRUDController{

	public function __construct(){
		parent::__construct();
		\Ubiquity\orm\DAO::start();
		$this->model='models\\Vm';
		$this->style='';
	}

	public function _getBaseRoute() {
		return '/crudVm';
	}
	

}
