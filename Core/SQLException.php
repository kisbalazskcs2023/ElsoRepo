<?php
class SQLException extends Exception
{
    public function __construct(string $message, Exception $original)
    {
        parent::__construct($message, 1000, $original);
    }
}
