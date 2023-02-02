<?php
class Template
{
    private string $html;
    private array $flags;
    
    public function __construct(string $path)
    {
        $this->flags = array();
        $this->html = file_get_contents("template/".$path);
        $flags = array();
        preg_match_all("/%[A-Z0-9_]+%/", $this->html, $flags);
        foreach($flags[0] as $flag)
        {
            //print_r($flag);
            $this->flags[$flag] = "";
        }
    }
    
    public function InsertToFlag(string $flag, string $value) : bool
    {
        if(array_key_exists("%". strtoupper($flag)."%", $this->flags))
        {
            $this->flags["%". strtoupper($flag)."%"] .= $value;
            return true;
        }
        return false;
    }
    
    public function Render() : string
    {
        $result = $this->html;
        foreach($this->flags as $flag => $value)
        {
            $result = str_replace($flag, $value, $result);
        }
        return $result;
    }
}
