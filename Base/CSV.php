<?php


global $ClassList;
array_push($ClassList,"CSV");

class CSV extends Html
{

    //*
    //* Init CSV class.
    //*

    function InitCSV($data=array())
    {
    }
    
    //*
    //* function ItemsCSVTable, Parameter list: $title,$items=array(),$datas=array(),$titles=array()
    //*
    //* Creates latex table with datas in the columns, one for each item in $item.
    //* If $datas is the empty list, retrieves $datas from actual data group.
    //*

    function ItemsCSVTable($items=array(),$datas=array(),$titles=array())
    {
        if (count($items)==0)     { $items=$this->ItemHashes; }
        if (count($datas)==0)
        {
            $group=$this->GetActualDataGroup();
            $datas=$this->GetGroupDatas($group);
            if (is_array($this->ItemDataGroups[ $group ][ "TitleData"]))
            {
                $titles=$this->ItemDataGroups[ $group ][ "TitleData"];
                $datas=$this->ItemDataGroups[ $group ][ "Data"];
            }
            else
            {
                $titles=$this->MyMod_Data_Titles($datas,1);
            }
        }

        $rdatas=array();
        $rtitles=array();
        for ($n=0;$n<count($titles);$n++)
        {
            $data=$datas[$n];
            if (
                !isset($this->Actions[ $data ])
                &&
                $datas[$n]!="No"
               )
            {
                array_push($rdatas,$data);
                $titles[$n]=preg_replace('/;/',",",$titles[$n]);
                array_push($rtitles,$titles[$n]);
            }
        }

        $tbl=array();
        $nn=1;
        foreach ($items as $item)
        {
            $item=$this->ApplyAllEnums($item,TRUE);
            $item=$this->TrimLatexItem($item);

            $item[ "_RID_" ]=sprintf("%03d",$item[ "ID" ]);
            $nn=sprintf("%03d",$nn);

            $rows=array();

            $count=1;
            $number=1;
            $row=array($nn);
            foreach ($rdatas as $data)
            {
                $value=$item[ $data ];

                if ($this->ItemData[ $data ][ "TimeType" ]==1)
                {
                    $value=$this->MTime2Name($value);
                }
                if (!preg_match('/\S/',$value)) { $value=""; }
                $value=preg_replace('/;/',",",$value);
                array_push($row,$value);
            }

            array_push($tbl,$row);
            $nn++;
        }

        array_unshift($rtitles,'No');
        $text=join(";",$rtitles)."\n";
        foreach ($tbl as $id => $row)
        {
            $text.=join(";",$row)."\n";
        }
        
        $this->SendDocHeader("csv",$this->ModuleName.".".$this->MTime2FName().".csv","utf-8");
        echo $text;
        exit();
    }

}
?>