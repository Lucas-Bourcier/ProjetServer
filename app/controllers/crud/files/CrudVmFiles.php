<?php
namespace controllers\crud\files;

use Ubiquity\controllers\crud\CRUDFiles;
 /**
  * Class CrudVmFiles
  */
class CrudVmFiles extends CRUDFiles{
	public function getViewIndex(): string{
		return "CrudVm/index.html";
	}

	public function getViewForm(): string{
		return "CrudVm/form.html";
	}

	public function getViewDisplay(): string{
		return "CrudVm/display.html";
	}


}
