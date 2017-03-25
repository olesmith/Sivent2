<?php


class ItemsTableTable extends ItemsTableRow
{
    var $ItemTableRowMethod="ItemsTableRow";

     //*
    //* function ItemsTableData, Parameter list: $title,$edit=0,$datas=array(),$items=array(),$countdef=array(),$titles=array(),$sumvars=TRUE,$cgiupdatevar="Update"
    //*
    //* Returns list of data in items table.
    //* 

    function ItemsTableData($datas)
    {
        $rdatas=array();

        $unique=array();
        foreach ($datas as $data)
        {
            if (preg_match('/newline/',$data))
            {
                array_push($rdatas,$data);
            }
            elseif (empty($unique[ $data ]))
            {
                array_push($rdatas,$data);
                $unique[ $data ]=TRUE;
            }
        }

        return $rdatas;
    }

    
   //*
    //* function ItemsTable, Parameter list: $title,$edit=0,$datas=array(),$items=array(),$countdef=array(),$titles=array(),$sumvars=TRUE,$cgiupdatevar="Update"
    //*
    //* Joins table as a matrix for items in $items, or if empty, in $this->ItemHashes.
    //* Includes $title as a H2 title.
    //* If $edit==1 (Edit), produces input fields (Edit), otherwise just 'shows' data. Default 0 (Show).
    //* $titles should be deprecated!!! Title row is inserted in Table class.
    //* 

    function ItemsTable($title="",$edit=0,$datas=array(),$items=array(),$countdef=array(),$titles=array(),$sumvars=TRUE,$cgiupdatevar="Update")
    {
        if (count($items)==0)     { $items=$this->ItemHashes; }
        if (count($datas)==0)     { $datas=$this->GetDefaultDataGroup(); }

        $searchvars=$this->MyMod_Items_Search_Vars_Get($datas);
        if ($this->AddSearchVarsToDataList)
        {
            $datas=$this->AddSearchVarsToDataList($datas);
        }

        $datas=$this->ItemsTableData($datas);

        if (!empty($cgiupdatevar) && $this->CGI_POSTint($cgiupdatevar)==1)
        {
            $items=$this->MyMod_Items_Update($items,$datas);
        }

        $showall=$this->GetPOST($this->ModuleName."_Page");
        if (empty($showall))
        {
            $showall=$this->ShowAll;
        }
        else
        {
            $showall=TRUE;
        }

        $nn=$this->FirstItemNo+1;

        $actions=array();
        if (is_array($this->ItemActions)) { $actions=$this->ItemActions; }

        $subdatas=array();
        $subtitles=array();
        if (count($countdef)>0)
        {
            $subdatas=$this->CheckHashKeysArray
            (
               $countdef,
               array($this->Profile."_Data",$this->LoginType."_Data","Data")
            );

            $rdatas=array();
            foreach ($subdatas as $data)
            {
                array_push($rdatas,$data."1");
            }

            $subtitles=$this->GetDataTitles($rdatas);

            $title1="";
            if (isset($countdef[ "NoTitle" ])) { $title1=$countdef[ "NoTitle" ]; }

            array_unshift($subtitles,$title1);
        }

        $tbl=array();
        if (count($titles)>0)
        {
            array_push
            (
               $tbl,
               array
               (
                  "Class" => 'head',
                  "Row" => $this->MyMod_Sort_Title_Cells($titles)
               )
            );
        }

        $sums=array();
        foreach ($this->SumVars as $data)
        {
            $sums[ $data ]=0;
        }

        $even=FALSE;
        foreach ($items as $item)
        {
            $method=$this->ItemTableRowMethod;
            $this->$method($edit,$item,$nn,$datas,$subdatas,$tbl,$even);

            foreach ($this->SumVars as $data)
            {
                if (isset($item[ $data ]))
                {
                    $sums[ $data ]+=$item[ $data ];
                }
            }

            if ($even) { $even=FALSE; }
            else       { $even=TRUE; }

            $nn++;
        }

        if ($sumvars && count($items)>0 && count($this->SumVars)>0)
        {
            if (method_exists($this,"SumVarsRows"))
            {
                $tbl=array_merge($tbl,$this->SumVarsRows($datas,$sums,$items));
            }
            else
            {
                array_push($tbl,$this->SumVarsRow($datas,$sums,$items));
            }
        }

        return $tbl;
    }
}
?>