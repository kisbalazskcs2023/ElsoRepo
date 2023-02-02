<?php
class View
{
    private Template $index;
    
    public function getIndex(): Template
    {
        return $this->index;
    }
    
    public function __construct(string $mainTemplate = null)
    {
        if($mainTemplate != null)
        {
            $this->index = new Template($mainTemplate);
        }
    }
    
    public function FullRender() : string
    {
        return $this->index->Render();
    }
    
    public static function Create(Template $template) : View
    {
        $view = new View();
        $view->index = $template;
        return $view;
    }
}
