<?php
require_once("person.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];
    $person = new Person;
    $result = array();

    if ($action == 'get_info') {
        $id = $_POST['id'];
        $locale = $_POST['locale'];
        $result = $person->getInfo($id, $locale);
    } else {
        $result['success'] = 0;
        $result['error'] = "wrong action";
    }

    echo json_encode($result);

} else {
    $error = array();
    $error['success'] = 0;
    $error['error'] = "wrong request";
    echo json_encode($error);
    die();
}