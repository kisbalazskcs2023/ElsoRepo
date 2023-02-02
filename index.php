<?php
session_start();
require_once("config.php");
spl_autoload_register(function($type)
{
    if(strpos($type, "Page") !== false)
    {
        require_once("Classes/".$type.".php");
    }
    else
    {
        require_once("Core/".$type.".php");
    }
});
Controller::ParsePage();
print(Controller::getView()->FullRender());
