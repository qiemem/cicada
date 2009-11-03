<?php
require_once 'controllers/HomeController.php';
require_once 'controllers/SubmissionsController.php';

function callModuleAction($module, $action) {
    $controllerName = $module.'Controller';
    $controller = new $controllerName;
    $actionValues = array();
    foreach( $_GET as $key => $value){
        $actionValues[$key]=$value;
    }
    foreach( $_POST as $key => $value) {
        $actionValues[$key]=$value;
    }
    $controller->$action($actionValues);
}

$module = 'home';
if(isset($_GET['module'])) {
    $module = $_GET['module'];
}

$action = 'index';
if(isset($_GET['action'])) {
    $action = $_GET['action'];
}

callModuleAction($module, $action);
?>
