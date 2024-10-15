<?php
// Santi Onieva

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  session_start();

  $titol = isset($_POST['titol']) && !empty($_POST['titol']) ? htmlspecialchars($_POST['titol']) : null;
  $cos = isset($_POST['cos']) && !empty($_POST['cos']) ? htmlspecialchars($_POST['cos']) : null;

  $camps = [
    'titol' => $titol,
    'cos' => $cos,
  ];

  if (isset($_FILES['imatge']) && $_FILES['imatge']['error'] === UPLOAD_ERR_OK) {
    $nomImatge = $_FILES['imatge']['name'];
    $rutaTemporal = $_FILES['imatge']['tmp_name'];
    $rutaDesti = '../uploads/tmp/' . $nomImatge;

    if (isset($_SESSION['imagen_anterior'])) {
      $imagenAnteriorRuta = '../uploads/tmp/' . $_SESSION['imagen_anterior'];
      
      if (file_exists($imagenAnteriorRuta)) {
          unlink($imagenAnteriorRuta);
      }
  }

    move_uploaded_file($rutaTemporal, $rutaDesti);
    $_SESSION['imagen_anterior'] = $nomImatge;

    $camps['imatge'] = $rutaDesti;
  }

  echo json_encode($camps);
}
?>
