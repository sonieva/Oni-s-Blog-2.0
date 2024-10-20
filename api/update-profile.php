<?
// Santi Onieva

require_once '../model/Usuari/UsuariDAO.php';
require_once '../model/Usuari/Usuari.php';

session_start();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Obtener el contenido JSON de la petición
  $data = json_decode(file_get_contents('php://input'), true);
  
  if (isset($data['nom_complet']) && isset($_SESSION['usuari'])) {
      $nomComplet = trim($data['nom_complet']);

      $usuariDAO = new UsuariDAO();
      $userOld = $usuariDAO->getUsuariPerId($_SESSION['usuari']->getId());

      // Actualizar el nombre en la base de datos
      $userOld->setNomComplet($nomComplet);
      $success = $usuariDAO->modificar($userOld);
      $_SESSION['usuari'] = $userOld;

      // Devolver una respuesta en formato JSON
      echo json_encode(['success' => $success]);
  } else {
      echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
  }
} else {
  http_response_code(405); // Método no permitido
  echo json_encode(['success' => false, 'message' => 'Método no permitido']);
}