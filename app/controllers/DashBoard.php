<?php
namespace controllers;
 /**
  * Controller DashBoard
  */
class DashBoard extends \controllers\ControllerBase{

	public function index(){
		$this->loadView("DashBoard/index.html");
	}
}
