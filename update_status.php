<?php
require_once '_app/Config.inc.php';

// Parâmetros para a atualização
$status = $_POST['status']; // Novo status enviado pelo AJAX
$pedidoId = $_POST['pedidoId']; // ID do pedido
$view = $_POST['view'];

try {
    $conn = new PDO('mysql:host=' . HOST . ';dbname=' . DBSA, USER, PASS);

    // Prepara a instrução SQL
    $sql = "UPDATE ws_pedidos SET status = :status, view = 1 WHERE id = :pedidoId";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':status', $status, PDO::PARAM_STR);
    $stmt->bindParam(':pedidoId', $pedidoId, PDO::PARAM_INT);

    // Executa a atualização
    if ($stmt->execute()) {
        echo "Update realizado com sucesso.";
    } else {
        echo "Erro ao realizar o update.";
    }
} catch (PDOException $e) {
    echo "Erro na conexão com o banco de dados: " . $e->getMessage();
}
?>
