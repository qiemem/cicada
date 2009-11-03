<?php
require_once 'MDB2.php';
function getDBConnection(){
    $dsn = array(
        'phptype' => 'mysql',
        'hostspec' => 'localhost',
        'database' => 'cicada',
        'username' => 'root',
        'password' => ''
    );
    $options = array(
        'debug' => 2,
    );
    $mdb2 =& MDB2::singleton($dsn,$options);
    if (PEAR::isError($mdb2)) {
        die($mdb2->getMessage());
    }
    $mdb2->setFetchMode(MDB2_FETCHMODE_ASSOC);
    return $mdb2;
}
?>
