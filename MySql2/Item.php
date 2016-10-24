<?php


include_once("Item/Forms.php");
include_once("Item/Edits.php");
include_once("Item/Row.php");
include_once("Item/Table.php");
include_once("Item/Prints.php");
include_once("Item/Reads.php");
include_once("Item/PostProcess.php");
include_once("Item/Latex.php");
include_once("Item/BackRefs.php");
include_once("Item/Tests.php");
include_once("Item/Update.php");

class Item extends ItemUpdate
{
    //*
    //* Variables of Item class:
    //*

    var $ID,$ItemHash;
    var $AddDefaults=array();
    var $ItemPostProcessor,$TestMethod;
    var $BackRefDBs=array();
    var $TriggerFunctions=array();
    var $Upload;
    var $ParentTables=array();
    var $HasFileFields,$FileVars=array();
    var $ItemDataMessages="Item.php";
    var $NoFieldComments=FALSE;
    var $FormWasUpdated=FALSE;
    var $CreatorField="Creator";
    var $UploadPath="Uploads/#Module";
    var $UploadFilesHidden=FALSE;
    var $UniqueSqlWhere=array();


    //*
    //* function InitItem, Parameter list: $hash=array()
    //*
    //* Initializer.
    //*

    function InitItem($hash=array())
    {
        foreach ($this->ItemData as $data => $hash)
        {
            if (preg_match('/^FILE$/',$hash[ "Sql" ]))
            {
                array_push($this->FileVars,$data);
            }
        }

        $this->HasFileFields=1;
    }





    //*
    //* function GetDataPrefix, Parameter list: $data
    //*
    //* Returns prefix to use in parent object; items and titles
    //*

    function GetDataPrefix($data)
    {
        $prefix=$data."_";
        if (isset($this->ItemData[ $data ][ "SqlDataPrefix" ]))
        {
            $prefix=$this->ItemData[ $data ][ "SqlDataPrefix" ];
        }

        return $prefix;
    }


    function GetItemName($item=array(),$datas=array())
    {
        if (!is_array($item) && preg_match('/^\d+$/',$item))
        {
            $item=$this->ReadItem($item,$datas);
        }
        elseif (count($item)==0)
        {
            $item=$this->ItemHash;
        }


        $name="";
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
                        $name=$item[ $this->ItemNamer ];
                    }
                }
            }
        }

        return $name;
    }


    //*
    //* function TreatDataAsLatex, Parameter list: $value
    //*
    //* Processes 
    //*

    function TreatDataAsLatex($value)
    {
        return $value;
    }

    //*
    //* function TreatDataAsNonLatex, Parameter list: $value
    //*
    //* Processes 
    //*

    function TreatDataAsNonLatex($value)
    {
        $value=$this->Html2Text($value);

        $value=preg_replace('/&#92;/','\\\\',$value);

        $show=FALSE;
        if (preg_match('/\\\\/',$value)) { $show=TRUE;}

        $value=preg_replace('/%/','\%',$value);
        $value=preg_replace('/#/','\#',$value);

        //Added \ on regexp, 18082013
        $value=preg_replace('/\$/','\$',$value);
        $value=preg_replace('/&/','\&',$value);
        $value=preg_replace('/_/','\_',$value);

        //Escapes also the brackets in \command{...}
        //$value=preg_replace('/\s+{/',' \{',$value);
        //$value=preg_replace('/}\s+/','\} ',$value);

        $value=preg_replace('/~/','$\sim$',$value);
        $value=preg_replace('/\^/','$\wedge$',$value);
        $value=preg_replace('/&quot;/','"',$value);

        //????$value=preg_replace('/&#39;/','\'',$value);
        //if ($show) { var_dump($value); exit();}

        return $value;
    }

    //*
    //* function PreProcessFieldsForLatex, Parameter list: &$item,$data
    //*
    //* Preprocesses data fields for latex specific stuff.
    //*

    function PreProcessFieldForLatex(&$item,$data)
    {
        if (
            !empty($this->ItemData[ $data."_LaTeX" ])
            &&
            $item[ $data."_LaTeX" ]==1
           )
        {
            $item[ $data ]=$this->TreatDataAsLatex($item[ $data ]);
        }
        else
        {
            $item[ $data ]=$this->TreatDataAsNonLatex($item[ $data ]);
        }
    }

    //*
    //* function PreProcessFieldsForLatex, Parameter list: &$item
    //*
    //* Preprocesses data fields for latex specific stuff.
    //* Should be called before printing!
    //*

    function PreProcessFieldsForLatex(&$item)
    {
        foreach ($this->ItemData as $data => $value)
        {
            $this->PreProcessFieldForLatex($item,$data);
        }
    }


    //*
    //* function TrimHourData, Parameter list: $item,$data,$newvalue
    //*
    //* Trims hour/min strings. TriggerFunction style, that is may be used as a TriggerFunction.
    //*

    function TrimHourData($item,$data,$newvalue)
    {
        if (preg_match('/\d\d?/',$newvalue))
        {
            $newvalue=$this->TrimHourValue($newvalue);
        }

        $item[ $data ]=$newvalue;

        return $item;
    }

    //*
    //* function TrimDateData, Parameter list: $item,$data,$newvalue
    //*
    //* Trims date/mon/year strings. TriggerFunction style, that is may be used as a TriggerFunction.
    //*

    function TrimDateData($item,$data,$newvalue)
    {
        if (empty($newvalue) && !empty($item[ $data ]))
        {
            $newvalue=$item[ $data ];
        }

        if (preg_match('/\d\d?/',$newvalue))
        {
            $newvalue=$this->TrimDateValue($newvalue);
        }

        $item[ $data ]=$newvalue;

        return $item;
    }

    //*
    //* function TakeUndefinedKey, Parameter list: &$item,&$ukeys,$citem,$keys,$rkey=""
    //*
    //* Takes keys in $keys, set but empty in $item and sets them to correspondinbg key in $citem.
    //* $ukeys is incremented with keys set.
    //*

    function TakeUndefinedKey(&$item,&$ukeys,$citem,$key,$rkey="")
    {
        if (isset($item[ $key ]) && empty($item[ $key ]))
        {
            $data=$key;
            if (!empty($rkey)) { $data=$rkey; }

            $item[ $key ]=$citem[ $data ];
            array_push($ukeys,$key);
        }
    }

     //*
    //* function TakeUndefinedKeys, Parameter list: &$item,&$ukeys,$citem,$keys,$rkey=""
    //*
    //* Takes keys in $keys, set but empty in $item and sets them to correspondinbg key in $citem.
    //* $ukeys is incremented with keys set.
    //*

    function TakeUndefinedKeys(&$item,&$ukeys,$citem,$keys,$rkey="")
    {
        foreach ($keys as $key)
        {
            $this->TakeUndefinedKey($item,$ukeys,$citem,$key,$rkey);
        }
    }



    //*
    //* function TakeUndefinedListOfKeys, Parameter list: $item,$citem,$list,$updatemysql=FALSE
    //*
    //* Takes undefined 
    //*

    function TakeUndefinedListOfKeys(&$item,$citem,$list,$updatemysql=FALSE)
    {
        $udatas=array();
        foreach ($list as $def)
        {
            if (is_array($def))
            {
                $this->TakeUndefinedKeys
                (
                   $item,
                   $udatas,
                   $citem,
                   $def[ "Keys" ],
                   $def[ "Key" ]               
                );
            }
            else
            {
                $this->TakeUndefinedKey
                (
                   $item,
                   $udatas,
                   $citem,
                   $def,
                   $def               
                );
            }
        }

        if ($updatemysql && count($udatas)>0)
        {
            $this->MySqlSetItemValues("",$udatas,$item);
        }

        return $udatas;
    }


    //*
    //* function SubItemUpdateDatas, Parameter list: &$item,$data,$subdatas,$updatesdatas,$update=TRUE,$rsubdatas=array()
    //*
    //* Update $item $subdatas fields, reading $data, which should have SqlObject.
    //*

    function SubItemUpdateDatas(&$item,$data,$subdatas,$updatesdatas,$update=TRUE,$rsubdatas=array())
    {
        if (!empty($item[ $data ]))
        {
            //Data keys in $item
            if (empty($rsubdatas)) { $rsubdatas=$subdatas; }

            $this->MakeSureWeHaveRead("",$item,$subdatas);

            $obj=$this->ItemData[ $data ][ "SqlClass" ];
            $obj=$this->ApplicationObj()->SubModulesVars[ $obj ][ "SqlAccessor" ];

            $subitem=$this->$obj()->SelectUniqueHash
            (
               "",
               array("ID" => $item[ $data ]),
               FALSE,
               $subdatas
            );

            foreach ($subdatas as $id => $data)
            {
                $rdata=$rsubdatas[ $id ];
                if (empty($item[ $rdata ]) || $item[ $rdata ]!=$subitem[ $data ])
                {
                    $item[ $rdata ]=$subitem[ $data ];
                    array_push($updatesdatas,$rdata);
                }
            }
        }

        if ($update && count($updatesdatas)>0)
        {
            $this->MySqlSetItemValues("",$updatesdatas,$item);
        }

        return $updatesdatas;
    }
}
?>