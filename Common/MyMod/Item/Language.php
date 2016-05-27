<?php


trait MyMod_Item_Language
{
    //*
    //* Detetects first languaged key of $data, that is unset in $item.
    //* And overrides all empty languaged keys, with this value.
    //*

    function MyMod_Item_Language_Data_Defaults($item,$data)
    {
        $firstvalue="";
        foreach ($this->LanguageKeys() as $lkey)
        {
            $rdata=$data.$lkey;
            if (!empty($item[ $rdata ]))
            {
                $firstvalue=$item[ $rdata ];
                break;
            }
        }

        $updatedatas=array();
        if (!empty($firstvalue))
        {
            foreach ($this->LanguageKeys() as $lkey)
            {
                $rdata=$data.$lkey;
                if (empty($item[ $rdata ]))
                {
                    $item[ $rdata ]=$firstvalue;
                    array_push($updatedatas,$rdata);
                }
            }
        }
        
        return $updatedatas;
    }

    

}

?>