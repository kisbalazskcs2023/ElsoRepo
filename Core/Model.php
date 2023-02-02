<?php
abstract class Model
{
    private static mysqli $con;
    
    public static function Connect() : void
    {
        global $cfg;
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        try
        {
            self::$con = new mysqli($cfg["mysql_server"], $cfg["mysql_user"], $cfg["mysql_pass"], $cfg["mysql_db"], $cfg["mysql_port"]);
        }
        catch (mysqli_sql_exception $ex)
        {
            throw new SQLException("Sikertelen csatlakozás az adatbázishoz!", $ex);
        }
    }
    
    public static function Disconnect()
    {
        try
        {
            self::$con->close();
        }
        catch (mysqli_sql_exception $ex)
        {
            throw new SQLException("Sikertelen kapcsolatbontás!", $ex);
        }
    }
    
    public static function InsertPage(array $page) : void
    {
        try
        {
            $sql = "INSERT INTO `page`(`url`, `title`, `parent`, `template`) VALUES ('§url§', '§title§', §parent§, '§template§')";
            foreach($page as $key => $data)
            {
                if($data == null)
                {
                    $data = 'NULL';
                }
                $sql = str_replace("§".$key."§", self::$con->real_escape_string($data), $sql);
            }
            self::$con->query($sql);
        } 
        catch (mysqli_sql_exception $ex)
        {
            throw new SQLException("Sikertelen oldal felvitel!", $ex);
        }
    }
    
    public static function InsertData(array $pageData) : void
    {
        try
        {
            $sql = "INSERT INTO `data` VALUES ('§key§', '§value§', §pageid§)";
            foreach($pageData as $key => $data)
            {
                if($data == null)
                {
                    $data = 'NULL';
                }
                $sql = str_replace("§".$key."§", self::$con->real_escape_string($data), $sql);
            }
            self::$con->query($sql);
        } 
        catch (mysqli_sql_exception $ex)
        {
            throw new SQLException("Sikertelen oldal felvitel!", $ex);
        }
    }
    
    public static function UpdateLogin(string $user, string $pass) : void
    {
        try
        {
            $sql = "UPDATE `login` SET `user` = '".self::$con->real_escape_string($user)."', `password` = '".hash("sha256", self::$con->real_escape_string($pass))."' WHERE `id` = 1";
            self::$con->query($sql);
        }
        catch (mysqli_sql_exception $ex)
        {
            throw new SQLException("Sikertelen felhasználónév / jelszó változtatás!", $ex);
        }
    }
    
    public static function Login(string $user, string $pass) : bool
    {
        try
        {
            $sql = "SELECT id FROM `login` WHERE `user` = '".self::$con->real_escape_string($user)."' AND `password` = '".hash("sha256", self::$con->real_escape_string($pass))."'";
            //print($sql);
            $result = self::$con->query($sql);
            return $result->num_rows > 0;
        }
        catch (mysqli_sql_exception $ex)
        {
            throw new SQLException("Sikertelen felhasználónév / jelszó lekérdezés!", $ex);
        }
    }
    
    public static function GetPage(string $url = null) : array
    {
        try
        {
            $sql = "SELECT * FROM `page` ".(($url != null)?"WHERE `url` = '".self::$con->real_escape_string($url)."'":"");
            $result = self::$con->query($sql);
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        catch (mysqli_sql_exception $ex)
        {
            throw new SQLException("Sikertelen oldal lekérdezés!", $ex);
        }
    }
    
    public static function GetPageById(int $id) : array
    {
        try
        {
            $sql = "SELECT * FROM `page` WHERE `id` = ".$id;
            $result = self::$con->query($sql);
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        catch (mysqli_sql_exception $ex)
        {
            throw new SQLException("Sikertelen oldal lekérdezés!", $ex);
        }
    }


    public static function GetData(string $key = null, string $pageid = null) : array
    {
        if($key == null && $pageid == null)
        {
            throw new Exception("Az adatok lekérdezéséhez szűrés szükséges!");
        }
        try
        {
            $sql = "SELECT * FROM `data` ";
            if($key != null)
            {
                $sql.="WHERE `key` = '".self::$con->real_escape_string($key)."' ";
            }
            if($pageid != null)
            {
                 $sql.=(($key==null) ? "WHERE" : "AND")." `pageid` = ".self::$con->real_escape_string($pageid);
            }
            $result = self::$con->query($sql);
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        catch (mysqli_sql_exception $ex)
        {
            throw new SQLException("Sikertelen adat lekérdezés!", $ex);
        }
    }
    
    //...
}
