<?php

class SearchTable extends SearchFields
{
    var $SearchVarTableModule=FALSE;
    var $ExtraSearchRowsMethod=NULL;
    var $TwoColSearchTable=FALSE;
    var $PostSearchTableText="";

    //*
    //* function GenerateSearchVarsTable, Parameter list: $omitvars=array(),$title="",$action="",$addvars=array(),$fixedvalues=array()
    //*
    //* Creates form search vars table. Returns table as matrix.
    //*

    function GenerateSearchVarsTable($omitvars=array(),$title="",$action="",$addvars=array(),$fixedvalues=array(),$tabmovesdown="",$buttons=array())
    {
        $btitle=$this->GetMessage($this->SearchDataMessages,"SearchButton");
        if ($title=="")
        {
            $language=$this->MyLanguage_GetLanguageKey();

            $acc="ItemsName".$language;
            $title=$btitle." ".$this->$acc;
        }

        $showall=$this->CGI2IncludeAll();


        $omit=join("|",$omitvars);
        $tbl=array();

        foreach (array_keys($this->ItemData) as $var)
        {
            if (!empty($this->ItemData[ $var ][ "Search_Depends" ]))
            {
                $depends=$this->ItemData[ $var ][ "Search_Depends" ];
                if (!empty($this->ItemData[ $depends ]))
                {
                    $dependssearchvalue=$this->GetSearchVarCGIValue($depends);
                    if (empty($dependssearchvalue))
                    {
                        continue;
                    }
                }
            }

            
            //Search may have been disabled, since call to InitSearchVars - so check again
            if (empty($this->ItemData[ $var ][ "Search" ])) { continue; }
            if (!empty($this->ItemData[ $var ][ "NoSearchRow" ]))   { continue; }

            if (!$this->MyMod_Data_Field_Is_Search($var)) { continue; }

            $rvar=$var;
            if ($this->CheckHashKeyValue($this->ItemData[ $var ],"Compound",1))
            {
                $rvar=$this->SearchVars[ $var ][ "Var" ];
            }

            if (!preg_match('/^('.$omit.')$/',$rvar))
            {
                if (
                      $this->MyMod_Data_Access($var)>=1
                      ||
                      $this->CheckHashKeyValue($this->ItemData[ $var ],"Compound",1)
                   )
                {
                    $name=$this->GetSearchVarTitle($var);

                    $method="MakeSearchVarInputField";
                    if ($this->ItemData[ $var ][ "SearchFieldMethod" ]!="")
                    {
                        $method=$this->ItemData[ $var ][ "SearchFieldMethod" ];
                    }

                    //Fixed Value by caller arg  $fixedvalues - our by $this->SqlWhere key
                    $fixedvalue="";
                    if (!empty($fixedvalues[ $var ]))
                    {
                        $fixedvalue=$fixedvalues[ $var ];
                    }
                    if (!empty($this->SqlWhere[ $var ]))
                    {
                        $fixedvalue=$this->SqlWhere[ $var ];
                    }

                    $input=$this->$method($var,$fixedvalue);
                    //if ($showall==2 || !empty($fixedvalue))
                    if (!empty($fixedvalue))
                    {
                        $input=preg_replace('/NAME=/i',"DISABLED='disabled' NAME=",$input);
                    }

                    $row=array
                    (
                       array
                       (
                          "Text" => $name.":",
                          "Class" => 'searchtitle',
                       ),
                    );

                    if (is_array($input))
                    {
                        foreach ($input as $id => $rinput)
                        {
                            array_push($row,$rinput);
                        }
                    }
                    else
                    {
                        array_push($row,$input,"");
                    }

                    array_push($row,"");
                    array_push($tbl,$row);
                }
            }
        }

        if ($this->TwoColSearchTable)
        {
            $rtbl=array();
            while ($row=array_shift($tbl))
            {
                $rrow=array_shift($tbl);
                while (count($row)>2) { array_pop($row); }
                while (count($rrow)>2) { array_pop($rrow); }

                if (is_array($rrow))
                {
                    $row=array_merge($row,$rrow);
                }
                array_push($rtbl,$row);
            }

            $tbl=$rtbl;
        }

        if (!preg_grep('/^OptionFields$/',$omitvars))
        {
            $this->AddSearchOptionFields($omitvars,$tbl);
        }

        foreach ($addvars as $addvar)
        {
            $val=$this->GetPOST($addvar[ "Name" ]);
            if ($val=="" && isset($addvar[ "Default" ])) { $val=$addvar[ "Default" ]; }

            $width=10;
            if (isset($addvar[ "Width" ])) { $width=$addvar[ "Width" ]; }

            if (empty($addvar[ "Hidden" ]))
            {
                array_push
                (
                   $tbl,
                   array
                   (
                      $this->B($addvar[ "Title" ]),
                      $this->MakeInput($addvar[ "Name" ],$val,$width),
                      ""
                   )
                );
            }
            else
            {               
                array_push
                (
                   $tbl,
                   array
                   (
                    $this->MakeHidden($addvar[ "Name" ],$val)
                   )
                );
            }
        }

        if (!empty($this->ExtraSearchRowsMethod))
        {
            $method=$this->ExtraSearchRowsMethod;
            $tbl=array_merge
            (
               $tbl,
               $this->$method()
            );
        }

        array_push
        (
           $tbl,
           array
           (
              $this->B
              (
                 $this->GetMessage($this->SearchDataMessages,"TabMovesDown").":"
              ),
              $this->MultiCell
              (
                 $this->MakeCheckBox
                 (
                    $this->ModuleName."_TabMovesDown",
                    1,
                    $this->GetCGIVarValue($this->ModuleName."_TabMovesDown")
                 ).
                 " ".
                 $this->GetMessage($this->SearchDataMessages,"TabMovesDownText"),
                 3,
                 'left'
               )
           ),
           $this->Html_Input_Button_Make("submit",strtoupper($btitle)).
           join("",$buttons)
        );

        //Title line
        array_unshift
        (
           $tbl,
           array
           (
              $this->Center($this->SPAN
              (
                 $title,
                 array("CLASS" => 'searchtabletitle')
              ))
           )
        );


        return $tbl;
    }

    //*
    //* function SearchPressed, Parameter list: 
    //*
    //* Checks if search form loads for the first time (time to take default)
    //* or if we should obey form values (particular to checkbox'es...)
    //*

    function SearchPressed()
    {
        $searchpressed=$this->GetPOST("SearchPressed");
        if ($searchpressed==1) { $searchpressed=TRUE; }
        else                   { $searchpressed =FALSE; }

        return $searchpressed;
    }

    //*
    //* function SearchVarsTable, Parameter list: $omitvars=array(),$title="",$action="",$addvars=array(),$fixedvalues=array(),$module="",$tabmovesdown=""
    //*
    //* Creates full form search vars table.
    //*

    function SearchVarsTable($omitvars=array(),$title="",$action="",$addvars=array(),$fixedvalues=array(),$module="",$tabmovesdown="",$buttons=array())
    {
        if ($this->SearchVarsTableWritten) { return ""; }

        if (empty($module)) { $module=$this->SearchVarTableModule; }

        if (empty($module)) { $module=$this->ModuleName; }

        if (empty($action))
        {
            $action=$this->GetGETOrPOST("Action");
        }
        if (empty($action)) { $action="Search"; }

        $this->Singular=FALSE;
        $this->Plural=TRUE;
        $this->SearchVarsTableWritten=FALSE;
        $table=$this->GenerateSearchVarsTable($omitvars,$title,$action,$addvars,$fixedvalues,$tabmovesdown,$buttons);
        $this->SearchVarsTableWritten=TRUE;


        return
            $this->StartForm
            (
               "?ModuleName=".$module."&Action=".$action,
               "post",
               0,
               array(),
               array
               (
                  $module."_NItemsPerPage",
                  $module."_Page",
                  $module."_NoPaging",
                  $module."_TabMovesDown",
                  "Page",
               )
            ).
            $this->FrameIt
            (
               $this->Html_Table
               (
                  "",
                  $table,
                  array
                  (
                     "ALIGN" => 'center',
                     "CLASS" => 'searchtable'
                  ),
                  array(),
                  array(),
                  TRUE
               )
            ).
            $this->MakeHidden("SearchPressed",1). //determines if search button has been pressed
            //$this->MakeHidden("Action",$action).

            $this->PostSearchTableText.

            $this->EndForm().
            "";
    }

}


?>