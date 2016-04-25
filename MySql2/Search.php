<?php



include_once("Paging.php");
include_once("Search/Options.php");
include_once("Search/CGI.php");
include_once("Search/Cookies.php");
include_once("Search/Fields.php");
include_once("Search/Table.php");
include_once("Search/Wheres.php");
include_once("Search/Init.php");
include_once("Search/Vars.php");

class Search extends SearchVars
{

  ###*
  ###* Variables of Search class:

    var $Application="";
    var $SearchVarsTableWritten=FALSE;
    var $ResSearchVars=array();
    var $SearchDataMessages="Search.php";
    var $DefaultSearchData=array
    (
      "SqlMethod"      => "",
      "Method"         => "",
      "SqlTextSearch"  => FALSE,
      "Search_Default"  => "",
      "NoSelectSort"  => FALSE,
      "Compound"  => FALSE,
    );

    //*
    //* function SearchItems, Parameter list: $datas
    //*
    //* Does the actual searching. Will only search over 
    //* non-int (INT/ENUM ) values, as these should
    //* be included by the where clause.
    //*

    function SearchItems($searchvars=array(),$novals=0,$postvars=TRUE)
    {
        if ($postvars && empty($searchvars))
        {
            $searchvars=$this->GetPostSearchVars();
        }

        $ritems=array();
        foreach ($this->ItemHashes as $id => $item)
        {
            $include=1;
            foreach ($searchvars as $data => $value)
            {
                if ($include==0 || empty($value)) { continue; }

                $value=preg_replace('/\//',"\/",$value);
                $value=preg_replace('/_/'," ",$value);
                if (preg_match('/\S/',$value))
                {
                    if ($novals!=0)
                    {
                        $itemvalue=$this->GetEnumValue($data,$item);
                    }
                    else
                    {
                        $itemvalue=$item[ $data ];
                    }

                    if (
                        isset($this->ItemData[ $data ])
                        &&
                        $this->ItemData[ $data ][ "SqlObject" ]
                       )
                    {
                        $value=$this->GetTextSearchVarCGIValue($data);

                        $value=$this->TrimSearchValue($value);
                        if (!$this->MatchSubItemValue($data,$item[ $data ],$value))
                        {
                            $include=0;
                        }
                    }
                    else
                    {
                        $itemvalue=$this->TrimSearchValue($itemvalue);
                        $svalue=$this->TrimSearchValue
                        (
                           //html_entity_decode($value,ENT_COMPAT,'UTF-8')
                           $value
                        );

                        if ($novals!=0)
                        {
                            if (!preg_match('/^'.$svalue.'$/',$itemvalue))
                            {
                                $include=0;
                            }             
                        }
                        elseif (!preg_match('/'.$svalue.'/',$itemvalue))
                        {
                            $include=0;
                        }
                    }
                }
            }

            if ($include==1)
            {
                $ritems[ $id ]=$item;
            }
        }

        $this->ItemHashes=$ritems;
    }

}


?>