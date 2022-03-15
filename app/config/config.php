<?php
return array(
	"siteUrl"=>"http://vm-2.sts-sio-caen.info/",
	"database"=>[
			"type"=>"mysql",
			"dbName"=>"proxmox",
			"serverName"=>"127.0.0.1",
			"port"=>3306,
			"user"=>"sio2a",
			"password"=>"sio2a",
			"options"=>array(),
			"cache"=>false,
			"wrapper"=>"Ubiquity\\db\\providers\\pdo\\PDOWrapper"
			],
	"sessionName"=>"s61f7baf559879",
	"namespaces"=>array(),
	"templateEngine"=>"Ubiquity\\views\\engine\\Twig",
	"templateEngineOptions"=>[
			"cache"=>false
			],
	"test"=>false,
	"debug"=>true,
	"logger"=>function (){
		return new \Ubiquity\log\libraries\UMonolog(array (
  'host' => '127.0.0.1',
  'port' => 8090,
  'sessionName' => 's61f7baf559879',
)['sessionName'], \Monolog\Logger::INFO);
	},
	"di"=>[
			"@exec"=>array("jquery"=>function ($controller){
						return \Ajax\php\ubiquity\JsUtils::diSemantic($controller);
					})
			],
	"cache"=>[
			"directory"=>"cache/",
			"system"=>"Ubiquity\\cache\\system\\ArrayCache",
			"params"=>array()
			],
	"mvcNS"=>[
			"models"=>"models",
			"controllers"=>"controllers",
			"rest"=>"",
			"domains"=>"domains"
			],
	"onError"=>function ($code, $message = NULL, $controllerInstance = NULL){
				switch ($code) {
					case 404:
					case 500:
						throw new \Exception($message);
						break;
				}
			}
	);
