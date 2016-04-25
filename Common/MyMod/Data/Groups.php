<?php


include_once("Groups/Defaults.php");
include_once("Groups/Time.php");
include_once("Groups/Files.php");
include_once("Groups/Add.php");

trait MyMod_Data_Groups
{
    use 
        MyMod_Data_Groups_Defaults, 
        MyMod_Data_Groups_Time, 
        MyMod_Data_Groups_Files, 
        MyMod_Data_Groups_Add
        ;


    //*
    //* Initialize DataGroups
    //*

    function MyMod_Data_Groups_Initialize()
    {
        if ($this->DataGroupsRead) { return; }

        $sing=FALSE;
        if (
              $this->Singular
              ||
              (
                 $this->ModuleName==$this->GetGET("ModuleName")
                 &&
                 $this->GetGETOrPOST("ID")>0
              )
           )
        {
            $this->Singular=TRUE;
            $this->Plural=FALSE;
            $sing=TRUE;
        }
        else
        {
            $this->Singular=FALSE;
            $this->Plural=TRUE;
        }

        if (method_exists($this,"PreProcessItemDataGroups"))
        {
            $this->PreProcessItemDataGroups();
        }
        
        $this->MyMod_Data_Groups_Init(TRUE);
        $this->MyMod_Data_Groups_Init(FALSE);
 
        if (method_exists($this,"PostProcessItemDataGroups"))
        {
            $this->PostProcessItemDataGroups();
        }

        
        $this->MyMod_Groups_Time_AddGroups();

        $this->DataGroupsRead=TRUE;

   }

    //*
    //* Initialize Data Plural Groups
    //*

    function MyMod_Data_Groups_AccName($singular=FALSE)
    {
        $accgroups="ItemDataGroups";
        if ($singular)
        {
            $accgroups="ItemDataSGroups";
        }

        return $accgroups;
    }

    //*
    //* Initialize Data Plural Groups
    //*

    function MyMod_Data_Groups_Init($singular=FALSE)
    {
        $accgroups=$this->MyMod_Data_Groups_AccName($singular);

        $this->MyMod_Data_Groups_Files_Add_Files
        (
           $singular,
           $this->MyMod_Data_Groups_Files_GetFiles($singular)
        );

        $this->MyLanguage_HashTakeNameKeys($this->$accgroups);
   }
}

?>