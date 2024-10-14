<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $titol = isset($_POST['titol']) ? htmlspecialchars($_POST['titol']) : '';
  $cos = isset($_POST['cos']) ? htmlspecialchars($_POST['cos']) : '';

  $camps = [
    'titol' => $titol,
    'cos' => $cos,
  ];

  if (isset($_FILES['imatge']) && $_FILES['imatge']['error'] === UPLOAD_ERR_OK) {
    $nombreArchivo = $_FILES['imatge']['name'];
    $rutaTemporal = $_FILES['imatge']['tmp_name'];
    $rutaDestino = '../uploads/tmp/' . $nombreArchivo;

    move_uploaded_file($rutaTemporal, $rutaDestino);

    $camps['imatge'] = $rutaDestino;
  }

  echo json_encode($camps);

} else {
  echo "No se ha proporcionado ningún valor.";
}
?>
