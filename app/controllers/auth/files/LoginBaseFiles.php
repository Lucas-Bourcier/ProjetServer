<?php
namespace controllers\auth\files;

use Ubiquity\controllers\auth\AuthFiles;
 /**
  * Class LoginBaseFiles
  */
class LoginBaseFiles extends AuthFiles{
	public function getViewIndex(){
		return "LoginBase/index.html";
	}

	public function getViewInfo(){
		return "LoginBase/info.html";
	}

	public function getViewNoAccess(){
		return "LoginBase/noAccess.html";
	}

	public function getViewDisconnected(){
		return "LoginBase/disconnected.html";
	}


}
