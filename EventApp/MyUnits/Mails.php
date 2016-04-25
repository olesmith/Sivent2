<?php


class MyUnitsMails extends MyUnitsAccess
{
    //*
    //* function AddMails2ItemData, Parameter list: $file
    //*
    //* Reads and adds emails data.
    //*

    function AddMails2ItemData($file)
    {
        $this->MailDatas=$this->MyLanguage_ItemData_Get($file);

        foreach ($this->MailDatas as $lang => $maildata)
        {
            $this->ItemData=array_merge($this->ItemData,$maildata);
        }
    }

    //*
    //* function AddMails2ItemGroups, Parameter list:
    //*
    //* Adds mails defs to groups and sgroups.
    //*

    function AddMails2ItemGroups($gfile,$sgfile)
    {
        $this->ItemDataGroups=
            array_merge
            (
               $this->ItemDataGroups,
               $this->MyLanguage_ItemData_Groups_Get($this->MailDatas,$gfile)
            );
        
        $this->ItemDataSGroups=
            array_merge
            (
               $this->ItemDataSGroups,
               $this->MyLanguage_ItemData_Groups_Get($this->MailDatas,$sgfile)
            );
    }
}

?>