<?php
namespace controllers\crud\files;

use Ubiquity\controllers\crud\CRUDFiles;
 /**
  * Class CrudVmFiles
  */
class CrudVmFiles extends CRUDFiles{
	public function getViewIndex(){
		return "CrudVm/index.html";
	}

	public function getViewForm(){
		return "CrudVm/form.html";
	}

	public function getViewDisplay(){
		return "CrudVm/display.html";
	}


}
