<?php


trait MyMod_Search_Hiddens
{
    //*
    //* function MyMod_Search_Hiddens_Hash, Parameter list: 
    //*
    //* Returns hash according to hidden vars defined.
    //*

    function MyMod_Search_Hiddens_Hash()
    {
        $hiddens=array();
        foreach ($this->MyMod_Search_Vars() as $data)
        {
            if ($this->MyMod_Data_Access($data)>=1)
            {
                $rdata=$this->MyMod_Search_CGI_Name($data);
                $value=$this->MyMod_Search_CGI_Value($data);

                $hiddens[ $rdata ]=$value;
            }
        }
        
        $hiddens[ $this->MyMod_Search_CGI_Include_All_Name() ]=
            $this->MyMod_Search_CGI_Include_All_Value();
        
        return $hiddens;
    }
    
    //*
    //* function MyMod_Search_Hiddens_Fields, Parameter list: 
    //*
    //* Creates hiddens according to search vars defined.
    //*

    function MyMod_Search_Hiddens_Fields()
    {
        foreach ($this->MyMod_Search_Hiddens_Hash() as $data => $value)
        {
            if ($this->MyMod_Data_Access($data)>=1)
            {
                array_push($hiddens,$this->MakeHidden($rdata,$value));
            }
        }        

        return $hiddens;
    }
 }

?>