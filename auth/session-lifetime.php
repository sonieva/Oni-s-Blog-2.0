<?
// Santi Onieva

$maxTempsInactivitat = 2400;

if (isset($_SESSION['ultimaActivitat']) && isset($_SESSION['usuari']) && !str_contains($_SERVER['HTTP_REFERER'], 'login.view.php')) {
    $tempsInactivitat = time() - $_SESSION['ultimaActivitat'];

    if ($tempsInactivitat > $maxTempsInactivitat) {
        $_SESSION['missatgeInactivitat'] = 'Sessió caducada per inactivitat';
        unset($_SESSION['usuari']);

        if (!str_contains($_SERVER['REQUEST_URI'], 'login.view.php')) {
          header('Location: auth/login.view.php');
          exit();
      }
    }
}

$_SESSION['ultimaActivitat'] = time();
?>