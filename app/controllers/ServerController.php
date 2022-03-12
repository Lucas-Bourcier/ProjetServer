<?php
namespace controllers;
use Ajax\php\ubiquity\JsUtils;
use PHPMV\ProxmoxApi;
use Ubiquity\attributes\items\router\Route;
 /**
  * Controller ServerController
  * @property JsUtils $jquery
  */
class ServerController extends \controllers\ControllerBase{

	public function index(){
		$this->loadView("ServerController/index.html");
	}

	#[Route(path: "vms",name: "server.vms")]
	public function vms(){
        $api = new ProxmoxApi('62.210.189.36','sio2a','sio2a');
        $vms=$api->getVMs();
        $dt=$this->jquery->semantic()->dataTable('dt-vms', \stdClass::class,$vms);
        $dt->setFields(['vmid','name',]);
        $dt->setHasCheckboxes(true);
        $dt->fieldAsLabel('vmid', 'server');
		$this->jquery->renderView('ServerController/vms.html');
	}
}
