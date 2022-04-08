<?php
session_start();
// Change selected language
$q = $_REQUEST["q"];

$_SESSION['selected_problem'] = "#" + $q;
$_SESSION['changed'] = true;

echo "changed";


?>