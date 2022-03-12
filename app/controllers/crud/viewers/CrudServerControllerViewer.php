<?php
namespace controllers\crud\viewers;

use Ubiquity\controllers\crud\viewers\ModelViewer;
 /**
  * Class CrudServerControllerViewer
  */
class CrudServerControllerViewer extends ModelViewer{
	//use override/implement Methods
    public function isModal($objects, $model)
    {
        return true;
    }

}
