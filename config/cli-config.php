<?php
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

// replace with file to your own project bootstrap
//require_once 'bootstrap.php';
require_once "vendor/autoload.php";

;



// replace with mechanism to retrieve EntityManager in
//$entityManager = GetEntityManager();
$paths = array(__DIR__."/../module/Blog/src/Blog/Entity");
$isDevMode = true;

$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode, null, null, false);

// database configuration parameters
$conn = array(
    'driver'    => 'pdo_mysql',
    'host'      => 'localhost',
    'port'      => '3306',
    'user'      => 'root',
    'password'  => '',
    'dbname'    => 'zend21',
    'charset'   => 'utf8',
    'driverOptions' => [
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
    ]
);



$entityManager = EntityManager::create($conn, $config);

return ConsoleRunner::createHelperSet($entityManager);