<?php

require_once 'classes/Controller.php';

if (!isset($_GET['p'])) {
	$p = 'about';
}
else {
	$p = $_GET['p'];
}

if (!isset($_GET['id'])) {
	$id = null;
}
else {
	$id = $_GET['id'];
}

if (!isset($_GET['by'])) {
	$by = null;
}
else {
	$by = $_GET['by'];
}

$controller = new Controller($p, $id, $by);
echo $controller -> display();

?>
