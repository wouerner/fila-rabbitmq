<?php 
namespace App;

class Pedido {
    public function __construct(){
        $produto = $_POST['produto'];

        $produto = ['id' => rand(), 'produto' => $produto];

        $produto = json_encode($produto);

        // rabbit
        include '../send.php';

        header('Content-type: application/json');
        header('Access-Control-Allow-Origin: *');

        echo $produto;
        die;
    }

}
