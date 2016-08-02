<?php

class SearchCGI extends SearchOptions
{

    //*
    //* function GetSearchVarCGIName, Parameter list: $data
    //*
    //* Returns the name of the CGI search var associated with $data.
    //*

    function GetSearchVarCGIName($data)
    {
        return $this->Application.$this->ModuleName."_".$data."_Search";
    }

    //*
    //* function GetTextSearchVarCGIName, Parameter list: $data
    //*
    //* Returns the name of the CGI TEXT search var associated with $data.
    //* This valid, only for SQL search fields, with SqlTextSearch set
    //* (in ItemData[ $data ])
    //*

    function GetTextSearchVarCGIName($data)
    {
        return $this->Application.$this->ModuleName."_".$data."_Search_Text";
    }

    //*
    //* function GetSearchVarCGIValue, Parameter list: $data,$rdata=""
    //*
    //* Returns the value of the CGI search var associated with $data.
    //*

    function GetSearchVarCGIValue($data,$rdata="")
    {
        if (empty($rdata))
        {
            $rdata=$this->GetSearchVarCGIName($data);
        }

        $value=$this->GetPOST($data);
        if ($value=="")
        {
            $value=$this->GetGETOrPOST($rdata);
        }

        $cvalue=$this->GetCookie($rdata);
        if ($value=="")
        {
            if ($data=="ID")
            {
                $value=$this->GetCGIVarValue("ID");
            }

            if (!empty($this->ItemData[ $data ][ "GETSearchVarName" ]))
            {
                $value=$this->GetGET($this->ItemData[ $data ][ "GETSearchVarName" ]);
            }
        }

        if ($value=="")
        {
            $value=$cvalue;
        }

        if (
              !empty($this->ItemData[ $data ][ "SearchCheckBox" ])
              &&
              $this->CheckHashKeyValue($this->ItemData[ $data ],"SearchCheckBox",1)
           )
        {
            //From GET
            $getvalue=$this->GetGET($rdata);
            if (!empty($getvalue)) { return array($getvalue); }

            $cgikeys=array();
            for ($i=0;$i<count($this->ItemData[ $data ][ "Values" ]);$i++)
            {
                array_push($cgikeys,$rdata."_".($i+1));
            }

            $values=array();
            foreach ($cgikeys as $no => $cgikey)
            {
                $rcgikey="";
                if (preg_match('/(\d)+$/',$cgikey,$matches))
                {
                    $rcgikey=$matches[1];
                }

                if ($rcgikey!="" && $this->GetPOST($cgikey)==$rcgikey)
                {
                    array_push($values,$rcgikey);
                }
            }

            if (empty($values) && !empty($this->ItemData[ $data ][ "SearchDefault" ]))
            {
                $values=array($this->ItemData[ $data ][ "SearchDefault" ]);
            }

            return $values;
        }
        elseif (
                  !empty($this->ItemData[ $data ])
                  &&
                  $this->CheckHashKeyValue($this->ItemData[ $data ],"IsDate",TRUE)
               )
        {
            if (empty($value) && !empty($this->ItemData[ $data ][ "SearchDefault" ]))
            {
                //take default
                //$value=$this->ItemData[ $data ][ "SearchDefault" ];
            }
            else
            {
                $value=$this->HtmlDateInputValue($data,TRUE,FALSE);
            }

            return $value;
        }

        if (
              empty($value)
              &&
              empty($this->ItemData[ $data ][ "SearchCheckBox" ])
              &&
              preg_match('/^0?$/',$value)
              &&
              $this->CheckHashKeySet($this->ItemData[ $data ],"SearchDefault")
           )
        {
            $value=$this->ItemData[ $data ][ "SearchDefault" ];
        }

        if (preg_match('/_/',$value))
        {
            $value=preg_replace('/_/'," ",$value);
        }

        return $value;
    }

    //*
    //* function GetTextSearchVarCGIValue, Parameter list: $data
    //*
    //* Returns the value of the CGI TEXT search var associated with $data.
    //* This valid, only for SQL search fields, with SqlTextSearch set
    //* (in ItemData[ $data ])
    //*

    function GetTextSearchVarCGIValue($data)
    {
        $rdata=$this->GetSearchVarCGIName($data);
        $rrdata=$this->GetTextSearchVarCGIName($data);

        $value=$this->GetCGIVarValue($rdata);
        $rvalue=$this->GetCGIVarValue($rrdata);

        if ($value!="" && $value!=0)
        {
            $rvalue="";
        }

        return $rvalue;
    }

    //*
    //* function TrimSearchValue, Parameter list: $value
    //*
    //* Trims the search value read, that is:
    //*
    //* Removes accented characters
    //* Convert all to lowercase.
    //*

    function TrimSearchValue($value)
    {
        $value=html_entity_decode($value,ENT_COMPAT,'UTF-8');
        $value=$this->Text2Sort($value);
        $value=strtolower($value);

        $value=preg_replace('/[^\.]?\*/',".*",$value);
        return $value;
    }

    //*
    //* function SearchVarsAsHiddens, Parameter list: 
    //*
    //* Creates hiddens according to search vars defined.
    //*

    function SearchVarsAsHiddens()
    {
        $hiddens=array();
        foreach ($this->MyMod_Items_Search_Vars() as $data)
        {
            if ($this->MyMod_Data_Access($data)>=1)
            {
                $rdata=$this->GetSearchVarCGIName($data);
                $value=$this->GetSearchVarCGIValue($data);

                if ($value!="" && !is_array($value) && !preg_match('/^0$/',$value))
                {
                    array_push($hiddens,$this->MakeHidden($rdata,$value));
                }
            }
        }

        array_push
        (
           $hiddens,
           $this->MakeHidden
           (
              $this->CGI2IncludeAllKey(),
              $this->CGI2IncludeAll()
           )
        );
        

        return $hiddens;
    }
    //*
    //* function SearchVarsAsHash, Parameter list: $hash=array()
    //*
    //* Creates hash according to search vars defined.
    //*

    function SearchVarsAsHash($hash=array())
    {
        foreach ($this->MyMod_Items_Search_Vars() as $data)
        {
            if ($this->MyMod_Data_Access($data)>=1)
            {
                $rdata=$this->GetSearchVarCGIName($data);
                $value=$this->GetSearchVarCGIValue($data);
                if (is_array($value) && count($value)>0) { $value=$value[0]; }

                $value=preg_replace('/^\s+/',"",$value);
                $value=preg_replace('/\s+$/',"",$value);
                
                if (!empty($value) && !is_array($value) && !preg_match('/^0$/',$value))
                {
                    //Handle spaces in search strings
                    if (preg_match('/ /',$value))
                    {
                        $value=preg_replace('/ /',"_",$value);
                    }

                    $hash[ $rdata ]=$value;
                }
            }
        }

        return $hash;
    }

    //*
    //* function SearchVarsURL, Parameter list: 
    //*
    //* Creates URL according to search vars defined.
    //*

    function SearchVarsAsURL()
    {
        $hiddens=array();
        foreach ($this->MyMod_Items_Search_Vars() as $data)
        {
            if ($this->MyMod_Data_Access($data)>=1)
            {
                $rdata=$this->GetSearchVarCGIName($data);
                $value=$this->GetSearchVarCGIValue($data);

                if ($value!="" && (!preg_match('/^0$/',$value)))
                {
                    array_push($hiddens,$rdata."=".$value);
                }
            }
        }

        return join("&",$hiddens);
    }

    //*
    //* function CGI2IncludeAllKey, Parameter list:
    //*
    //* Retrieves CGI POST value of $this->ModuleName."_IncludeAll",
    //* setting on as default.
    //*

    function CGI2IncludeAllKey()
    {
        return $this->ModuleName."_IncludeAll";
    }

    
    //*
    //* function CGI2IncludeAllDefault, Parameter list:
    //*
    //* Returns IncludeAll default value.
    //*

    function CGI2IncludeAllDefault()
    {
        $default=1;
        if ($this->IncludeAllDefault) { $default=2; }

        if (empty($_POST[ "SearchPressed" ]) && $this->IncludeAll) { $default=2; }
        
        return $default;
    }

    
    //*
    //* function CGI2IncludeAll, Parameter list:
    //*
    //* Retrieves CGI POST value of $this->ModuleName."_IncludeAll",
    //* setting on as default.
    //*

    function CGI2IncludeAll()
    {
        $val=$this->CGI_GETOrPOSTint($this->CGI2IncludeAllKey());
        if (empty($val)) { $val=$this->CGI2IncludeAllDefault(); }

        return $val;
    }

    //*
    //* function CGI2Edit, Parameter list:
    //*
    //* Retrieves CGI POST value of $this->ModuleName."_IncludeAll",
    //* setting on as default.
    //*

    function CGI2Edit()
    {
        $val=$this->GetCGIVarValue($this->ModuleName."_Edit");

        $default=1;
        if ($val=="") { $val=$default; }

        return $val;
    }


}


?>