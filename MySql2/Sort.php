<?php

class Sort extends Search
{

  ###*
  ###* Variables of Sort class:

    var $Sort=array("Name");
    var $Reverse=FALSE;

    //*
    //* function InitSort, Parameter list: 
    //*
    //* Initilize sorting subsystem.
    //*

    function InitSort($hash=array())
    {
    }

    //*
    //* function AddSort, Parameter list: $sort
    //*
    //* Unshifts $sort onto array $this->Sort - unless already in array.
    //*

    function AddSort($sort)
    {
        if (!preg_grep('/'.$sort.'/',$this->Sort))
        {
            array_unshift($this->Sort,$sort);
        }
    }

    //*
    //* function GetSort, Parameter list: $sort=""
    //*
    //* Looks at $sort and cgivalue of Module sort var,
    //* returns first defined value - should be and array!
    //*

    function GetSort($sort="")
    {
        if ($sort=="")
        {
            if ($this->GetCGIVarValue($this->ModuleName."_Sort")!="")
            {
                $sort=$this->GetCGIVarValue($this->ModuleName."_Sort");
            }
        }

        return $sort;
    }

    //*
    //* function GetReverse, Parameter list: $reverse=""
    //*
    //* As GetSort, but reads cgivalue of module Reverse.
    //*

    function GetReverse($reverse="")
    {
        $reverse=$this->Reverse;
        if ($reverse=="")
        {
            if ($this->GetCGIVarValue($this->ModuleName."_Reverse")!="")
            {
                $reverse=$this->GetCGIVarValue($this->ModuleName."_Reverse");
            }
            else
            {
                $reverse=FALSE;
            }
        }

        return $reverse;
    }

    //*
    //* function DetectSort, Parameter list: $group=""
    //*
    //* Consider $group in detecting $sort value to use.
    //*

    function DetectSort($group="")
    {
        $sort="";
        $reverse=$this->Reverse;
        if ($this->GetCGIVarValue($this->ModuleName."_Sort")!="")
        {
            $sort=$this->GetCGIVarValue($this->ModuleName."_Sort");
            $reverse=$this->GetCGIVarValue($this->ModuleName."_Reverse");
        }

        if ($sort=="" && $group!="")
        {
            if (!empty($this->ItemDataGroups[ $group ][ "Sort" ]))
            {
                $sort=$this->ItemDataGroups[ $group ][ "Sort" ];
                $reverse=$this->ItemDataGroups[ $group ][ "Reverse" ];
            }
        }

        if ($sort) { $this->AddSort($sort); }

        $this->Reverse=$reverse;

        return array($sort,$reverse);
    }

    //*
    //* function SortVars2DataList, Parameter list: &$datas=array()
    //*
    //* Appends all sort vars to array $datas.
    //*

    function SortVars2DataList(&$datas=array())
    {
        if (!is_array($this->Sort))
        {
            $this->Sort=array($this->Sort,"ID");
        }

        foreach ($this->Sort as $data)
        {
            if (!preg_grep('/^'.$data.'$/',$datas))
            {
                array_push($datas,$data);
            }
        }
    }


    //*
    //* function GetSortTitle, Parameter list: $title,$options="",$latex=FALSE
    //*
    //* Returns sort title, as SPAN element. $opt's are added as options.
    //*

    function GetSortTitle($title,$options="",$latex=FALSE)
    {
        if ($latex)
        {
            return "\\textbf{".$title."}\n";
        }
        else
        {
            if (!is_array($options))
            {
                $options=$this->Options2Hash($options);
            }

            $options[ "CLASS" ]='datatitlelink';
            return $this->HtmlTags("SPAN",$title,$options)."\n";
        }
    }

    //*
    //* function MakeSortTitle, Parameter list: $data,$sortlinks=TRUE,$latex=FALSE
    //*
    //* Make sort title cell for data $data.
    //*

    function MakeSortTitle($data,$sortlinks=TRUE,$latex=FALSE)
    {
        $args=$this->Query2Hash();

        $title=$this->GetDataTitle($data);

        $title=preg_replace('/#ItemName/',$this->ItemName,$title);
        $title=preg_replace('/#ItemsName/',$this->ItemsName,$title);

        $options=array();
        if (!empty($this->ItemData[ $data ][ "Title" ]))
        {
            $options[ "TITLE" ]=$this->ItemData[ $data ][ "Title" ];
        }

        $title=$this->GetSortTitle($title,$options,$latex);

        if (
              $data=="No"
              ||
              !$this->HashKeySetAndTRUE($this->ItemData,$data)
              ||
              $this->HashKeySetAndTRUE($this->ItemData[ $data ],"NoSort")
            )
        {
            return $title;
        }

        $sort=$this->GetSort();
        if (!$sortlinks || $latex) {}
        elseif ($this->GetSort()!=$data)
        {
            $args[ $this->ModuleName."_Sort" ]=$data;

            $img=$this->IMG
            (
               $this->Icons."/nosort.png",
               "Reversar",
               0,0,
               array
               (
                  "CLASS" => 'datatitleimg'
               )
            )."\n";
            $stitle=
                "Colocar em Ordem de ".
                $this->ItemData[ $data ][ "Name" ];

            $query="?".$this->Hash2Query($args);

            $title.=" ".$this->Href($query,$img,$stitle,"",'datatitleimg');
        }
        else
        {
            $args[ $this->ModuleName."_Sort" ]=$sort;

            $text="Normal";
            if ($this->GetReverse()==1)
            {
                $args[ $this->ModuleName."_Reverse" ]=0;
                $img="/sortup.png";
            }
            else
            {
                $args[ $this->ModuleName."_Reverse" ]=1;
                $img="/sortdown.png";
                $text="Reversa";                  
            }

            $img=$this->IMG
            (
               $this->Icons.$img,
               "Reversar",
               0,0,
               array
               (
                  "CLASS" => 'datatitlelink'
               )
            )."\n";
            $query="?".$this->Hash2Query($args);
            $title.=$this->Href($query,$img,"Colocar em Ordem ".$text,"12",'datatitleimg');

            unset($args[ $this->ModuleName."_Reverse" ]);
        }

        return $title;
    }

    //*
    //* function GetSortTitles, Parameter list: $datas,$sortlinks=TRUE,$latex=FALSE
    //*
    //* Returns array of sort titles.
    //*

    function GetSortTitles($datas,$sortlinks=TRUE,$latex=FALSE)
    {
        $sort=$this->GetSort();
        $reverse=$this->GetReverse();

        $titles=array();
        for ($n=0;$n<count($datas);$n++)
        {
            if (preg_match('/newline/',$datas[ $n ]))
            {
                break;
            }

            $titles[$n]=$this->MakeSortTitle($datas[$n],$sortlinks,$latex);

        }

        return $titles;
    }

    //*
    //* function SortItems, Parameter list: $sort="",$reverse=""
    //*
    //* Do actual sorting on items in $this->ItemHashes.
    //*

    function SortItems($sort="",$reverse="")
    {
        if ($sort=="") { $sort=$this->Sort; }
        $reverse=$this->GetReverse($reverse);

        if (!is_array($sort))
        {
            $sort=preg_split('/\s*,\s*/',$sort);
        }

        array_push($sort,"ID"); //ID makes sort fields unique!

        $hashes=array();
        foreach ($this->ItemHashes as $n => $hash)
        {
            $value="";
            foreach ($sort as $iid => $key)
            {
                if (!isset($this->ItemData[ $key ]))
                {
                    if (!empty($hash[ $key ]))
                    {
                        $value.=" ".$hash[ $key ]; 
                    }
                    continue;
                }

                $rvalue=$hash[ $key ];       

                if (isset($this->ItemData[ $key ][ "SqlObject" ]))
                {
                    $object=$this->ItemData[ $key ][ "SqlObject" ];
                    $rvalue=$this->ApplicationObj->$object->GetItemName($rvalue);
                }

                if (
                    //$this->ItemData[ $key ][ "Sql" ]=="ENUM"
                    //&&
                    isset($this->ItemData[ $key ][ "NumericalSort" ])
                    &&
                    $this->ItemData[ $key ][ "NumericalSort" ]==TRUE)
                {
                    if (
                        isset($this->ItemData[ $key ][ "SortReverse" ])
                        &&
                        $this->ItemData[ $key ][ "SortReverse" ]==TRUE
                       )
                    {
                        $rvalue=sprintf("%06d",100000-$hash[ $key ]);
                    }
                    else
                    {
                        $rvalue=sprintf("%06d",$hash[ $key ]);
                    }
                }
                elseif (isset($this->ItemData[ $key ][ "SqlTable" ]))
                {
                    $rvalue=$this->GetEnumValue($key,$hash);
                }
                elseif ($this->ItemData[ $key ][ "Sql" ]=="INT")
                {
                    $rvalue=sprintf("%06d",$rvalue);
                }
                elseif (!empty($this->ItemData[ $key ][ "DerivedFilter" ]))
                {
                    $rvalue=$this->FilterHash($this->ItemData[ $key ][ "DerivedFilter" ],$hash);
                }
                elseif (!empty($this->ItemData[ $key ][ "DerivedNamer" ]))
                {
                    $rvalue=$hash[ $this->ItemData[ $key ][ "DerivedNamer" ] ];
                }
                elseif (!empty($this->ItemData[ $key ][ "SortAsDate" ]))
                {
                    $rvalue=$this->Date2Sort($hash[ $key ]);
                }

                if ($rvalue!="") { $value.=" ".$rvalue; }
            }

            $value=preg_replace('/^\s*/',"",$value);
            $value=preg_replace('/\s*$/',"",$value);

            $value=$this->Text2Sort($value);
            $value=$this->Html2Sort($value);

            //Make sure two items do not have same sort key
            while (isset($hashes[ $value ]))
            {
                $value.="a";
            }

            $value=strtolower($value);
            $hashes[ $value ]=$hash;
        }

        $this->ItemHashes=array();

        $keys=array_keys($hashes);
        sort($keys);
        if ($reverse) { $keys=array_reverse($keys); }

        foreach ($keys as $rkey)
        {
            array_push($this->ItemHashes,$hashes[ $rkey ]);
        }

        //return $this->ItemHashes;
    }

    function SortList($list,$sorts=array(),$reverse=FALSE)
    {
        if (empty($sorts))
        {
            $sorts=$this->Sort;
        }

        if (!is_array($sorts) || empty($sorts))
        {
            $sorts=preg_split('/\s*,\s*/',$sorts);
        }

        array_push($sorts,"ID"); //ID make sort fields alqways unique!
        $rlist=array();
        foreach ($list as $n => $hash)
        {
            $value="";
            foreach ($sorts as $key)
            {
                $rvalue=$hash[ $key ];
                if ($rvalue!="") { $value.=" ".$rvalue; }
            }

            $value=preg_replace('/^\s*/',"",$value);
            $value=preg_replace('/\s*$/',"",$value);

            $value=$this->Text2Sort($value);
            $value=$this->Html2Sort($value);

            //Make sure two items do not have same sort key
            while (isset($rlist[ $value ]))
            {
                $value.="a";
            }

            $value=strtolower($value);
            $rlist[ $value ]=$hash;
        }

        $keys=array_keys($rlist);

        sort($keys);
        if ($reverse || $reverse==1) { $keys=array_reverse($keys); }

        $list=array();
        foreach ($keys as $rkey)
        {
            array_push($list,$rlist[ $rkey ]);
        }

        return $list;
    }
}


?>