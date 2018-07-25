<?php


trait MyMod_Search_Field
{
    //*
    //* function MyMod_Search_Field_Make, Parameter list: $data,$fixedvalues,$rval=""
    //*
    //* Creates search var input field.
    //*

    function MyMod_Search_Field_Make($data,$fixedvalues,$rval="")
    {
        return
            $this->MyMod_Search_Field_Value($data,$fixedvalues,$rval);
    }

    //*
    //* function MyMod_Search_Field_Value, Parameter list: $data,$fixedvalues,$rval=""
    //*
    //* Creates search var input value.
    //*

    function MyMod_Search_Field_Value($data,$fixedvalues,$rval="")
    {
        $fixedvalue="";
        if (!empty($fixedvalues[ $data ]))
        {
            $fixedvalue=$fixedvalues[ $data ];
        }
                
        $rdata=$this->MyMod_Search_CGI_Name($data);
        if (empty($rval)) { $rval=$this->MyMod_Search_CGI_Value($data); }

        if (!empty($rval) && !is_array($rval))
        {
            $rval=html_entity_decode($rval,ENT_COMPAT,'UTF-8');
        }

        if (empty($rval) && !empty($this->ItemData[ $data ][ "SearchDefault" ]))
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
            $value=$this->MyMod_Search_Field_Method_Call($data,$fixedvalue,$rval);
        }
        elseif ($this->MyMod_Data_Field_Is_Date($data))
        {
            $value=$this->MyMod_Search_Field_Date($data,$rdata,"");
        }
        elseif ($this->MyMod_Data_Field_Is_Time($data))
        {
            $value=$this->MyMod_Search_Field_Time($data,$rdata,$rval);
        }
        elseif ($this->MyMod_Data_Field_Is_Enum($data))
        {
            $value=$this->MyMod_Search_Field_Enum($data,$rdata,$rval);
        }
        elseif ($this->MyMod_Data_Field_Is_Sql($data))
        {
            $value=$this->MyMod_Search_Field_Sql($data,$rdata,$rval);
        }
        else
        {
            $value=$this->MyMod_Search_Field_Default($data,$rdata,$rval);
        }


        return $value;
    }
    
    //*
    //* function MyMod_Search_Field_Method_Call, Parameter list: $data
    //*
    //* Call search field method.
    //*

    function MyMod_Search_Field_Method_Call($data,$fixedvalue,$rval="")
    {
        if ( !empty($this->ItemData[ $var ][ "SearchFieldMethod" ]) )
        {
            $method=$this->ItemData[ $var ][ "SearchFieldMethod" ];

            if (method_exists($this,$method))
            {
                $rval=$this->$method($var,$fixedvalue);
            }
            else
            {
                $this->AddHtmlStatusMessage($this->ModuleName.": Empty SearchFieldMethod");
            }
        }
        else
        {
            $this->AddHtmlStatusMessage($this->ModuleName.": Empty SearchFieldMethod");
        }

        return $rval;
    }
    
    //*
    //* function MyMod_Search_Field_Title, Parameter list: $data
    //*
    //* Creates search var row title cell.
    //*

    function MyMod_Search_Field_Title($data)
    {
        $name=$this->GetRealNameKey($this->ItemData[ $data ],"SearchName");

        if ($name=="")
        {
            $name=$this->GetRealNameKey($this->ItemData[ $data ],"Name");
        }

        return $name;
    }
    
    
    
    //*
    //* function MyMod_Search_Field_Default, Parameter list: $data,$rdata,$rval
    //*
    //* Creates default $data search field.
    //*

    function MyMod_Search_Field_Default($data,$rdata,$rval)
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
           array
           (
               "TITLE" =>
               "Digite uma parte de ".
               $this->GetRealNameKey($this->ItemData[ $data ],"Name"),
           )
        );
    }
    
    //*
    //* function MyMod_Search_Field_Date, Parameter list: $data,$rdata,$rval
    //*
    //* Creates date type search field.
    //*

    function MyMod_Search_Field_Date($data,$rdata,$rval)
    {
        return $this->HtmlDateInputField
        (
           $rdata,
           $rval
        );
    }

    //*
    //* function MyMod_Search_Field_Time, Parameter list: $data,$rdata,$rval
    //*
    //* Creates time type search field.
    //*

    function MyMod_Search_Field_Time($data,$rdata,$rval)
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
    //* function MyMod_Search_Field_Text, Parameter list: $data,$rdata,$rval
    //*
    //* Creates time type search field.
    //*

    function MyMod_Search_Field_Text($data,$rdata,$rval)
    {
        return
            $this->MakeInput
            (
                $this->MyMod_Search_CGI_Text_Name($data),
                $this->MyMod_Search_CGI_Text_Value($data),
                $this->ItemData[ $data ][ "SqlTextSearch" ],
                array
                (
                    "TITLE" => "Digite uma parte de ".$this->ItemData[ $data ][ "Name" ],
                )
            );
    }
    
    //*
    //* function MyMod_Search_Field_Enum, Parameter list: $data,$rdata,$rval
    //*
    //* Creates enum type search field.
    //*

    function MyMod_Search_Field_Enum($data,$rdata,$rval)
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
                $this->MyMod_Search_CGI_Value($this->ItemData[ $data ][ "ValuesDependencyVar" ]);
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

        /* $value=preg_replace */
        /* ( */
        /*    '/NAME=[\'"]'.$data.'(_\d+)?[\'"]/i', */
        /*    "NAME='".$rdata."\\1'", */
        /*    $this->MyMod_Data_Field_Enum_Edit */
        /*    ( */
        /*       $data, */
        /*       $item, */
        /*       $rval, */
        /*       0,//tabindex */
        /*       False, //plural, */
        /*       "", //links */
        /*       0,//callmethod, */
        /*       $data, */
        /*       True */
        /*    ) */
        /* ); */
        $value=
           $this->MyMod_Data_Field_Enum_Edit
           (
              $data,
              $item,
              $rval,
              0,//tabindex
              False, //plural,
              "", //links
              0,//callmethod,
              $rdata,
              True
           );

        //Restore ItemData NoSort
        $this->ItemData[ $data ][ "NoSort" ]=$tmp;

        return $value;
   }

    //*
    //* function MyMod_Search_Field_Sql, Parameter list: $data,$rdata,$rval
    //*
    //* Creates enum type search field.
    //*

    function MyMod_Search_Field_Sql($data,$rdata,$rval)
    {
        return
            $this->MyMod_Data_Fields_Sql_Search_Select($data,$rdata,$rval);
    }
}

?>