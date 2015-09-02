<?php  
require 'vendor/autoload.php';  

use Illuminate\Database\Capsule\Manager as Capsule;  

$capsule = new Capsule; 

$capsule->addConnection(array(
    'driver'    => 'mysql',
    'host'      => 'localhost',
    'database'  => 'kompass',
    'username'  => 'root',
    'password'  => 'azerty',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => ''
));

$capsule->bootEloquent();
