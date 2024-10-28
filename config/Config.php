<?php
// Santi Onieva

// Es defineix la constant BASE_PATH per obtenir la ruta base del projecte,
// eliminant les parts '/view', '/auth' i '/api' de la ruta del directori actual.
define('BASE_PATH', rtrim(str_replace(['/view', '/auth', '/api', '/controller'], '', dirname($_SERVER['SCRIPT_NAME'])), '/'));

// Es crea la classe Config per gestionar la configuració de la pàgina.
class Config {
  // Es defineix una propietat estàtica per emmagatzemar el títol de la pàgina.
  private static $titolPagina = '';

  // Mètode estàtic per establir el títol de la pàgina.
  public static function setTitol(string $titol): void {
    self::$titolPagina = $titol;
  }

  // Mètode estàtic per obtenir el títol de la pàgina.
  public static function getTitol(): string {
    return self::$titolPagina;
  }
}
?>
