<?php
// Santi Onieva

require_once '../config/Config.php';
Config::setTitol('Gestió d\'usuaris');
Config::setArchiusCSS(['admin']);
Config::setArchiusJS(['manage-user']);

require_once '../model/Usuari/Usuari.php';

require_once '../utils/utils.php';

usuariEstaLogat();

if (!$_SESSION['usuari']->esAdmin()) {
  http_response_code(403);

  header('Location: ../view/errors/403.html');
  exit();
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
              <a <?= ($_SESSION['usuari']->getId() === $usuari->getId()) ? 'class="disabled"' : "onclick='deleteUsuari(" . $usuari->getId() . ")' title='Eliminar'" ?>>
                <i class="fas fa-trash-alt"></i>
              </a>
              <a <?= ($_SESSION['usuari']->getId() === $usuari->getId() || $usuari->esAdmin()) ? 'class="disabled"' : "onclick='ferAdmin(" . $usuari->getId() . ")' title='Fer admin'" ?>>
                <i class="fa-solid fa-user-tie"></i>
              </a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>