<?php
namespace controllers\crud\files;

use Ubiquity\controllers\crud\CRUDFiles;
 /**
  * Class CrudUserFiles
  */
class CrudUserFiles extends CRUDFiles{
	public function getViewIndex(): string{
		return "CrudUser/index.html";
	}

	public function getViewForm() :string{
		return "CrudUser/form.html";
	}

	public function getViewDisplay(): string{
		return "CrudUser/display.html";
	}


}
