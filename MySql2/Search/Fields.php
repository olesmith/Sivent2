<?php

class SearchFields extends SearchCookies
{
    //*
    //* function CallSearchFieldMethod, Parameter list: $data
    //*
    //* If $this->ItemData[ $data ][ "SearchFieldMethod" ] is set, call search field method.
    //*

    function CallSearchFieldMethod($data,$rdata,$rval)
    {
        $method=$this->ItemData[ $data ][ "SearchFieldMethod" ];
        return $this->$method($data,array());
    }

    //*
    //* function DateSearchField, Parameter list: $data,$rdata,$rval
    //*
    //* Creates date type search field.
    //*

    function DateSearchField($data,$rdata,$rval)
    {
        return $this->HtmlDateInputField
        (
           $rdata,
           $rval
        );
    }

    //*
    //* function TimeSearchField, Parameter list: $data,$rdata,$rval
    //*
    //* Creates date type search field.
    //*

    function TimeSearchField($data,$rdata,$rval)
    {
        return
            $this->MakeSelectField
            (
             $rdata,
             array(0,1,2,3,4,5),
             array("","Uma Hora","Uma Dia","Uma Semana","Um Mês","Um Ano"),
             $rval
            ).
            " Atrás".
            "";
    }

    //*
    //* function EnumSearchField, Parameter list: $data,$rdata,$rval
    //*
    //* Creates ENUM type search field.
    //*

    function EnumSearchField($data,$rdata,$rval)
    {
        if ($this->ItemData[ $data ][ "GETSearchVarName" ])
        {
            $getvalue=$this->GetGET($this->ItemData[ $data ][ "GETSearchVarName" ]);
            if (!empty($getvalue))
            {
                //return $this->Values[ $getvalue-1 ];
                if (empty($rval))
                {
                    $rval=$getvalue;
                }
            }
        }
            

        $item=array();
        if (
              is_array($this->ItemData[ $data ][ "ValuesMatrix" ]) &&
              $this->ItemData[ $data ][ "ValuesDependencyVar" ]!=""
           )
        {
            $item[ $this->ItemData[ $data ][ "ValuesDependencyVar" ] ]=
                $this->GetSearchVarCGIValue($this->ItemData[ $data ][ "ValuesDependencyVar" ]);
        }

        $checkbox=FALSE;
        if (!empty($this->ItemData[ $data ][ "SearchCheckBox" ]))
        {
            $checkbox=1;
        }
        elseif (!empty($this->ItemData[ $data ][ "SearchRadioSet" ]))
        {
            $checkbox=2;
        }

        //Need to change ItemData NoSort - why?
        $tmp=$this->ItemData[ $data ][ "NoSort" ];

        if (!empty($this->ItemData[ $data ][ "NoSelectSort" ]))
        {
            $this->ItemData[ $data ][ "NoSort" ]=$this->ItemData[ $data ][ "NoSelectSort" ];
        }

        $value=preg_replace
        (
           '/NAME=[\'"]'.$data.'(_\d+)?[\'"]/i',
           "NAME='".$rdata."\\1'",
           $this->CreateDataSelectField
           (
              $data,
              $item,
              $rval,
              1, //ignore default
              $checkbox,
              "Selecione ".$this->ItemData[ $data ][ "Name" ]." para Visualização"
           )
        );

        //Restore ItemData NoSort
        $this->ItemData[ $data ][ "NoSort" ]=$tmp;

        return $value;
    }

    //*
    //* function TextSearchField, Parameter list: $data
    //*
    //* Creates text mseach field (for FOREIGN INDICES).
    //*

    function TextSearchField($data)
    {
        return $this->MakeInput
        (
           $this->GetTextSearchVarCGIName($data),
           $this->GetTextSearchVarCGIValue($data),
           $this->ItemData[ $data ][ "SqlTextSearch" ],
           array("TITLE" => "Digite uma parte de ".$this->ItemData[ $data ][ "Name" ])
        );
     }


    //*
    //* function DefaultSearchField, Parameter list: $data
    //*
    //* Creates standard search field, simple INPUT.
    //*

    function DefaultSearchField($data,$rdata,$rval)
    {
        $wdt=10;
        if ($this->ItemData[ $data ][ "Size" ])
        {
            $wdt=$this->ItemData[ $data ][ "Size" ];
        }

        return $this->MakeInput
        (
           $rdata,
           $rval,
           $wdt,
           array("TITLE" => "Digite uma parte de ".$this->ItemData[ $data ][ "Name" ])
        );
    }

    //*
    //* function MakeSearchVarInputField, Parameter list: $data
    //*
    //* Creates search var input field - ass text or select field.
    //*

    function MakeSearchVarInputField($data,$rval="")
    {
        $rdata=$this->GetSearchVarCGIName($data);
        if (empty($rval)) { $rval=$this->GetSearchVarCGIValue($data); }

        if (!empty($rval) && !is_array($rval))
        {
            $rval=html_entity_decode($rval,ENT_COMPAT,'UTF-8');
        }

        if ($rval=="" && !empty($this->ItemData[ $data ][ "SearchDefault" ]))
        {
            $rval=$this->ItemData[ $data ][ "SearchDefault" ];
        }

        if ($this->LoginType!="Public")
        {
            $rval=preg_replace('/#Login/',$this->LoginData[ "ID" ],$rval);
        }

        $value="";
        if ($this->ItemData[ $data ][ "SearchFieldMethod" ])
        {
            $value=$this->CallSearchFieldMethod($data,$rdata,$rval);
        }
        elseif ($this->MyMod_Data_Field_Is_Date($data))
        {
            $value=$this->DateSearchField($data,$rdata,"");
        }
        elseif ($this->MyMod_Data_Field_Is_Time($data))
        {
            $value=$this->TimeSearchField($data,$rdata,$rval);
        }
        elseif ($this->MyMod_Data_Field_Is_Enum($data))
        {
            $value=$this->EnumSearchField($data,$rdata,$rval);
        }
        elseif ($this->MyMod_Data_Field_Is_Sql($data))
        {
            $value=$this->MyMod_Data_Fields_Sql_Search_Select($data,$rdata,$rval);
        }
        else
        {
            $value=$this->DefaultSearchField($data,$rdata,$rval);
        }

        return $value;
    }

    //*
    //* function GetSearchVarTitle, Parameter list: $data
    //*
    //* Generates title for saerch var $var.
    //*

    function GetSearchVarTitle($var)
    {
        $name=$this->GetRealNameKey($this->ItemData[ $var ],"SearchName");

        if ($name=="")
        {
            $name=$this->GetRealNameKey($this->ItemData[ $var ],"Name");
        }

        return $name;
    }
}


?>