<?php
namespace controllers;

use Ajax\JsUtils;
use Ubiquity\core\postinstall\Display;
use Ubiquity\log\Logger;
use Ubiquity\themes\ThemesManager;

/**
 * Controller IndexController
 *  @property JsUtils $jquery
 */
class IndexController extends ControllerBase {

	public function index() {
        $this->jquery->renderView('Index/index.html');
	}

}
