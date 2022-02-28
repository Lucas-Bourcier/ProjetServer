<?php
namespace controllers;
use controllers\crud\datas\CrudServerControllerDatas;
use Ubiquity\controllers\crud\CRUDDatas;
use controllers\crud\viewers\CrudServerControllerViewer;
use Ubiquity\controllers\crud\viewers\ModelViewer;
use controllers\crud\events\CrudServerControllerEvents;
use Ubiquity\controllers\crud\CRUDEvents;
use controllers\crud\files\CrudServerControllerFiles;
use Ubiquity\controllers\crud\CRUDFiles;
use Ubiquity\attributes\items\router\Route;

#[Route(path: "/CrudServer",inherited: true,automated: true)]
class CrudServerController extends \Ubiquity\controllers\crud\CRUDController{

	public function __construct(){
		parent::__construct();
		\Ubiquity\orm\DAO::start();
		$this->model='models\\Serveur';
		$this->style='';
	}

	public function _getBaseRoute(): string {
		return '/CrudServer';
	}
	
	protected function getAdminData(): CRUDDatas{
		return new CrudServerControllerDatas($this);
	}

	protected function getModelViewer(): ModelViewer{
		return new CrudServerControllerViewer($this,$this->style);
	}

	protected function getEvents(): CRUDEvents{
		return new CrudServerControllerEvents($this);
	}

	protected function getFiles(): CRUDFiles{
		return new CrudServerControllerFiles();
	}


}
