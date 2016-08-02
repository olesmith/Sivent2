<?php

trait MyMod_Data_Groups_Info
{
    //*
    //* function MyMod_Data_Groups_Info_Data, Parameter list: 
    //*
    //* Handles module object sys info.
    //*

    function MyMod_Data_Groups_Info_Keys()
    {
        return
            array_merge
            (
               array("Name","Data",),
               array_keys($this->Profiles())
            );
    }
    
   //*
    //* function MyMod_Data_Groups_Info, Parameter list: $singular=FALSE
    //*
    //* Handles module object sys info.
    //*

    function MyMod_Data_Groups_Info($singular=FALSE)
    {
        $title="Module Data Groups Info";
        if ($singular)
        {
            $title="Module Data SGroups Info";
        }
        
        return
            $this->H(2,$title).
            $this->Html_Table
            (
               $this->MyMod_Data_Groups_Info_Titles(),
               $this->MyMod_Data_Groups_Table($singular)
            ).
            "";
    }

    //*
    //* function MyMod_Data_Groups_Table, Parameter list: $singular=FALSE
    //*
    //* Handles module object sys info.
    //*

    function MyMod_Data_Groups_Table($singular=FALSE)
    {
        $table=array();

        if ($singular)
        {
            foreach (array_keys($this->ItemDataSGroups) as $group)
            {
                $row=array($this->B($group).":");
                foreach ($this->MyMod_Data_Groups_Info_Keys() as $key)
                {
                    $cell="-";
                    if (!empty($this->ItemDataSGroups[ $group ][ $key ]))
                    {
                        $cell=$this->ItemDataSGroups[$group ][ $key ];
                    }
                    elseif (isset($this->ItemDataSGroups[ $group ][ $key ]))
                    {
                        $cell=$this->ItemDataSGroups[ $group ][ $key ];
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
            
        }
        else
        {
            foreach (array_keys($this->ItemDataGroups) as $group)
            {
                $row=array($this->B($group).":");
                foreach ($this->MyMod_Data_Groups_Info_Keys() as $key)
                {
                    $cell="-";
                    if (!empty($this->ItemDataGroups[ $group ][ $key ]))
                    {
                        $cell=$this->ItemDataGroups[$group ][ $key ];
                    }
                    elseif (isset($this->ItemDataGroups[ $group ][ $key ]))
                    {
                        $cell=$this->ItemDataGroups[ $group ][ $key ];
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
            
        }
            
        return $table;
    }

    //*
    //* function MyMod_Data_Groups_Info_Titles, Parameter list: 
    //*
    //* Handles module object sys info.
    //*

    function MyMod_Data_Groups_Info_Titles()
    {
        return
            array_merge
            (
               array(""),
               $this->MyMod_Data_Groups_Info_Keys()
            );

        return $titles;
    }
    
}

?>