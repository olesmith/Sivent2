<?php

class ItemsGroupTable extends ItemsTable
{
    //*
    //* function ItemsTableDataGroupWithAddRow, Parameter list: 
    //*
    //* Creates ItemTableDataGroup table with add row. Update and adding row called on the way.
    //*

    function ItemsTableDataGroupWithAddRow($title,$group,$cgiupdatevar,$cgiprekey,$newitem,$postmethod=FALSE,$updatekey="AddRow",$nempties=0)
    {
        $this->ItemData();
        
        $datas=$this->ItemDataGroups[ $group ][ "Data" ];
        $added=FALSE;
        if ($this->GetPOST($cgiupdatevar)==1 && $this->GetPOST($updatekey)==1)
        {
            $newitem=$this->UpdateAddRow($cgiprekey,$newitem,$datas,$updatekey);
        }

        $this->MyMod_Items_Read("",$datas,TRUE,FALSE,2);
 
        if ($postmethod)
        {
            $newitem=$this->$postmethod($newitem);
        }


        $table=$this->MyMod_Data_Group_Table
        (
           $title,
           1,
           $group,
           $this->ItemHashes,
           array(),
           $cgiupdatevar
        );

        array_push
        (
           $table,
           $this->AddRow($cgiprekey,$newitem,$datas,!$added,$nempties)
        );

        return $table;
    }

    //*
    //* function ItemGroupHtmlTable, Parameter list: $title,$where,$sort="Name"
    //*
    //* Generates html table for $where conforming items.
    //*

    function ItemGroupHtmlTable_20160908($title,$where,$sort="Name")
    {
        $items=$this->SelectHashesFromTable
        (
           "",
           $where,
           array(),
           FALSE,
           $sort
        );

        $html="";
        if (!empty($title)) { $html.=$this->H(1,$title); }

        if (count($items)>0)
        {
            $html.=
                $this->H(2,$this->ItemsName).
                $this->Html_Table
                (
                   "",
                   $this->MyMod_Data_Group_Table
                   (
                      "",
                      0,
                      "",
                      $items,
                      array()
                   ),
                   array("BORDER" => 1,"ALIGN" => 'center')
                ).
                "";
        }
        else
        {
            $html.=$this->H(2,"Nenhum(a) ".$this->ItemName);
        }

        return $html;
    }
}
?>