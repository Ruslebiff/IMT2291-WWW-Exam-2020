<?php
/**
 * Contains getDBConnection to get the connection to the database.
 * Change the host, username and pwd here, this is the only place the connection
 * details should exist.
 */
class DB {
  private static $db=null;
  private $dsn = 'mysql:dbname=myDb;host=db';
  private $user = 'user';
  private $password = 'test';
  private $dbh = null;

  /**
   * Private constructor, prevents anyone else from making objects of this class.
   */
  private function __construct() {
    try {
        $this->dbh = new PDO($this->dsn, $this->user, $this->password);
    } catch (PDOException $e) {
        // NOTE IKKE BRUK DETTE I PRODUKSJON
        echo 'Connection failed: ' . $e->getMessage();
    }
  }

  /**
   * If not connected, connects to the database and returns the database handler,
   * if already connected, returns the existing database handler.
   * 
   * @return [Object] database handler
   */
  public static function getDBConnection() {
      if (DB::$db==null) {
        DB::$db = new self();
      }
      return DB::$db->dbh;
  }
}
