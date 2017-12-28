<?php

include_once("Table/Row.php");
include_once("Table/Table.php");

class ItemsTable extends ItemsTableTable
{
     //*
    //* function ItemsHtmlTable, Parameter list: ($title="",$edit=0,$datas=array(),$items=array(),$countdef=array(),$titles=array(),$sumvars=TRUE,$cgiupdatevar="Update")
    //*
    //* Returns Html version of Items table.
    //* 

    function ItemsHtmlTable($title="",$edit=0,$datas=array(),$items=array(),$countdef=array(),$titles=array(),$sumvars=TRUE,$cgiupdatevar="Update")
    {
        return
            $this->Html_Table
            (
               $this->MyMod_Data_Titles($datas),
               $this->ItemsTable
               (
                  $title,
                  $edit,
                  $datas,
                  $items,
                  $countdef,
                  $titles,
                  $sumvars,
                  $cgiupdatevar
               ),
               array(),
               array(),
               array(),
               TRUE,TRUE
            ).
            "";
    }


   //*
    //* function ItemsSelectForm, Parameter list: 
    //*
    //* Creates an Items Select Form, with first, previous, current, next and last links.
    //* 

    function ItemsSelectForm($title,$ids,$names,$titles,$current,$args,$argsfield,$selectfieldname,$posthtml,$nameref="ItemSelect")
    {
        $last=-1;
        $first=-1;
        $prev=-1;
        $next=-1;

        if (count($ids)>0)
        {
            $first=0;
            $last=count($ids)-1;
        }

        $i=0;
        $rnames=array();
        $pos=array();
        foreach ($ids as $id)
        {
            if ($id==$current)
            {
                if ($i==0)             { $first=-1; }
                if ($i==count($ids)-1) { $last=-1; }
                if ($i>1)              { $prev=$i-1; }
                if ($i<count($ids)-2)  { $next=$i+1; }
            }

            $rnames[ $id ]=$names[$i];
            $pos[ $id ]=$i;

            $i++;
        }

        $lastname="";
        $firstname="";
        $prevname="";
        $nextname="";
        if ($last>=0)  { $lastname =$names[ $last  ]; }
        if ($first>=0) { $firstname=$names[ $first ]; }
        if ($prev>=0)  { $prevname =$names[ $prev  ]; }
        if ($next>=0)  { $nextname =$names[ $next  ]; }


        $prevtext="";
        if ($prev>=0 && $prev-$first>1) { $prevtext="..."; }

        $nextttext="";
        if ($next>=0 &&  $last-$next>1) { $nextttext="..."; }


        $prelinks=array();
        if ($first>=0)
        {
            $args[ $argsfield ]=$ids[ $first ];
            array_push
            (
               $prelinks,
               $this->Href
               (
                  "?".$this->Hash2Query($args)."#".$nameref,
                  $firstname,
                  "Prim. ".$title." ".$names[ $first ]
               )
            );
        }

        if ($prev>=0)
        {
            $args[ $argsfield ]=$ids[ $prev ];
            array_push
            (
               $prelinks,
               $prevtext,
               $this->Href
               (
                  "?".$this->Hash2Query($args)."#".$nameref,
                  $prevname,
                  "Prev. ".$title." ".$names[ $prev ]
               )
            );
        }

        $postlinks=array();
        if ($next>=0)
        {
            $args[ $argsfield ]=$ids[ $next ];
            array_push
            (
               $postlinks,
               $this->Href
               (
                  "?".
                  $this->Hash2Query($args)."#".$nameref,
                  $nextname,
                  "Prox. ".$title." ".$names[ $next ]
               ),
               $nextttext
            );
        }

        if ($last>=0)
        {
            $args[ $argsfield ]=$ids[ $last ];
            array_push
            (
               $postlinks,
               $this->Href
               (
                  "?".$this->Hash2Query($args)."#".$nameref,
                  $lastname,
                  "Ult. ".$title." ".$names[ $last ]
               )
            );
        }

        return
            preg_replace
            (
               '/&'.$argsfield.'=\d+/',
               "",
               $this->StartForm("?".$this->Hash2Query($args))
            )."\n".
            $this->Anchor($nameref,"Selecionar ".$title.":")."\n".
            "[ "."\n".
            join(" &nbsp;\n ",$prelinks)."\n".
            $this->MakeSelectfield
            (
               $selectfieldname,
               $ids,
               $names,
               $current,
               array(),
               $titles
            )."\n".
            join(" &nbsp;\n ",$postlinks).
            " ]"."\n".
            $this->Button("submit","GO")."\n".
            $posthtml."\n".
            $this->EndForm().
            "";
    }
}
?>