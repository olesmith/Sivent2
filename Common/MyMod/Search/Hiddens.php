<?php


trait MyMod_Search_Hiddens
{
    //*
    //* function MyMod_Search_Hiddens_Fields, Parameter list: 
    //*
    //* Creates hiddens according to search vars defined.
    //*

    function MyMod_Search_Hiddens_Fields()
    {
        $hiddens=array();
        foreach ($this->MyMod_Items_Search_Vars() as $data)
        {
            if ($this->MyMod_Data_Access($data)>=1)
            {
                $rdata=$this->MyMod_Search_CGI_Name($data);
                $value=$this->MyMod_Search_CGI_Value($data);

                if ($value!="" && !is_array($value) && !preg_match('/^0$/',$value))
                {
                    array_push($hiddens,$this->MakeHidden($rdata,$value));
                }
            }
        }

        array_push
        (
           $hiddens,
           $this->MyMod_Search_CGI_Include_All_Hidden_Field()
        );
        

        return $hiddens;
    }
 }

?>