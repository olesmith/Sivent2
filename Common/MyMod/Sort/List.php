<?php


trait MyMod_Sort_List
{
    function MyMod_Sort_List($list,$sorts=array(),$reverse=FALSE)
    {
        if (empty($sorts))
        {
            $sorts=$this->Sort;
        }

        if (!is_array($sorts) || empty($sorts))
        {
            $sorts=preg_split('/\s*,\s*/',$sorts);
        }

        array_push($sorts,"ID"); //ID make sort fields alqways unique!

        return $this->Sort_List($list,$sorts,$reverse);
    }
}

?>