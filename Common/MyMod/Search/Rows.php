<?php


trait MyMod_Search_Rows
{
    //*
    //* function MyMod_Search_Row_Generate, Parameter list: $omitvars=array(),$title="",$action="",$addvars=array(),$fixedvalues=array()
    //*
    //* Creates form search vars table row as array.
    //*

    function MyMod_Search_Row_Generate($data,$fixedvalues,$rval="")
    {
        $input=$this->MyMod_Search_Field_Make($data,$fixedvalues,$rval="");

        $row=
            array
            (
                array
                (
                          "Text" => $this->MyMod_Search_Field_Title($data).":",
                          "Class" => 'searchtitle',
                ),
            );

        if (!is_array($input))
        {
            $input=array($input);
        }

        $row=
            array_merge
            (
                $row,
                $input
            );

        return $row;
    }

    
    //*
    //* function MyMod_Search_Rows_Generate, Parameter list: $omitvars=array(),$title="",$action="",$addvars=array(),$fixedvalues=array()
    //*
    //* Creates form search vars table rows as matrix.
    //*

    function MyMod_Search_Rows_Generate($data,$fixedvalues,$omitvars,$rval="")
    {
        /* if (!empty($this->ItemData[ $data ][ "Search_Depends" ])) */
        /* { */
        /*     $depends=$this->ItemData[ $data ][ "Search_Depends" ]; */
        /*     if (!empty($this->ItemData[ $depends ])) */
        /*     { */
        /*         $dependssearchvalue=$this->GetSearchVarCGIValue($depends); */
        /*         if (empty($dependssearchvalue)) */
        /*         { */
        /*             continue; */
        /*         } */
        /*     } */
        /* } */

            
        //Search may have been disabled, since call to InitSearchVars - so check again
        $rows=array();
        if (empty($this->ItemData[ $data ][ "Search" ])) { return $rows; }
        if (!empty($this->ItemData[ $data ][ "NoSearchRow" ]))   { return $rows; }

        if (!$this->MyMod_Data_Field_Is_Search($data)) { return $rows; }

        $rvar=$data;
        if ($this->CheckHashKeyValue($this->ItemData[ $data ],"Compound",1))
        {
            $rvar=$this->SearchVars[ $data ][ "Var" ];
        }

        $rows=array();
        if (!preg_match('/^('. join("|",$omitvars)  .')$/',$rvar))
        {
            if (
                  $this->MyMod_Data_Access($data)>=1
                  ||
                  $this->CheckHashKeyValue($this->ItemData[ $data ],"Compound",1)
                )
            {
                array_push
                (
                    $rows,
                    $this->MyMod_Search_Row_Generate($data,$fixedvalues,$rval="")
                );
            }
        }
        

        return $rows;
    }

    
}

?>