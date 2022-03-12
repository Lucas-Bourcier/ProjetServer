<?php
namespace controllers\auth\files;

use Ubiquity\controllers\auth\AuthFiles;
 /**
  * Class LoginBaseFiles
  */
class LoginBaseFiles extends AuthFiles{

    public function  getViewCreate(): string
    {
        return "LoginBase/create.html";
    }

    public function getViewInitRecovery(): string
    {
        return "LoginBase/initRecovery.html";
    }

    public function getViewRecovery(): string
    {
        return "LoginBase/recovery.html";
    }

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
