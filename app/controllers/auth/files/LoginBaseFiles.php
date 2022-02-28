<?php
namespace controllers\auth\files;

use Ubiquity\controllers\auth\AuthFiles;
 /**
  * Class LoginBaseFiles
  */
class LoginBaseFiles extends AuthFiles{
	public function getViewIndex() :string{
		return "LoginBase/index.html";
	}

	public function getViewInfo() :string{
		return "LoginBase/info.html";
	}

	public function getViewNoAccess():string{
		return "LoginBase/noAccess.html";
	}

	public function getViewDisconnected():string{
		return "LoginBase/disconnected.html";
	}


}
