<?php
namespace controllers;
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
		$this->loadView("DashBoard/index.html", ['name' =>USession::get('name')]);
	}


}
