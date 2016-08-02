<?php

trait MyActions_Info
{
    //*
    //* function MyMod_Actions_Info_Data, Parameter list: 
    //*
    //* Handles module object sys info.
    //*

    function MyMod_Actions_Info_Keys()
    {
        return
            array_merge
            (
               array("Name","File","HrefArgs","Icon","Singular","AccessMethod",),
               array_keys($this->Profiles())
            );
    }
    
   //*
    //* function MyMod_Actions_Info, Parameter list: 
    //*
    //* Handles module object sys info.
    //*

    function MyMod_Actions_Info()
    {
        return
            $this->H(2,"Module Actions Info").
            $this->Html_Table
            (
               $this->MyMod_Actions_Info_Titles(),
               $this->MyMod_Actions_Table()
            ).
            "";
    }

    //*
    //* function MyMod_Actions_Table, Parameter list: 
    //*
    //* Handles module object sys info.
    //*

    function MyMod_Actions_Table()
    {
        $table=array();
        foreach (array_keys($this->Actions()) as $data)
        {
            $row=array($this->B($data).":");
            foreach ($this->MyMod_Actions_Info_Keys() as $key)
            {
                $cell="-";
                if (!empty($this->Actions[ $data ][ $key ]))
                {
                    $cell=$this->Actions[ $data ][ $key ];
                }
                elseif (isset($this->Actions[ $data ][ $key ]))
                {
                    $cell=$this->Actions[ $data ][ $key ];
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
    //* function MyMod_Actions_Info_Titles, Parameter list: 
    //*
    //* Handles module object sys info.
    //*

    function MyMod_Actions_Info_Titles()
    {
        return
            array_merge
            (
               array("Action"),
               $this->MyMod_Actions_Info_Keys()
            );
    }
    
}

?>