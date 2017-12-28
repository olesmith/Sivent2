<?php


class DataPrintCells extends DataPrintCGI
{
    //*
    //* function IncludeDataField, Parameter list:
    //*
    //* Creates select field for include data
    //*

    function IncludeNColsField()
    {
        return $this->MakeInput
        (
            $this->CGI2NColsKey(),
            $this->ColsDef[ "NCols" ],
            2
        );
    }

    //*
    //* function IncludeDataField, Parameter list: $n
    //*
    //* Creates select field for include data
    //*

    function IncludeDataField($n)
    {
        $titles=array();
        foreach ($this->ColsDef[ "AllowedDatas" ] as $data)
        {
            $titles[ $this->MyMod_Data_Title($data) ]=$data;
        }

        $names=array_keys($titles);
        sort($names);

        $datas=array();
        foreach ($names as $name)
        {
            array_push($datas,$titles[ $name ]);
        }


        $names=array(0);
        $titles=array("");

        foreach ($datas as $data)
        {
            array_push($names,$data);
            array_push($titles,$this->MyMod_Data_Title($data));
        }

        return $this->MakeSelectField
        (
           $this->IncludeDataFieldCGIKey($n),
           $names,
           $titles,
           $this->IncludeDataFieldCGIValue($n)
        );
    }
}

?>