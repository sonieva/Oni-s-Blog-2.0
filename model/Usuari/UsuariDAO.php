<?php
// Santi Onieva

require_once '../model/Connexio.php';
require_once 'Usuari.php';

class UsuariDAO {
  private PDO $pdo;

  public function __construct() {
    $this->pdo = Connexio::getInstance()->getConnection();
  }

  public function inserir(Usuari $usuari) {
    $sentenciaAfegir = $this->pdo->prepare("INSERT INTO usuaris (alies, email, password) VALUES (:alies, :email, :password)");

    return $sentenciaAfegir->execute([
      'alies' => $usuari->getAlies(),
      'email' => $usuari->getEmail(),
      'password' => $usuari->getPassword(),
    ]);
  }

  public function getUsuariPerId($id) {
    $sentencia = $this->pdo->prepare("SELECT * FROM usuaris WHERE id = :id");

    $sentencia->bindParam(':id', $id);

    $sentencia->execute();

    $resultat = $sentencia->fetch();

    return new Usuari($resultat['alies'], $resultat['email'], $resultat['password'], $resultat['nom_complet'], $resultat['id']);
  }

  public function getUsuariPerEmail($email) {
    $sentencia = $this->pdo->prepare("SELECT * FROM usuaris WHERE email = :email");

    $sentencia->bindParam(':email', $email);

    $sentencia->execute();

    if ($sentencia->rowCount() === 0) {
      return null;
    } else {
      $resultat = $sentencia->fetch();
      return new Usuari($resultat['alies'], $resultat['email'], $resultat['password'], $resultat['nom_complet'], $resultat['id']);
    }
  }

  public function modificar(Usuari $usuari) {
    $sentenciaModificar = $this->pdo->prepare("UPDATE usuaris SET alies = :alies, email = :email, password = :password, nom_complet = :nom_complet WHERE id = :id");

    $sentenciaModificar->bindParam(':id', $usuari->getId());
    $sentenciaModificar->bindParam(':alies', $usuari->getAlies());
    $sentenciaModificar->bindParam(':email', $usuari->getEmail());
    $sentenciaModificar->bindParam(':password', $usuari->getPassword());
    $sentenciaModificar->bindParam(':nom_complet', $usuari->getNomComplet());

    return $sentenciaModificar->execute();
  }

  public function eliminar($id) {
    $sentenciaEliminar = $this->pdo->prepare("DELETE FROM usuaris WHERE id = :id");

    $sentenciaEliminar->bindParam(':id', $id);

    return $sentenciaEliminar->execute();
  }
}