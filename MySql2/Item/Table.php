<?php

class ItemTable extends ItemRow
{
    //*
    //* Creates item table
    //*

    var $ItemEditData=array();

    //*
    //* function HtmlItemTable, Parameter list: $edit,$datas,$item=array(),$table=array(),$plural=FALSE
    //*
    //* Creates a full blown HtmlItemTable.
    //*

    function HtmlItemTable($edit,$datas,$item=array(),$table=array(),$plural=FALSE,$precgikey="")
    {
        if (empty($item)) { $item=$this->ItemHash; }

        return $this->Html_Table
        (
           "",
           $this->ItemTable
           (
              $edit,
              $item,
              FALSE,
              $datas,
              $table,
              $plural,
              FALSE, //don't include title,
              TRUE,
              $precgikey
           ),
           array("ALIGN" => 'center')
        );
    }


    //*
    //* Creates item table, calling ItemTableRow for each var.
    //*

    function ItemTable($edit=0,$item=array(),$noid=FALSE,$rdatalist=array(),$tbl=array(),
                       $plural=FALSE,$includename=TRUE,$includecompulsorymsg=TRUE,$precgikey="")
    {
        if (empty($item)) { $item=$this->ItemHash; }
        $item=$this->TestItem($item);

        $datalist=array_keys($this->ItemData);
        $datalist=preg_grep('/^[AMC]Time$/',$datalist,PREG_GREP_INVERT);
        if (
            count($rdatalist)==0
            &&
            count($this->ItemEditData)>0
           )
        {
            $rdatalist=$this->ItemEditData;
        }

        if (count($rdatalist)==0) { $rdatalist=$datalist; }
        if ($noid) { $rdatalist=preg_grep('/^ID$/',$rdatalist,PREG_GREP_INVERT); }

        if ($includename)
        {
            array_push
            (
               $tbl,
               array
               (
                  $this->MultiCell
                  (
                     $this->MyMod_Item_Anchor($item).
                     $this->H(5,$this->MyMod_Item_Name_Get($item)),
                     2
                  )
               )
            );
        }

        if (!empty($item[ "ID" ] ) && empty($this->Item_Data_Edit_Control[ $item[ "ID" ] ]))
        {
            $this->Item_Data_Edit_Control[ $item[ "ID" ] ]=array();
        }
        
        $compulsories=0;
        foreach ($rdatalist as $data)
        {
            $redit=$this->MyMod_Item_Table_Edit($item,$edit,$data);
            $hidden=FALSE;
            if (
                isset($this->ItemData[ $data ][ "Hidden" ]) &&
                $this->ItemData[ $data ][ "Hidden" ]
               )
            {
                $hidden=TRUE;
            }

            $this->MyMod_Item_Table_Edit_Control_Set($item,$data);
            if (
                !$hidden &&
                $data!="No" &&
                isset($this->ItemData[ $data ])
               )
            {
                $row=array();
                $this->ItemTableRow($redit,$item,$data,$compulsories,$row,$plural,$precgikey);
                if (count($row)>0) { array_push($tbl,$row); }
            }
            elseif (isset($this->Actions[ $data ]))
            {
                $row=array
                (
                   $this->DecorateDataTitle
                   (
                      $this->GetRealNameKey($this->Actions[ $data ]).":"
                   ),
                   $this->MyActions_Entry($data,$item)
                );
                if (count($row)>0) { array_push($tbl,$row); }
            }
            elseif (method_exists($this,$data))
            {
                array_push
                (
                   $tbl,
                   array
                   (
                      $this->Span($this->$data().":",array("CLASS" => 'datatitlelink')),
                      $this->Span($this->$data($item),array("CLASS" => 'data'))
                   )
                );
            }

        }

        if ($includecompulsorymsg && $compulsories>0 && $edit==1)
        {
            array_push
            (
               $tbl,
               array
               (
                  $this->MyMod_Data_Compulsory_Message()
               )
             );
        }


        return $tbl;
    }



}
?>