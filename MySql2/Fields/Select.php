<?php

class SelectFields extends FileFields
{

    //*
    //* function SqlClassObj, Parameter list: $data
    //*
    //* Returns object associated with $data.
    //*

    function SqlClassObj($data)
    {
        $accessor=$this->ItemData[ $data ][ "SqlClass" ]."Obj";
        return $this->ApplicationObj->$accessor();
    }

    //*
    //* function ApplySqlObjectDataNames, Parameter list: &$item,$datas
    //*
    //* Loops of $datas, for SqlObject $data fields, substituting $item[ $data ]
    //* with name value from $sqlobj->Name($item[ $data ]) call.
    //*

    function ApplySqlObjectDataNames(&$item,$datas)
    {
        foreach ($datas as $data)
        {
           if (!empty($item[ $data ]))
            {
                if ($this->MyMod_Data_Field_Is_Sql($data))
                {
                    $item[ $data ]=$this->SqlClassObj($data)->Name(array("ID" => $item[ $data ]));
                }
                elseif ($this->MyMod_Data_Field_Is_Enum($data))
                {
                    $this->ApplyEnum($data,$item);
                }
            }
            else
            {
                $item[ $data ]="";
            }
        }
    }

    //*
    //* function MakeSelectShowField, Parameter list: $data,$datas,$namer,$item,$titler="",$empty=""
    //*
    //* Returns show field entry.
    //*

    function MakeSelectShowField($data,$datas,$namer,$item,$titler="",$empty="")
    {
        if (empty($item[ $data ])) { return ""; }

        $ritem=$this->SelectUniqueHash
        (
           "",
           array("ID" => $item[ $data ]),
           FALSE,
           $datas
        );

        $this->ApplySqlObjectDataNames($ritem,$datas);

        $name="";
        if (method_exists($this,$namer))
        {
            $name=$this->$namer($namer);
        }
        else
        {
            $name=$this->Filter($namer,$ritem);
        }

        $title="";
        if (method_exists($this,$titler))
        {
            $titler=$this->$titler();
        }
        else
        {
            $title=$this->Filter($titler,$ritem);
        }

        if (!empty($title))
        {
            $name=$this->Span($name,array("TITLE" => $title));
        }

        return $name;
    }

    //*
    //* function MakeSelectFieldWithItems, Parameter list: $edit,$data,$items,$datas,$namer,$item,$rdata="",$titler=""
    //*
    //* Create a select field, inlcuding only items satisfying $where.
    //* Reads $datas and filters $namer.
    //*

    function MakeSelectFieldWithItems($edit,$data,$items,$datas,$namer,$item,$rdata="",$titler="",$empty="")
    {
        if ($edit==0)
        {
            return $this->MakeSelectShowField($data,$datas,$namer,$item,$titler,$empty);
        }

        $values=array();
        $names=array();
        $titles=array();

        $value=0;
        if(!empty($item[ $data ]))
        {
            $value=$item[ $data ];
        }
        else { $empty=""; }

        $values=array(0);
        $names=array($empty);
        if (!empty($titler)) { $titles=array(""); }


        $title="";
        foreach ($items as $ritem)
        {
            if (!empty($ritem[ "__Disabled__" ]))
            {
                array_push($values,"disabled");
            }
            else
            {
                array_push($values,$ritem[ "ID" ]);
            }

            $this->ApplySqlObjectDataNames($ritem,$datas);

            array_push($names,$this->Filter($namer,$ritem));
            if (!empty($titler))
            {
                array_push($titles,$this->Filter($titler,$ritem));
                if ($ritem[ "ID" ]==$value) { $title=$this->Filter($titler,$ritem); }
            }
            elseif ($ritem[ "ID" ]==$value)
            {
                $title=$this->Filter($namer,$ritem);
            }
        }

        

        if (empty($rdata)) { $rdata=$data; }

        return $this->MakeSelectField
        (
           $rdata,
           $values,
           $names,
           $value,
           array(),
           $titles,
           $title
        );
    }

    //*
    //* function MakeSelectFieldWithWhere, Parameter list: $edit,$data,$where,$datas,$namer,$sortby,$item,$rdata="",$titler="",$empty=""
    //*
    //* Create a select field, inlcuding only items satisfying $where.
    //* Reads $datas and filters $namer.
    //*

    function MakeSelectFieldWithWhere($edit,$data,$where,$datas,$namer,$sortby,$item,$rdata="",$titler="",$empty="")
    {
        if ($edit==0)
        {
            return $this->MakeSelectShowField($data,$datas,$namer,$item);
        }

        $key=$data."_".$this->Hash2SqlWhere($where);
        if (empty($this->TmpItem[ $key ]))
        {
            $this->TmpItem[ $key ]=$this->SelectHashesFromTable
            (
               "",
               $where,
               $datas,
               FALSE,
               $sortby
            );
        }

        return
            $this->MakeSelectFieldWithItems
            (
               $edit,
               $data,
               $this->TmpItem[ $key ],
               $datas,
               $namer,
               $item,
               $rdata,
               $titler,
               $empty
            );
    }

}

?>