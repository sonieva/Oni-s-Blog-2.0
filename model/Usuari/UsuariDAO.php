<?php
// Santi Onieva

require_once $_SERVER['DOCUMENT_ROOT'] . '/model/Connexio.php';
require_once 'Usuari.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/Logger.php';

class UsuariDAO {
  // Atribut privat per a emmagatzemar la connexió PDO.
  private PDO $pdo;

  // Constructor que inicialitza la connexió a la base de dades utilitzant la classe Connexio.
  public function __construct() {
    try {
      $this->pdo = Connexio::getInstance()->getConnection();
    } catch (PDOException $e) {
      Logger::log("Error al obtenir la connexio a la base de dades: " . $e->getMessage(), TipusLog::ERROR_LOG, LogLevel::ERROR);
    }
  }

  // Insereix un nou usuari a la base de dades.
  public function inserir(Usuari $usuari) {
    try {
      $sentenciaAfegir = $this->pdo->prepare("INSERT INTO usuaris (alies, email, password, nom_complet, ruta_imatge) VALUES (:alies, :email, :password, :nom_complet, :ruta_imatge)");
  
      // Executa la sentència d'inserció i retorna el resultat.
      $resultat = $sentenciaAfegir->execute([
        'alies' => $usuari->getAlies(),
        'email' => $usuari->getEmail(),
        'password' => $usuari->getPassword(),
        'nom_complet' => $usuari->getNomComplet(),
        'ruta_imatge' => $usuari->getRutaImatge()
      ]);

      Logger::log("Usuari inserit correctament", TipusLog::DATABASE_LOG, LogLevel::INFO);

      return $resultat;
    } catch (PDOException $e) {
      Logger::log("Error en el metode inserir de UsuariDAO: " . $e->getMessage(), TipusLog::DATABASE_ERROR, LogLevel::ERROR);
      return false;
    }
  }

  // Obté tots els usuaris de la base de dades.
  public function getUsuaris(): array {
    $usuaris = [];
    
    try {
      $sentencia = $this->pdo->query("SELECT * FROM usuaris");
  
      // Recorre tots els resultats de la consulta i els emmagatzema en un array d'usuaris.
      foreach ($sentencia->fetchAll() as $resultat) {
        $usuaris[] = new Usuari(
          $resultat['alies'], 
          $resultat['email'], 
          $resultat['password'], 
          $resultat['nom_complet'], 
          $resultat['id'], 
          $resultat['token_recuperacio'], 
          isset($resultat['expiracio_token']) ? new DateTime($resultat['expiracio_token']) : null,
          $resultat['ruta_imatge'],
          $resultat['es_admin']
        );
      }

      Logger::log("Usuaris obtinguts correctament al metode getUsuaris de UsuariDAO", TipusLog::DATABASE_LOG, LogLevel::INFO);
  
    } catch (PDOException $e) {
      Logger::log("Error en el metode getUsuaris de UsuariDAO: " . $e->getMessage(), TipusLog::DATABASE_ERROR, LogLevel::ERROR);
    }

    return $usuaris;
  }

  // Obté un usuari de la base de dades pel seu ID.
  public function getUsuariPerId(int $id): ?Usuari {
    try {
      $sentencia = $this->pdo->prepare("SELECT * FROM usuaris WHERE id = :id");
  
      // Executa la consulta.
      $sentencia->execute(['id' => $id]);

      // Comprova si hi ha algun resultat.
      if ($sentencia->rowCount() === 0) {
        return null;
      }
  
      // Obté el resultat de la consulta.
      $resultat = $sentencia->fetch();
      
      Logger::log("Usuari obtingut correctament al metode getUsuariPerId a UsuariDAO", TipusLog::DATABASE_LOG, LogLevel::INFO);
      
      // Retorna un objecte Usuari amb les dades recuperades.
      return new Usuari(
        $resultat['alies'], 
        $resultat['email'], 
        $resultat['password'], 
        $resultat['nom_complet'], 
        $resultat['id'], 
        $resultat['token_recuperacio'], 
        isset($resultat['expiracio_token']) ? new DateTime($resultat['expiracio_token']) : null,
        $resultat['ruta_imatge'],
        $resultat['es_admin']
      );
    } catch (PDOException $e) {
      Logger::log("Error en el metode getUsuariPerId de UsuariDAO: " . $e->getMessage(), TipusLog::DATABASE_ERROR, LogLevel::ERROR);
      return null;
    }
  }

  // Obté un usuari de la base de dades pel seu correu electrònic.
  public function getUsuariPerEmail(string $email): ?Usuari {
    try {
      $sentencia = $this->pdo->prepare("SELECT * FROM usuaris WHERE email = :email");
  
      // Executa la consulta.
      $sentencia->execute(['email' => $email]);
  
      // Comprova si hi ha algun resultat.
      if ($sentencia->rowCount() === 0) {
        return null;
      }
  
      // Obté el resultat i retorna un objecte Usuari.
      $resultat = $sentencia->fetch();
      
      Logger::log("Usuari obtingut correctament al metode getUsuariPerEmail de UsuariDAO", TipusLog::DATABASE_LOG, LogLevel::INFO);
      
      return new Usuari(
        $resultat['alies'], 
        $resultat['email'], 
        $resultat['password'], 
        $resultat['nom_complet'], 
        $resultat['id'],
        $resultat['token_recuperacio'],
        isset($resultat['expiracio_token']) ? new DateTime($resultat['expiracio_token']) : null,
        $resultat['ruta_imatge'],
        $resultat['es_admin']
      );
    } catch (PDOException $e) {
      Logger::log("Error en el metode getUsuariPerEmail de UsuariDAO: " . $e->getMessage(), TipusLog::DATABASE_ERROR, LogLevel::ERROR);
      return null;
    }
  }

  public function getUsuariPerAliesOEmail(string $user): ?Usuari {
    try {
      $sentencia = $this->pdo->prepare("SELECT * FROM usuaris WHERE alies = :user OR email = :user");
  
      // Executa la consulta.
      $sentencia->execute(['user' => $user]);
  
      // Comprova si hi ha algun resultat.
      if ($sentencia->rowCount() === 0) {
        return null;
      }
  
      // Obté el resultat i retorna un objecte Usuari.
      $resultat = $sentencia->fetch();
      
      Logger::log("Usuari obtingut correctament al metode getUsuariPerAliesOEmail de UsuariDAO", TipusLog::DATABASE_LOG, LogLevel::INFO);
      
      return new Usuari(
        $resultat['alies'], 
        $resultat['email'], 
        $resultat['password'], 
        $resultat['nom_complet'], 
        $resultat['id'],
        $resultat['token_recuperacio'],
        isset($resultat['expiracio_token']) ? new DateTime($resultat['expiracio_token']) : null,
        $resultat['ruta_imatge'],
        $resultat['es_admin']
      );
    } catch (PDOException $e) {
      Logger::log("Error en el metode getUsuariPerAliesOEmail de UsuariDAO: " . $e->getMessage(), TipusLog::DATABASE_ERROR, LogLevel::ERROR);
      return null;
    }
  }

  // Obté un usuari de la base de dades pel seu token de recuperació.
  public function getUsuariPerToken(string $token): ?Usuari {
    try {
      $sentencia = $this->pdo->prepare("SELECT * FROM usuaris WHERE token_recuperacio = :token");
  
      // Executa la consulta.
      $sentencia->execute(['token' => $token]);
  
      if ($sentencia->rowCount() === 0) {
        return null;
      }
  
      // Obté el resultat de la consulta.
      $resultat = $sentencia->fetch();
      
      Logger::log("Usuari obtingut correctament al metode getUsuariPerToken de UsuariDAO", TipusLog::DATABASE_LOG, LogLevel::INFO);
  
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
    } catch (PDOException $e) {
      Logger::log("Error en el metode getUsuariPerToken de UsuariDAO: " . $e->getMessage(), TipusLog::DATABASE_ERROR, LogLevel::ERROR);
      return null;
    }
  }

  // Modifica les dades d'un usuari existent a la base de dades.
  public function modificar(Usuari $usuari): bool {
    try {
      $sentenciaModificar = $this->pdo->prepare("UPDATE usuaris SET alies = :alies, email = :email, password = :password, nom_complet = :nom_complet, token_recuperacio = :token_recuperacio, expiracio_token = :expiracio_token, ruta_imatge = :ruta_imatge, es_admin = :es_admin WHERE id = :id");
  
      // Executa la sentència d'actualització amb les dades de l'usuari i retorna el resultat.
      $resultat = $sentenciaModificar->execute([
        'alies' => $usuari->getAlies(),
        'email' => $usuari->getEmail(),
        'password' => $usuari->getPassword(),
        'nom_complet' => ($usuari->getNomComplet()) ?? null,
        'id' => $usuari->getId(),
        'token_recuperacio' => $usuari->getTokenRecuperacio(),
        'expiracio_token' => ($usuari->getExpiracioToken()) ? $usuari->getExpiracioToken()->format('Y-m-d H:i:s') : null,
        'ruta_imatge' => $usuari->getRutaImatge(),
        'es_admin' => $usuari->esAdmin()
      ]);
      
      Logger::log("Usuari modificat correctament al metode modificar de UsuariDAO", TipusLog::DATABASE_LOG, LogLevel::INFO);

      return $resultat;
    } catch (PDOException $e) {
      Logger::log("Error en el metode modificar de UsuariDAO: " . $e->getMessage(), TipusLog::DATABASE_ERROR, LogLevel::ERROR);
      return false;
    }
  }

  // Elimina un usuari de la base de dades pel seu ID.
  public function eliminar($id) {
    try {
      $sentenciaEliminar = $this->pdo->prepare("DELETE FROM usuaris WHERE id = :id");
  
      // Executa la sentència d'eliminació i retorna el resultat.
      $resultat = $sentenciaEliminar->execute(['id' => $id]);

      Logger::log("Usuari eliminat correctament al metode eliminar de UsuariDAO", TipusLog::DATABASE_LOG, LogLevel::INFO);
      
      return $resultat;
    } catch (PDOException $e) {
      Logger::log("Error en el metode eliminar de UsuariDAO: " . $e->getMessage(), TipusLog::DATABASE_ERROR, LogLevel::ERROR);
      return false;
    }
  }
}
