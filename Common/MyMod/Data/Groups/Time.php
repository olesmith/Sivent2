<?php


//include_once("Data/Groups.php");

trait MyMod_Data_Groups_Time
{
    //use MyMod_Data_Defaults,MyMod_Data_Groups;

    //*
    //* function MyMod_Groups_Time_AddGroups, Parameter list:
    //*
    //* Returns default time groups.
    //*

    function MyMod_Groups_Time_AddGroups()
    {
        $timevardata=array("No","Edit","Name");
        foreach ($this->ItemData as $data => $hash)
        {
            if (isset($hash[ "TimeType" ]) && $hash[ "TimeType" ]==1)
            {
                array_push($timevardata,$data);
            }
        }

        $hash=array
        (
           "Name"    => "Tempos",
           "Name_UK" => "Timestamps",
           "Data"    => $timevardata,
           "Admin"   => 1,
           "Person"  => 0,
           "Public"  => 0,
        );

        //$this->ItemDataSGroups[ "Times" ]=$hash;
        $this->ItemDataGroups[ "Times" ]=$hash;
     }

}

?>