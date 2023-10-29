<?php
header('content-type : application/json; charset=utf-8');
require 'productsModel.php';
$productsModel=new ProductsModel();
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $respuesta = $productsModel->getproducts();
        echo json_encode($respuesta);
    break;
    case 'POST':
        $_POST=json_decode (file_get_contents('php://input',true));
        if (!isset($_POST->name) || is_null($_POST->name) || empty(trim($_POST->name))) {
            $respuesta=['error','El nombre del producto debe estar vacio'];
        }
        else if (!isset($_POST->description) || is_null($_POST->description) || empty(trim($_POST->description))) {
            $respuesta=['error','La descripcion del producto debe estar vacio'];
        }
        else if (!isset($_POST->price) || is_null($_POST->price) || empty(trim($_POST->price))) {
            $respuesta=['error','EL precio del producto debe estar vacio'];
        }
        else{
            $respuesta=$productsModel->saveProducts ($_POST->name,$_POST->description,$_POST->price);
        }
        echo json_encode($respuesta);
    break;
    case 'PUT':
        $_PUT=json_decode(file_get_contents('php://input',true));     
        if (!isset($_PUT->id) || is_null($_PUT->id) || empty(trim($_PUT->id))) {
            $respuesta=['error','El ID del producto debe estar vacio'];
        }
        else if (!isset($_PUT->name) || is_null($_PUT->name) || empty(trim($_PUT->name))) {
            $respuesta=['error','El nombre del producto debe estar vacio'];
        }
        else if (!isset($_PUT->description) || is_null($_PUT->description) || empty(trim($_PUT->description))) {
            $respuesta=['error','la descripcion del producto debe estar vacio'];
        }
        else if (!isset($_PUT->price) || is_null($_PUT->price) || empty(trim($_PUT->price))) {
            $respuesta=['error','El precio del producto debe estar vacio'];
        }
        else{
            $respuesta=$productsModel->updateProducts($_PUT->id,$_PUT->name,$_PUT->description,$_PUT->price);
        }
        echo json_encode($respuesta);
    break;
    case 'DELETE':
        $_DELETE=json_decode(file_get_contents('php://input',true));
        if (!isset($_DELETE->id) || is_null($_DELETE->id) || empty(trim($_DELETE->id))) {
            $respuesta=['error','El ID del producto debe estar vacio'];
        }
        else{
            $respuesta=$productsModel->deleteProducts($_DELETE->id);
        }
        echo json_encode($respuesta);

    break;
}
