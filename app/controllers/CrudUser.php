<?php
namespace controllers;
use controllers\crud\files\CrudUserFiles;
use Ubiquity\controllers\crud\CRUDFiles;
use Ubiquity\attributes\items\router\Route;

#[Route(path: "/crudUser",inherited: true,automated: true)]
class CrudUser extends \Ubiquity\controllers\crud\CRUDController{

	public function __construct(){
		parent::__construct();
		\Ubiquity\orm\DAO::start();
		$this->model='models\\User_';
		$this->style='';
	}

	public function _getBaseRoute() {
		return '/crudUser';
	}
	
	protected function getFiles(): CRUDFiles{
		return new CrudUserFiles();
	}


}
