<?php

trait MyMod_Handle_Export_Read
{
    //*
    //* Gathers the actual table of exported date, and
    //* returns the matrix.
    //*

    function MyMod_Handle_Export_Read()
    {
        $this->IncludeAll=1;
        
        $nosearches=FALSE;
        $nopaging=TRUE;
        $includeall=1;
        $rrdatas=array_keys($this->ItemData);
 
        $rdatas=array_keys($this->ItemData);
        $this->MyMod_Items_Read("",$rdatas,$nosearches,$nopaging,$includeall);
        
        if (!$this-> MyMod_Handle_Export_CGI_No_Enums())
        {
            foreach (array_keys($this->ItemHashes) as $id)
            {
                $this->ItemHashes[ $id ]=
                    $this->MyMod_Data_Fields_Enums_ApplyAll
                    (
                        $this->ItemHashes[ $id ],
                        FALSE,
                        array_keys($this->ItemHashes[ $id ])
                    );
            }
        }
    }
}
?>