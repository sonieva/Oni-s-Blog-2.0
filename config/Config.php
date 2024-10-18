<? 
// Santi Onieva

define('BASE_PATH', rtrim(str_replace(['/view', '/auth'], '', dirname($_SERVER['SCRIPT_NAME'])), '/'));

class Config {
  private static $titolPagina = '';

  public static function setTitol(string $titol): void {
    self::$titolPagina = $titol;
  }

  public static function getTitol(): string {
    return self::$titolPagina;
  }
}
?>