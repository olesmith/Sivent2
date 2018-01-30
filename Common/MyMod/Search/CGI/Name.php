<?php


trait MyMod_Search_CGI_Name
{
    //*
    //* function MyMod_Search_CGI_Name, Parameter list: $data
    //*
    //* Returns the name of the CGI search var associated with $data.
    //*

    function MyMod_Search_CGI_Name($data)
    {
        return
            $this->Application.$this->ModuleName."_".$data."_Search";
    }

    
//*
    //* function MyMod_Search_CGI_Value, Parameter list: $data,$rdata=""
    //*
    //* Returns the value of the CGI search var associated with $data.
    //*

    function MyMod_Search_CGI_Value($data,$rdata="")
    {
        if (empty($rdata))
        {
            $rdata=$this->MyMod_Search_CGI_Name($data);
        }

        $value=$this->CGI_POST($data);
        if ($value=="")
        {
            $value=$this->CGI_GETOrPOST($rdata);
        }

        $cvalue=$this->GetCookie($rdata);
        if ($value=="")
        {
            if ($data=="ID")
            {
                $value=$this->CGI_VarValue("ID");
            }

            if (!empty($this->ItemData[ $data ][ "GETSearchVarName" ]))
            {
                $value=$this->CGI_GET($this->ItemData[ $data ][ "GETSearchVarName" ]);
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
            $getvalue=$this->CGI_GET($rdata);
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

                if ($rcgikey!="" && $this->CGI_POST($cgikey)==$rcgikey)
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

        $this->ItemData();
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
}

?>