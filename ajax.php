<?php

echo "<pre>";
print_r($_REQUEST);die;  //TEST AJAX GETING ALL FEILD DATA
print_r($_FILES);die;     //TESTING THE PLAYERS IMAGE FILE GET CURRECTLY OR NOT?

$action = $_REQUEST['action'];
if (!empty($action)) {
    require_once 'include/Player.php';
    $obj = new Player();
}

if ($action == 'adduser' && !empty($_POST)) {
    $pname = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $photo = $_FILES['photo'];
    $pid = (!empty($_POST['userid'])) ? $_POST['userid'] : '';

    //validations
    //file(photo) upload
    $imagename = '';
    if (!empty($photo['name'])) {
        $imagename = $obj->uploadPhoto($photo);
        $playerData = [
            'pname' => $pname,
            'email' => $email,
            'phone' => $phone,
            'photo' => $imagename,
        ];
    }else{
        $playerData = [
            'pname' => $pname,
            'email' => $email,
            'phone' => $phone,
        ];
    }

    $playerId = $obj->add($playerData);
    if(!empty($playerId)){
        $player = $obj->getRow('id', $playerId);
        echo json_encode($player);
        exit();
    }
}