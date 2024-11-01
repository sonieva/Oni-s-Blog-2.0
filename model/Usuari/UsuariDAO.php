<?php
// Santi Onieva

require_once '../model/Connexio.php';
require_once 'Usuari.php';

class UsuariDAO {
  // Atribut privat per a emmagatzemar la connexió PDO.
  private PDO $pdo;

  // Constructor que inicialitza la connexió a la base de dades utilitzant la classe Connexio.
  public function __construct() {
    $this->pdo = Connexio::getInstance()->getConnection();
  }

  // Insereix un nou usuari a la base de dades.
  public function inserir(Usuari $usuari) {
    $sentenciaAfegir = $this->pdo->prepare("INSERT INTO usuaris (alies, email, password) VALUES (:alies, :email, :password)");

    // Executa la sentència d'inserció i retorna el resultat.
    return $sentenciaAfegir->execute([
      'alies' => $usuari->getAlies(),
      'email' => $usuari->getEmail(),
      'password' => $usuari->getPassword(),
    ]);
  }

  // Obté un usuari de la base de dades pel seu ID.
  public function getUsuariPerId(int $id): Usuari {
    $sentencia = $this->pdo->prepare("SELECT * FROM usuaris WHERE id = :id");

    // Executa la consulta.
    $sentencia->execute(['id' => $id]);

    // Obté el resultat de la consulta.
    $resultat = $sentencia->fetch();

    // Retorna un objecte Usuari amb les dades recuperades.
    return new Usuari(
      $resultat['alies'], 
      $resultat['email'], 
      $resultat['password'], 
      $resultat['nom_complet'], 
      $resultat['id'], 
      $resultat['token_recuperacio'], 
      isset($resultat['expiracio_token']) ? new DateTime($resultat['expiracio_token']) : null,
      $resultat['ruta_imatge']
    );
  }

  // Obté un usuari de la base de dades pel seu correu electrònic.
  public function getUsuariPerEmail(string $email): ?Usuari {
    $sentencia = $this->pdo->prepare("SELECT * FROM usuaris WHERE email = :email");

    // Executa la consulta.
    $sentencia->execute(['email' => $email]);

    // Comprova si hi ha algun resultat.
    if ($sentencia->rowCount() === 0) {
      return null;
    }

    // Obté el resultat i retorna un objecte Usuari.
    $resultat = $sentencia->fetch();
    return new Usuari(
      $resultat['alies'], 
      $resultat['email'], 
      $resultat['password'], 
      $resultat['nom_complet'], 
      $resultat['id'],
      $resultat['token_recuperacio'],
      isset($resultat['expiracio_token']) ? new DateTime($resultat['expiracio_token']) : null,
      $resultat['ruta_imatge']
    );
  }

  // Obté un usuari de la base de dades pel seu token de recuperació.
  public function getUsuariPerToken(string $token): ?Usuari {
    $sentencia = $this->pdo->prepare("SELECT * FROM usuaris WHERE token_recuperacio = :token");

    // Executa la consulta.
    $sentencia->execute(['token' => $token]);

    if ($sentencia->rowCount() === 0) {
      return null;
    }

    // Obté el resultat de la consulta.
    $resultat = $sentencia->fetch();

    // Retorna un objecte Usuari amb les dades recuperades.
    return new Usuari(
      $resultat['alies'], 
      $resultat['email'], 
      $resultat['password'], 
      $resultat['nom_complet'], 
      $resultat['id'], 
      $resultat['token_recuperacio'], 
      isset($resultat['expiracio_token']) ? new DateTime($resultat['expiracio_token']) : null,
      $resultat['ruta_imatge']
    );
  }

  // Modifica les dades d'un usuari existent a la base de dades.
  public function modificar(Usuari $usuari) {
    $sentenciaModificar = $this->pdo->prepare("UPDATE usuaris SET alies = :alies, email = :email, password = :password, nom_complet = :nom_complet, token_recuperacio = :token_recuperacio, expiracio_token = :expiracio_token, ruta_imatge = :ruta_imatge WHERE id = :id");

    // Executa la sentència d'actualització amb les dades de l'usuari i retorna el resultat.
    return $sentenciaModificar->execute([
      'alies' => $usuari->getAlies(),
      'email' => $usuari->getEmail(),
      'password' => $usuari->getPassword(),
      'nom_complet' => ($usuari->getNomComplet()) ?? null,
      'id' => $usuari->getId(),
      'token_recuperacio' => $usuari->getTokenRecuperacio(),
      'expiracio_token' => ($usuari->getExpiracioToken()) ? $usuari->getExpiracioToken()->format('Y-m-d H:i:s') : null,
      'ruta_imatge' => $usuari->getRutaImatge()
    ]);
  }

  // Elimina un usuari de la base de dades pel seu ID.
  public function eliminar($id) {
    $sentenciaEliminar = $this->pdo->prepare("DELETE FROM usuaris WHERE id = :id");

    // Executa la sentència d'eliminació i retorna el resultat.
    return $sentenciaEliminar->execute(['id' => $id]);
  }
}
