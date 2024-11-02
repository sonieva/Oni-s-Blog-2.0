<?php
// Santi Onieva

// Es defineix el temps màxim d'inactivitat (en segons).
$maxTempsInactivitat = 2400;

// Es comprova si existeix la variable de sessió 'ultimaActivitat' i si hi ha un usuari loguejat.
// També es verifica que l'usuari no es trobi a la pàgina de login.
if (isset($_SESSION['ultimaActivitat']) && isset($_SESSION['usuari']) && (!isset($_SERVER['HTTP_REFERER']) || !str_contains($_SERVER['HTTP_REFERER'], 'login.view.php'))) {
    // Es calcula el temps d'inactivitat restant.
    $tempsInactivitat = time() - $_SESSION['ultimaActivitat'];

    // Si el temps d'inactivitat supera el límit establert, es destrueix la sessió de l'usuari.
    if ($tempsInactivitat > $maxTempsInactivitat) {
        // S'emmagatzema un missatge per indicar que la sessió ha caducat per inactivitat.
        setMessage('missatgeInactivitat','Sessió caducada per inactivitat');
        
        // S'elimina l'usuari de la sessió.
        unset($_SESSION['usuari']);

        // Es redirigeix a la pàgina de login si no s'hi troba actualment.
        if (!str_contains($_SERVER['REQUEST_URI'], 'login.view.php')) {
            header('Location: auth/login.view.php');
            exit();
        }
    }
}

// S'actualitza la variable de sessió 'ultimaActivitat' amb l'hora actual.
$_SESSION['ultimaActivitat'] = time();
?>
