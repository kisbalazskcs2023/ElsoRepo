<?php
class IndexPage
{
    public function __construct(Template $template)
    {
        global $cfg;
        if(!isset($_GET[$cfg["page_key"]]))
        {
            $template->InsertToFlag($cfg["child_flag"], "Helló világ!");
        }
    }
}
