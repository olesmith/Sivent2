<?php

trait MyMod_Data_Info
{
    //*
    //* function MyMod_Data_Info_Data, Parameter list: 
    //*
    //* Handles module object sys info.
    //*

    function MyMod_Data_Info_Keys()
    {
        return
            array_merge
            (
               array("File","Sql","SqlClass","Search","Name","Compulsory","Values","Default","AccessMethod",),
               array_keys($this->Profiles())
            );
    }
    
   //*
    //* function MyMod_Data_Info, Parameter list: 
    //*
    //* Handles module object sys info.
    //*

    function MyMod_Data_Info()
    {
        return
            $this->H(2,"Module Data Info").
            $this->Html_Table
            (
               $this->MyMod_Data_Info_Titles(),
               $this->MyMod_Data_Table()
            ).
            "";
    }

    //*
    //* function MyMod_Data_Table, Parameter list: 
    //*
    //* Handles module object sys info.
    //*

    function MyMod_Data_Table()
    {
        $table=array();
        foreach (array_keys($this->ItemData()) as $data)
        {
            $row=array($this->B($data).":");
            foreach ($this->MyMod_Data_Info_Keys() as $key)
            {
                $cell="-";
                if (!empty($this->ItemData[ $data ][ $key ]))
                {
                    $cell=$this->ItemData[ $data][ $key ];
                }
                elseif (isset($this->ItemData[ $data ][ $key ]))
                {
                    $cell=$this->ItemData[ $data ][ $key ];
                }
                else
                {
                    $cell="undef";
                }
                
                if (is_array($cell))
                {
                    $cell=join(", ",$cell);
                }
 
                array_push($row,$cell);
            }
            
            array_push($table,$row);

        }

        return $table;
    }

    //*
    //* function MyMod_Data_Info_Titles, Parameter list: 
    //*
    //* Handles module object sys info.
    //*

    function MyMod_Data_Info_Titles()
    {
        $titles=$this->MyMod_Data_Info_Keys();
        array_unshift($titles,"");
        return
            array_merge
            (
               array(""),
               $this->MyMod_Data_Info_Keys()
            );

        return $titles;
    }
    
}

?>