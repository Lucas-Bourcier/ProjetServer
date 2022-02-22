<?php
namespace controllers\crud\files;

use Ubiquity\controllers\crud\CRUDFiles;
 /**
  * Class CrudUserFiles
  */
class CrudUserFiles extends CRUDFiles{
	public function getViewIndex(){
		return "CrudUser/index.html";
	}

	public function getViewForm(){
		return "CrudUser/form.html";
	}

	public function getViewDisplay(){
		return "CrudUser/display.html";
	}


}
