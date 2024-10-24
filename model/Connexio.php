<?php
// Santi Onieva

class Connexio {
  // Propietat estàtica per a emmagatzemar la instància única de la classe.
  private static $instance = null;
  // Propietat per a emmagatzemar l'objecte PDO.
  private $pdo;

  // Dades de configuració per a la connexió a la base de dades.
  private $host = 'db';
  private $dbName = 'Pt04_Santi_Onieva';
  private $user = 'root';
  private $password = 'p@ssw0rd';

  // Constructor privat per evitar la creació d'instàncies directament.
  private function __construct() {
    try {
      // Es crea una nova connexió PDO amb les credencials de la base de dades.
      $this->pdo = new PDO("mysql:host=$this->host;dbname=$this->dbName", $this->user, $this->password);
      // S'estableix l'atribut per llançar excepcions en cas d'errors de connexió.
      $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
      // En cas d'error, es mostra un missatge i es deté l'execució.
      die("Error al conectar a la base de dades: " . $e->getMessage());
    }
  }

  // Mètode estàtic per obtenir la instància única de la connexió.
  public static function getInstance(): Connexio {
    // Si no existeix una instància, es crea.
    if (!self::$instance) {
      self::$instance = new Connexio();
    }

    // Es retorna la instància de la connexió.
    return self::$instance;
  }

  // Mètode per obtenir l'objecte PDO que permet la connexió a la base de dades.
  public function getConnection(): PDO {
    return $this->pdo;
  }
}
