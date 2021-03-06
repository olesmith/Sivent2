<?php



trait MyMod_Data_TimeData
{
    //*
    //* function MyMod_Data_AddTimeData, Parameter list:
    //*
    //* Adds CTime, MTime e ATime to ItemData.
    //*

    function MyMod_Data_AddTimeData()
    {
        $base=array
        (
           "NoAdd" => TRUE,
           "Sql"      => "INT",
           "TimeType" => 1,

           "Public"   => 0,
           "Person"   => 1,
           "Admin"   => 1,
        );

        foreach (
                   array
                   (
                      "CTime" => array
                      (
                         "LongName" => "Hora Criado",
                         "Name"     => "Criado",
                         "LongName_UK" => "Time Created",
                         "Name_UK"  => "Created",
                      ),
                      "MTime" => array
                      (
                         "LongName" => "Hora Modificado",
                         "Name"     => "Modificado",
                         "LongName_UK" => "Time Modified",
                         "Name_UK"  => "Modified",
                      ),
                      "ATime" => array
                      (
                         "LongName" => "Hora Acessado",
                         "Name"     => "Acessado",
                         "LongName_UK" => "Time Accessed",
                         "Name_UK"  => "Accessed",
                      ),
                   )
                   as $data => $def
                )
         {
             $this->ItemData[ $data ]=array_merge($base,$def);
             
         }
    }

}

?>