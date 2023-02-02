<?php
class LoginPage
{
    public function __construct(Template $template)
    {
        global $cfg;
        if(isset($_POST["login"]))
        {
            if(isset($_POST["user"]) && isset($_POST["pass"]))
            {
                if(Model::Login($_POST["user"], $_POST["pass"]))
                {
                    $_SESSION["login"] = true;
                    header("Location: index.php?{$cfg["page_key"]}=admindata");
                }
                else
                {
                    $template->InsertToFlag("ERROR", "Hibás felhasználónév / jelszó!");
                }
            }
            else
            {
                $template->InsertToFlag("ERROR", "A felhasználónév és a jelszó megadása is kötelező!");
            }
        }
    }
}
