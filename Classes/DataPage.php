<?php
class DataPage
{
    public function __construct(Template $template)
    {
        $pagesData = Model::GetPage();
        $parents = "";
        $pages = "";
        foreach ($pagesData as $page)
        {
            if(!isset($page["parent"]))
            {
                $parents.="<option value=\"{$page['id']}\">{$page['title']}</option>";
            }
            $pages.="<option value=\"{$page['id']}\">{$page['title']}</option>";
        }
        $template->InsertToFlag("PARENTS", $parents);
        $template->InsertToFlag("PAGES", $pages);
        if(isset($_POST["newpage"]))
        {
            try
            {
                if(isset($_POST["url"]) && isset($_POST["title"]) && isset($_POST["template"]))
                {
                Model::InsertPage(array("url" => $_POST["url"], "title" => $_POST["title"], "parent" => isset($_POST["parent"])?$_POST["parent"]:null,"template" => $_POST["template"]));
                }
                else
                {
                    $template->InsertToFlag("RESULT", "Az oldal felviteléhez hiányosak az információk!");
                }
            }
            catch (Exception $ex)
            {
                $template->InsertToFlag("RESULT", "Kritikus hiba!");
            }
        }
        elseif(isset($_POST["newdata"]))
        {
            try
            {
                if(isset($_POST["key"]) && isset($_POST["data"]) && isset($_POST["page"]))
                {
                    Model::InsertData(array("key" => $_POST["key"], "value" => $_POST["data"], "pageid" => $_POST["page"]));
                }
                else
                {
                    $template->InsertToFlag("RESULT", "Az adat felviteléhez hiányosak az információk!");
                }
            }
            catch (Exception $ex)
            {
                $template->InsertToFlag("RESULT", "Kritikus hiba!");
            }
        }
        elseif(isset($_POST["newpass"]))
        {
            try
            {
                if(isset($_POST["user"]) && isset($_POST["pass"]))
                {
                    Model::UpdateLogin($_POST["user"], $_POST["pass"]);
                }
                else
                {
                    $template->InsertToFlag("RESULT", "A belépés módosításához hiányosak az információk!");
                }
            }
            catch (Exception $ex)
            {
                $template->InsertToFlag("RESULT", "Kritikus hiba!");
            }
        }
    }
}
