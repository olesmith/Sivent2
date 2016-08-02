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
        if (count($item)>0) {} else { $item=$this->ItemHash; }
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
                     $this->ItemAnchor($item).
                     $this->H(5,$this->GetItemName($item)),
                     2
                  )
               )
            );
        }

        $compulsories=0;
        foreach ($rdatalist as $data)
        {
            $hidden=FALSE;
            if (
                isset($this->ItemData[ $data ][ "Hidden" ]) &&
                $this->ItemData[ $data ][ "Hidden" ]
               )
            {
                $hidden=TRUE;
            }

            if (
                !$hidden &&
                $data!="No" &&
                isset($this->ItemData[ $data ])
               )
            {
                $row=array();
                $this->ItemTableRow($edit,$item,$data,$compulsories,$row,$plural,$precgikey);
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
                  $this->CompulsoryMessage()
               )
             );
        }


        return $tbl;
    }

    //*
    //* 
    //*

    function ItemAnchor($item=array(),$anchor="",$text="")
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

        return "<A NAME='".$anchor."'>".$text."</A>";
    }

    //*
    //* 
    //*

    function CompulsoryMessage()
    {
        return $this->Center
        (
           "&gt;&gt; ".
           $this->GetMessage($this->ItemDataMessages,"CompulsoryMessage").
           " &lt;&lt;",
           array("CLASS" => 'datatitlelink')
        );
    }

    //*
    //* 
    //*

    function ItemAnchorLink($item=array(),$anchor="",$text="")
    {
        if (count($item)==0)
        {
            $item=$this->ItemHash;
        }

        if ($anchor=="")
        {
            $anchor=$this->ModuleName."_".$item[ "ID" ];
        }

        if ($text=="")
        {
            $text=$this->IMG("../icons/forward.gif");
        }

        return "<A HREF='#".$anchor."'>".$text."</A>";
    }


}
?>