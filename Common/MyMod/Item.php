<?php


include_once("Item/Form.php");
include_once("Item/Update.php");
include_once("Item/Group.php");
include_once("Item/SGroup.php");
include_once("Item/Html.php");
include_once("Item/Table.php");
include_once("Item/Row.php");
include_once("Item/Cells.php");
include_once("Item/Read.php");
include_once("Item/Data.php");
include_once("Item/Children.php");
include_once("Item/Language.php");
include_once("Item/PostProcess.php");
include_once("Item/Latex.php");
include_once("Item/Print.php");

trait MyMod_Item
{
    use
        MyMod_Item_Form,
        MyMod_Item_Update,
        MyMod_Item_Group,
        MyMod_Item_SGroup,
        MyMod_Item_Html,
        MyMod_Item_Table,
        MyMod_Item_Row,
        MyMod_Item_Cells,
        MyMod_Item_Read,
        MyMod_Item_Data,
        MyMod_Item_Children,
        MyMod_Item_Language,
        MyMod_Item_PostProcess,
        MyMod_Item_Latex,
        MyMod_Item_Print;
        
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
        if (!empty($othermodule))
        {
            $tmp=$othermodule."Obj";
            
            $obj=$this->$tmp();
        }
        else
        {
            $othermodule=$this->ModuleName;
        }

        $message=$this->MyLanguage_GetMessage("No_Items_Defined_Message");

        $message=preg_replace('/#ItemName/',$obj->MyMod_ItemName(),$message);
        $message=preg_replace('/#ItemsName/',$obj->MyMod_ItemName("ItemsName"),$message);


        if (
              !$obj->Sql_Table_Exists()
              ||
              $obj->Sql_Select_NHashes($this->UnitEventWhere())==0
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
    
    //*
    //* function MyMod_Item_Name_Get, Parameter list: $item=array(),$datas=array()
    //*
    //* Returns item name.
    //*

    function MyMod_Item_Name_Get($item=array(),$datas=array())
    {
        if (empty($datas)) { $datas=array($this->ItemNamer); }
        
        if (!is_array($item) && preg_match('/^\d+$/',$item))
        {
            $item=$this->MyMod_Item_Read($item,$datas);
        }
        elseif (count($item)==0)
        {
            $item=$this->ItemHash;
        }

        $name="";
        if (!empty($this->ItemsNamer))
        {
            $this->ItemNamer=$this->ItemsNamer;
        }

        
        if (!empty($this->ItemNamer))
        {
            if (preg_match('/#/',$this->ItemNamer))
            {
                $name=$this->Filter($this->ItemNamer,$item);
            }
            else
            {
                if (count($item)>0)
                {
                    $namer=$this->ItemNamer;
                    if (!isset($item[ $this->ItemNamer ]))
                    {
                        $namer="Name";
                    }

                    if (!isset($item[ $namer ]))
                    {
                        if (!isset($this->ItemData[ $namer ]))
                        {
                            print "Item: ".$this->ModuleName.": Invalid Itemnamer: ".$namer."<BR>";
                            //var_dump($item);
                        }
                    }
                    else
                    {
                        if (!empty($item[ $this->ItemNamer ]))
                        {
                            $name=$item[ $this->ItemNamer ];
                        }
                        elseif (!empty($item[ "Name" ]))
                        {
                            $name=$item[ "Name" ];
                        }
                    }
                }
            }
        }

        return $name;
    }
    //*
    //* 
    //*

    function MyMod_Item_Anchor($item=array(),$anchor="",$text="")
    {
        if ($this->LatexMode) { return ""; }
        if (count($item)==0)
        {
            $item=$this->ItemHash;
        }

        if ($anchor=="" && isset($item[ "ID" ]))
        {
            $anchor=$this->ModuleName."_".$item[ "ID" ];
        }

        return $this->Span($text,array("ID" => $anchor));
    }


    /* //\* */
    /* //\*  */
    /* //\* */

    /* function MyMod_Item_Anchor_Link($item=array(),$anchor="",$text="") */
    /* { */
    /*     if (count($item)==0) */
    /*     { */
    /*         $item=$this->ItemHash; */
    /*     } */

    /*     if ($anchor=="") */
    /*     { */
    /*         $anchor=$this->ModuleName."_".$item[ "ID" ]; */
    /*     } */

    /*     if ($text=="") */
    /*     { */
    /*         $text=$this->IMG("../icons/forward.gif"); */
    /*     } */

    /*     return $this->Span("<A HREF='#".$anchor."'>".$text."</A>"; */
    /* } */
}

?>