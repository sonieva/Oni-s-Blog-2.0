<?php
// Santi Onieva

// S'inicia la sessió per poder accedir a les dades de sessió existents.
session_start();

// S'eliminen totes les variables de sessió.
session_unset();

// Es destrueix la sessió actual, eliminant totes les dades de sessió.
session_destroy();

// Es redirigeix l'usuari a la pàgina principal després de tancar la sessió.
header('Location: ..');
exit();
?>
