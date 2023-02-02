<?php
abstract class Controller
{
    static View $view;
    
    public static function getView(): View {
        return self::$view;
    }
        
    public static function ParsePage() : void
    {
        global $cfg;
        try
        {
            Model::Connect();
            $url = array_key_exists($cfg["page_key"], $_GET)?$_GET[$cfg["page_key"]]:" ";
            $pageInfo = Model::GetPage($url);
            //print_r($pageInfo);
            if(is_array($pageInfo) && count($pageInfo) == 1)
            {
                $pageInfo = $pageInfo[0];
                $pageData = Model::GetData(null, $pageInfo["id"]);
                $pageTemplate = new Template($pageInfo["template"]);
                foreach($pageData as $row)
                {
                    $pageTemplate->InsertToFlag($row["key"], $row["value"]);
                }
                if(isset($pageInfo["class"]) && class_exists($pageInfo["class"]))
                {
                    $class = $pageInfo["class"];
                    $obj = new $class($pageTemplate);
                }
                //Parent megtalálása, ha van --> parent-be az inner template elhelyezése
                if(isset($pageInfo["parent"]))
                {
                    $parentInfo = Model::GetPageById($pageInfo["parent"])[0];
                    $parentTemplate = new Template($parentInfo["template"]);
                    $parentData = Model::GetData(null, $pageInfo["parent"]);
                    foreach($parentData as $row)
                    {
                        $parentTemplate->InsertToFlag($row["key"], $row["value"]);
                    }
                    $parentTemplate->InsertToFlag($cfg["child_flag"], $pageTemplate->Render());
                    if(isset($parentInfo["class"]) && class_exists($parentInfo["class"]))
                    {
                        $class = $parentInfo["class"];
                        $obj = new $class($parentTemplate);
                    }
                    self::$view = View::Create($parentTemplate);
                }
                else
                {
                    self::$view = View::Create($pageTemplate);
                }
            }
            else
            {
                self::$view = new View("error.html");
            }
        }
        catch (Exception $ex)
        {
            //print($ex->getMessage());
            self::$view = new View("error.html");
        }
        finally
        {
            try
            {
                Model::Disconnect();
            }
            catch (Exception $ex)
            {
                self::$view = new View("error.html");
            }
        }
    }
}
