<?php


include_once("Item/Form.php");
include_once("Item/Update.php");
include_once("Item/Group.php");
include_once("Item/Table.php");
include_once("Item/Row.php");
include_once("Item/Cells.php");
include_once("Item/Read.php");
include_once("Item/Data.php");
include_once("Item/Children.php");
include_once("Item/Language.php");
include_once("Item/PostProcess.php");

trait MyMod_Item
{
    use
        MyMod_Item_Form,
        MyMod_Item_Update,
        MyMod_Item_Group,
        MyMod_Item_Table,
        MyMod_Item_Row,
        MyMod_Item_Cells,
        MyMod_Item_Read,
        MyMod_Item_Data,
        MyMod_Item_Children,
        MyMod_Item_Language,
        MyMod_Item_PostProcess;
        
    //*
    //* Creates row with item titles.
    //*

    function MyMod_Item_Titles($datas)
    {
        $row=array();
        foreach ($datas as $data)
        {
            if (!is_array($data)) { $data=array($data); }
            
            $cells=array();
            foreach ($data as $rdata)
            {
                array_push
                (
                   $cells,
                   $this->MyMod_Item_Cell_Title($rdata,FALSE)
                );

                //Take only one title, the first
                break;
            }

            array_push
            (
               $row,
               join($this->BR(),$cells)
            );
        }

        return $row;
    }
    
    //*
    //* function Item_Existence_Message, Parameter list: $message,$where=array()
    //*
    //* Prints informing $message, if no item exists in sql table.
    //* Default $where=$this->UnitEventWhere().
    //*

    function Item_Existence_Message($othermodule="",$where=array())
    {
        if (!preg_match('/^(Coordinator|Admin)$/',$this->Profile())) return;
            
        if (empty($where)) $where=$this->UnitEventWhere();

        $obj=$this;
        if (empty($othermodule))
        {
            $othermodule=$this->ModuleName;
            $obj=$this;
        }

        $message="No_Items_Defined_Message";
        $message=$this->MyLanguage_GetMessage("No_Items_Defined_Message");

        $message=preg_replace('/#ItemName/',$obj->MyMod_ItemName(),$message);
        $message=preg_replace('/#ItemsName/',$obj->MyMod_ItemName("ItemsName"),$message);


        if (
              !$this->Sql_Table_Exists()
              ||
              $this->Sql_Select_NHashes($this->UnitEventWhere())==0
           )
        {
            echo
                $this->Div
                (
                   $message.
                   ": ".
                   $this->Href
                   (
                      "?".$this->CGI_Hash2URI
                      (
                         array
                         (
                            "Unit" => $this->Unit("ID"),
                            "Event" => $this->Event("ID"),
                            "ModuleName" => $othermodule,
                            "Action" => "Add",
                         )                         
                      ),
                      $this->MyLanguage_GetMessage("Add_Action_Name").
                      " ".
                      $obj->MyMod_ItemName(),
                      "","","",$noqueryargs=FALSE,$options=array(),"HorMenu"
                   ),
                   array("CLASS" => 'warning')
                ).
                $this->BR();

            return FALSE;
        }

        return TRUE;
    }
}

?>