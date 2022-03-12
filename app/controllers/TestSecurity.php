<?php
namespace controllers;
use Ubiquity\controllers\auth\AuthController;
use Ubiquity\controllers\auth\WithAuthTrait;

/**
 * Controller TestSecurity
 */
class TestSecurity extends \controllers\ControllerBase {
    use WithAuthTrait;
    public function index(){

    }

    public function hash(){
        echo '<h2>md5</h2>';
        $password='Hj4|)_df4G59ç&q';
        echo \md5($password). '<br>';
        echo \md5('azerty1234');

        echo '<h2>sha1</h2>';
        echo \sha1($password). '<br>';
        echo \sha1('azerty1234');

        echo '<h2>sha256</h2>';
        echo \hash('sha256',$password). '<br>';
        echo \hash('sha256','azerty1234');

        echo '<h2>password_hash</h2>';
        echo \password_hash($password, PASSWORD_DEFAULT). '<br>';
        echo $p1=\password_hash('azerty1234',PASSWORD_DEFAULT);
        echo '<br>';
        echo $p2=\password_hash('azerty1234',PASSWORD_DEFAULT); //Resultat différent entre 2 même password avec pass hash
        echo '<br>';

        if(\password_verify('azerty1234',$p1)){
            echo '<h2>p1 est ok</h2>';
        }else{
            echo '<h2>marche po</h2>';
        }

        if(\password_verify('azerty1234',$p2)){
            echo '<h2>p2 est ok</h2>';
        }else{
            echo '<h2>marche po</h2>';
        }
    }

    protected function getAuthController(): AuthController
    {
        // TODO: Implement getAuthController() method.
    }
}