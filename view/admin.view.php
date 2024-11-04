<?php

require_once '../config/Config.php';
Config::setTitol('Gestió d\'usuaris');
Config::setArchiusCSS(['admin']);
Config::setArchiusJS(['delete-user']);

require_once '../model/Usuari/Usuari.php';

session_start();

// Comprova si l'usuari està identificat, si no, el redirigeix a la pàgina principal
if (!isset($_SESSION['usuari'])) {
  header('Location: ..');
}

// Inclou el capçal de la pàgina
include 'components/header.php';

require_once '../model/Usuari/UsuariDAO.php';
$usuariDAO = new UsuariDAO();
$usuaris = $usuariDAO->getUsuaris();

$missatge = getMessage('missatgeAdmin');
$error = getMessage('errorAdmin');

include_once 'components/toasters.php';
?>

<div class="admin">
  <h1>Gestió d'usuaris</h1>

  <hr>

  <div class="llista-usuaris">
    <table>
      <thead>
        <tr>
          <th>Imatge</th>
          <th>Alies</th>
          <th>Nom complet</th>
          <th>Correu electrònic</th>
          <th>Accions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($usuaris as $usuari): ?>
          <tr>
            <td><img src="<?= $usuari->getRutaImatge() ?>" alt="No té imatge"></td>
            <td><?= $usuari->getAlies() ?></td>
            <td <?php if (!$usuari->getNomComplet()) echo 'class="no-configurat"' ?>><?= $usuari->getNomComplet() ?? 'No configurat' ?></td>
            <td><?= $usuari->getEmail() ?></td>
            <td class="accions">
              <a <?= ($_SESSION['usuari']->getId() === $usuari->getId()) ? 'class="disabled"' : "onclick='deleteUsuari(" . $usuari->getId() . ")'" ?>>
                <i class="fas fa-trash-alt"></i>
              </a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>