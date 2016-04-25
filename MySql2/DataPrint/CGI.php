<?php


class DataPrintCGI extends Access
{
    //*
    //* function CGI2NColsKey, Parameter list: 
    //*
    //* Returns CGI key to number of include data fields.
    //*

    function CGI2NColsKey()
    {
        return $this->ColsDef[ "CGIPre" ]."NCols";
    }

     //*
    //* function IncludeDataFieldCGIKey, Parameter list: $n
    //*
    //* Returns name of include field corresponding to $data
    //*

    function IncludeDataFieldCGIKey($n)
    {
        return $this->ColsDef[ "CGIPre" ]."Col_".$n;
    }

    //*
    //* function CGI2NColsValue, Parameter list: 
    //*
    //* Reads and updates $this->NCols, if set by CGI.
    //*

    function CGI2NColsValue()
    {
        $key=$this->CGI2NColsKey();
        if (!empty($_POST[ $key ]))
        {
            $this->ColsDef[ "NCols" ]=$this->GetPOST($key);
        }

        return $this->ColsDef[ "NCols" ];
    }

    //*
    //* function IncludeDataFieldCGIValue, Parameter list: $n
    //*
    //* Returns value of include field corrseponding to $data
    //*

    function IncludeDataFieldCGIValue($n)
    {
        $field=$this->IncludeDataFieldCGIKey($n);
        $value=$this->GetPOST($field);

        if (empty($value) && !empty($this->ColsDef[ "DefaultCols" ][ $n ]))
        {
            $value=$this->ColsDef[ "DefaultCols" ][ $n ];
        }

        return $value;
    }

    //*
    //* function CGI2ColDatas, Parameter list:
    //*
    //* Detects lists of data to include (columns) from CGI. Stores in $this->ColDatas.
    //*

    function CGI2ColDatas()
    {
        $this->ColsDef[ "ColDatas" ]=array();
        for ($n=0;$n<$this->ColsDef[ "NCols" ];$n++)
        {
            if ($value=$this->IncludeDataFieldCGIValue($n))
            {
                array_push($this->ColsDef[ "ColDatas" ],$value);
            }
        }

        return $this->ColsDef[ "ColDatas" ];
    }
}

?>