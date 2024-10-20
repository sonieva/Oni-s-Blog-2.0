<?php
// Santi Onieva

// Es comprova si la petició és de tipus POST.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // S'inicia la sessió per accedir a les variables de sessió.
  session_start();

  // Es valida i s'obté el títol, assegurant-se que no sigui buit.
  $titol = isset($_POST['titol']) && !empty($_POST['titol']) ? $_POST['titol'] : null;
  // Es valida i s'obté el cos de l'article, assegurant-se que no sigui buit.
  $cos = isset($_POST['cos']) && !empty($_POST['cos']) ? $_POST['cos'] : null;

  // Es prepara un array amb els camps de l'article.
  $camps = [
    'titol' => $titol,
    'cos' => $cos,
  ];

  // Es comprova si s'ha enviat una imatge i que no hi hagi errors en la pujada.
  if (isset($_FILES['imatge']) && $_FILES['imatge']['error'] === UPLOAD_ERR_OK) {
    // S'obté el nom de la imatge i la seva ruta temporal.
    $nomImatge = $_FILES['imatge']['name'];
    $rutaTemporal = $_FILES['imatge']['tmp_name'];
    $rutaDesti = '../uploads/tmp/' . $nomImatge;

    // Es comprova si ja existeix una imatge anterior a la sessió.
    if (isset($_SESSION['imagen_anterior'])) {
      // Es genera la ruta de la imatge anterior.
      $imagenAnteriorRuta = '../uploads/tmp/' . $_SESSION['imagen_anterior'];
      
      // Si la imatge anterior existeix al servidor, s'elimina.
      if (file_exists($imagenAnteriorRuta)) {
          unlink($imagenAnteriorRuta);
      }
    }

    // Es mou la imatge pujada a la carpeta de destinació.
    move_uploaded_file($rutaTemporal, $rutaDesti);
    // S'emmagatzema el nom de la nova imatge a la sessió.
    $_SESSION['imagen_anterior'] = $nomImatge;

    // S'afegeix la ruta de la imatge al array de camps.
    $camps['imatge'] = $rutaDesti;
  }

  // Es retorna la informació dels camps en format JSON.
  echo json_encode($camps);
}
?>
