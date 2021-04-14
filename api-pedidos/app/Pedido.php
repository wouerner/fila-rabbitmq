<?php 
namespace App;

class Pedido {
    private $produto;

    public function __construct(){
        $this->produto = $_POST['produto'];
    }

    private function returnJson($data){
        header('Content-type: application/json');
        header('Access-Control-Allow-Origin: *');

        echo $data;
        die;
    }

    public function store() {
        // database
        $pdo = new \PDO('sqlite:' . __DIR__ . '/../db/pedidos.db');

        $sql = "INSERT INTO Pedidos (produtos) VALUES (?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$produto]);

        $produto = ['id' => $pdo->lastInsertId(), 'produto' => $produto];

        $produto = json_encode($produto);

        // rabbit
        new \App\Rabbitmq($produto);

        $this->returnJson($produto);

        $this->returnJson('atualizado');
    }


    public function update() {
        $this->returnJson('atualizado');
    }
}
