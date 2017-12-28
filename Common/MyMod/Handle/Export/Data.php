<?php

trait MyMod_Handle_Export_Data
{
    //*
    //* Returns $data, $subdata title.
    //*

    function MyMod_Handle_Export_Data_Title($data,$subdata="")
    {
        $name=$this->MyMod_Data_Title($data);
        if (!empty($subdata))
        {
            $name.=
                " - ".
                $this->MyMod_Data_Fields_Module_2Object($data)->MyMod_Data_Title($subdata);
        }

        return $name;
    }
            
    //*
    //* Returns subitem data title
    //*

    function MyMod_Handle_Export_Data_Titles($datas)
    {
        $titles=array();
        foreach ($datas as $data)
        {
            $title="";
            if ($data=="No")
            {
                $title="Nº";
            }
            elseif (!empty($this->ItemData[ $data ]))
            {
                $title=$this->MyMod_Data_Title($data);
            }
            elseif (preg_match('/(\S+)__(\S+)/',$data,$matches))
            {
                $rdata=$matches[1];
                $subdata=$matches[2];
                $title=$this->MyMod_Handle_Export_Data_Title($rdata,$subdata);
            }
            
            array_push($titles,$title);
        }

        return $titles;
    }
    
    var $Datas=array();
    var $Data_Names=array();
    
    //*
    //* Gathers the actual table of exported date, and
    //* returns the matrix.
    //*

    function MyMod_Handle_Export_Table_Data_Gather()
    {
        $datas=array();
        $names=array();
        foreach (array_keys($this->ItemData) as $data)
        {
            //$name=$this->ItemData[ $data ][ "Name" ];
            //if ($name=="") { $name=$data; }

            $name=$this->MyMod_Handle_Export_Data_Title($data);
            
            $names[ $name ]=$data;
            
            array_push($datas,$data);
           
            if ($this->MyMod_Data_Field_Is_Sql($data))
            {
                $module=$this->MyMod_Data_Fields_Module_2Object($data);
                $module->ItemData("ID");

                foreach ($this->MyMod_Data_Fields_Module_Datas($data) as $id => $rdata)
                {
                    $rrdata=$data."__".$rdata;
                    
                    $rrname=$this->MyMod_Handle_Export_Data_Title($data,$rdata);
                   
                    $names[ $rrname ]=$rrdata;
                    array_push($datas,$rrdata);
               }
            }
        }

        $rnames=array_keys($names);
        sort($rnames);

        $this->Datas=array("","No");
        $this->Data_Names=array("","No");
        
        foreach ($rnames as $name)
        {
            array_push($this->Data_Names,$name);
            array_push($this->Datas,$names[ $name ]);
        }        
    }
    
}
?>