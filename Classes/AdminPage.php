<?php
class AdminPage
{
    public function __construct()
    {
        global $cfg;
        if(isset($_GET[$cfg["page_key"]]) && $_GET[$cfg["page_key"]] != "adminlogin")
        {
            if(!isset($_SESSION["login"]) || $_SESSION["login"] != true)
            {
                header("Location: index.php?{$cfg["page_key"]}=adminlogin");
            }
        }
    }
}
