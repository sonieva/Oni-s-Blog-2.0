<?php
// check-alies.php
require_once '../model/Connexio.php';
require_once '../utils/Logger.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    if (isset($data['alies'])) {
      $alies = trim($data['alies']);

      try {
        // Conectar a la base de datos
        $pdo = Connexio::getInstance()->getConnection();
  
        // Preparar la consulta para verificar si el alias ya existe
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM usuaris WHERE alies = :alias");
        $stmt->execute(['alias' => $alies]);
  
        // Obtener el resultado
        $count = $stmt->fetchColumn();
  
        if ($count === false || $count == 0) {
          // Si no hay resultados, significa que el alias está disponible
          $disponible = true;
        } else {
          // Si hay un resultado, significa que el alias ya está en uso
          $disponible = false;
        }
      } catch (PDOException $e) {
        Logger::log('Error al comprobar la disponibilidad del alias: ' . $e->getMessage());
        // Si hay un error, devolver el mensaje de error
        $disponible = false;
      }

      // Devolver la respuesta en formato JSON
      header('Content-Type: application/json');
      echo json_encode(['disponible' => $disponible]);
    }
}
?>
