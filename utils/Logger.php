<?php
// Santi Onieva

enum TipusLog: int {
  case GENERAL_LOG = 1;
  case ERROR_LOG = 2;
  case DATABASE_LOG = 3;
  case DATABASE_ERROR = 4;
}

enum LogLevel: int {
  case INFO = 1;
  case WARNING = 2;
  case ERROR = 3;
}

class Logger {
  private static $logFile = __DIR__ . '/../logs/log.log';
  private static $errorFile = __DIR__ . '/../logs/error.log';

  private static $databaseLog = __DIR__ . '/../logs/database.log';
  private static $databaseError = __DIR__ . '/../logs/database-error.log';

  public static function log($message, TipusLog $tipusLog = TipusLog::GENERAL_LOG, LogLevel $logLevel = LogLevel::INFO) {
    $logFile = match ($tipusLog) {
      TipusLog::GENERAL_LOG => self::$logFile,
      TipusLog::ERROR_LOG => self::$errorFile,
      TipusLog::DATABASE_LOG => self::$databaseLog,
      TipusLog::DATABASE_ERROR => self::$databaseError,
    };

    if (!file_exists($logFile)) {
      touch($logFile);
    }

    $level = match ($logLevel) {
      LogLevel::INFO => 'INFO',
      LogLevel::WARNING => 'WARNING',
      LogLevel::ERROR => 'ERROR',
    };

    $logMessage = '[' . date('Y-m-d H:i:s') . ']:' . $level . ' CALLER: ' . debug_backtrace()[1]['function'] . ' - ' . $message . PHP_EOL;

    file_put_contents($logFile, $logMessage, FILE_APPEND);
  }
}