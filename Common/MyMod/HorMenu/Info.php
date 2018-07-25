<?php

trait MyMod_HorMenu_Info
{
    //*
    //* function MyMod_HorMenu_Info_Data, Parameter list: 
    //*
    //* Handles module object sys info.
    //*

    function MyMod_HorMenu_Info_Keys()
    {
        return
            array_merge
            (
               array_keys($this->Profiles())
            );
    }
    
   //*
    //* function MyMod_HorMenu_Info, Parameter list: 
    //*
    //* Handles module object sys info.
    //*

    function MyMod_HorMenu_Info()
    {
        return
            $this->H(2,"Module Horisontal Menues Info").
            $this->Html_Table
            (
               $this->MyMod_HorMenu_Info_Titles(),
               $this->MyMod_HorMenu_Table()
            ).
            "";
    }
        
    //*
    //* function MyMod_HorMenu_Table, Parameter list: 
    //*
    //* Generates horisontal menues as table matrix of links.
    //*

    function MyMod_HorMenu_Table()
    {
        $table=array();
        $hash=$this->ReadPHPArray( $this->MyMod_Setup_Profiles_File() );
        
        foreach ($hash[ "Menues" ] as $menu => $rhash)
        {
            $row=array($this->B($menu).":");
            foreach (array_keys($this->Profiles()) as $key)
            {
                $cell="-";
                if (!empty($rhash[ $key ]))
                {
                    $actions=$rhash[ $key ];
                    $cell=array();
                    foreach ($actions as $key => $value)
                    {
                        if ($value>0)
                        {
                            array_push($cell,$key);
                        }
                    }

                    $cell=join(", ",$cell);
                }

                array_push($row,$cell);
            }
            
            array_push($table,$row);

        }

        return $table;
    }

    //*
    //* function MyMod_HorMenu_Info_Titles, Parameter list: 
    //*
    //* Handles module object sys info.
    //*

    function MyMod_HorMenu_Info_Titles()
    {
        $titles=$this->MyMod_HorMenu_Info_Keys();
        array_unshift($titles,"");
        return
            array_merge
            (
               array(""),
               $this->MyMod_HorMenu_Info_Keys()
            );

        return $titles;
    }
    
}

?>