<?php
namespace controllers\crud\files;

use Ubiquity\controllers\crud\CRUDFiles;
 /**
  * Class CrudServerControllerFiles
  */
class CrudServerControllerFiles extends CRUDFiles{
	public function getViewIndex(): string{
		return "CrudServerController/index.html";
	}

	public function getViewForm(): string{
		return "CrudServerController/form.html";
	}

	public function getViewDisplay(): string{
		return "CrudServerController/display.html";
	}


}
