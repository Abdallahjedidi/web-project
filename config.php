<?php
class Config
{
    private static $pdo = null;
    public static function getConnection()
    {
        if (!isset(self::$pdo))
        {
            $servername = 'localhost';
            $username = 'root';
            $dbname = 'gestione_user';
            try 
            {
                self::$pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, getenv('DB_PASSWORD'));
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } 
            catch (PDOException $e) 
            {
                echo "<p style='color: red;'>Erreur de connexion : " . $e->getMessage() . "</p>";
                die(); // ou return null;
            }
        }
        return self::$pdo;
    }
}
Config::getConnection();
?>
