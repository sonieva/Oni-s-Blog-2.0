<?php
// Santi Onieva

// Es comprova si la petició és de tipus POST i si s'ha enviat el camp 'articlesPerPagina'.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  if (isset($_POST['articlesPerPagina'])) {
    // Es converteix el valor rebut a un enter per assegurar-se que és un número.
    $articlesPerPagina = (int)$_POST['articlesPerPagina'];
    
    // S'estableix una cookie per guardar la configuració d'articles per pàgina, amb una durada d'un any.
    setcookie('articlesPerPagina', $articlesPerPagina, time() + (365 * 24 * 60 * 60), '/');
  }

  if (isset($_POST['ordenaPer'])) {
    // Es recupera el valor de l'opció seleccionada.
    $ordenaPer = $_POST['ordenaPer'];

    // S'estableix una cookie per guardar la configuració d'ordenació, amb una durada d'un any.
    setcookie('ordenaPer', $ordenaPer, time() + (365 * 24 * 60 * 60), '/');
  }
}

// Es redirigeix l'usuari a la pàgina anterior d'on provenia la petició.
header('Location: ' . $_SERVER['HTTP_REFERER']);
exit();
?>
