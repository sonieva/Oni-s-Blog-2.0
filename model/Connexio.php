<?php
// Santi Onieva
require __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../utils/Logger.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

class Connexio {
  // Propietat estàtica per a emmagatzemar la instància única de la classe.
  private static $instance = null;
  // Propietat per a emmagatzemar l'objecte PDO.
  private $pdo; 

  // Dades de configuració per a la connexió a la base de dades.
  private $host;
  private $dbName;
  private $user;
  private $password;

  // Constructor privat per evitar la creació d'instàncies directament.
  private function __construct() {
    $this->host = $_ENV['DB_HOST'];
    $this->dbName = $_ENV['DB_NAME'];
    $this->user = $_ENV['DB_USER'];
    $this->password = $_ENV['DB_PASSWORD'];

    $this->connectWithRetry();
  }

  private function connectWithRetry() {
    $intents = 3; // Nombre màxim d'intents
    $interval = 2; // Segons entre cada intent

    for ($i = 0; $i < $intents; $i++) {
      try {
        // Es crea una nova connexió PDO amb les credencials de la base de dades.
        $this->pdo = new PDO("mysql:host=$this->host;dbname=$this->dbName;charset=utf8mb4", $this->user, $this->password);
        // S'estableix l'atribut per llançar excepcions en cas d'errors de connexió.
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Registre d'èxit
        Logger::log("Connexió a la base de dades creada correctament", TipusLog::DATABASE_LOG, LogLevel::INFO);
        return; // Si la connexió és correcta, surt del bucle
      } catch (PDOException $e) {
        Logger::log("Error al conectar a la base de dades, intent #" . ($i + 1) . ": " . $e->getMessage(), TipusLog::DATABASE_ERROR, LogLevel::ERROR);

        // Si és l'últim intent, es llança l'error
        if ($i === $intents - 1) {
          die("Error al conectar a la base de dades després de $intents intents: " . $e->getMessage());
        }

        // Espera abans de tornar a intentar la connexió
        sleep($interval);
      }
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
