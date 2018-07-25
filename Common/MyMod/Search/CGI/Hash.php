<?php


trait MyMod_Search_CGI_Hash
{
    //*
    //* function MyMod_Search_CGI_2_Hash, Parameter list: $hash=array()
    //*
    //* Creates hash according to search vars defined.
    //*

    function MyMod_Search_CGI_Hash_Get($hash=array())
    {
        foreach ($this->MyMod_Search_Vars() as $data)
        {
            if ($this->MyMod_Data_Access($data)>=1)
            {
                $rdata=$this->MyMod_Search_CGI_Name($data);
                $value=$this->MyMod_Search_CGI_Value($data);
                if (is_array($value) && count($value)>0) { $value=$value[0]; }

                $value=preg_replace('/^\s+/',"",$value);
                $value=preg_replace('/\s+$/',"",$value);
                
                if (!empty($value) && !is_array($value) && !preg_match('/^0$/',$value))
                {
                    //Handle spaces in search strings
                    if (preg_match('/ /',$value))
                    {
                        $value=preg_replace('/ /',"_",$value);
                    }

                    $hash[ $rdata ]=$value;
                }
            }
        }

        return $hash;
    }
}

?>