<?php


class HashesData extends Data
{
    //*
    //* function DataHash2ItemData, Parameter list: $itemdata,$n,$basename=""
    //*
    //* Adds itemdata in deffile $file, $n times
    //* as ItemData; keys: $basename.$n.
    //*

    function DataHash2ItemData($itemdata,$n,$basename="")
    {
        for ($i=1;$i<=$n;$i++)
        {
            $ritemdatas=array();
            foreach ($itemdata as $data => $datadef)
            {
                $key=$basename.$data.$i;

                $this->ItemData[ $key ]=$datadef;
                foreach ($this->ItemData[ $key ] as $id => $entry)
                {
                    if (!is_array($entry))
                    {
                        $this->ItemData[ $key ][ $id ]=preg_replace('/#Number/',$i,$entry);
                    }
                }

                if (
                      isset($this->ItemData[ $key ][ "Values" ])
                      &&
                      is_string($this->ItemData[ $key ][ "Values" ])
                   )
                {
                    $accessor=$this->ItemData[ $key ][ "Values" ];
                    $this->ItemData[ $key ][ "Values" ]=$this->$accessor;
                }
            }
        }

        //Search vars
        foreach ($itemdata as $data => $datadef)
        {
            if ($this->CheckHashKeyValue($itemdata[ $data ],"CompSearch",1))
            {
                //$this->MaxLessonsPerWeek erroneous
                $this->CreateDataHash2SearchVar($data,$this->MaxLessonsPerWeek);
            }
        }
    }

    //*
    //* function HashData2GroupDef, Parameter list: $itemdata,$n,&$groupdef,$countfield="",$basename=""
    //*
    //* Adds itemdata in deffile $file, $n times
    //* as ItemData; keys: $basename.$n.
    //*

    function HashData2GroupDef($itemdata,$n,&$groupdef,$countfield="",$basename="")
    {
        $nempties=count($groupdef[ "Data" ]);
        for ($i=1;$i<=$n;$i++)
        {
            $ritemdatas=array();
            foreach ($itemdata as $data => $datadef)
            {
                array_push($groupdef[ "Data" ],$basename.$data.$i);
            }

            if ($i<$n)
            {
                $newline="newline(".$nempties.")";
                if ($countfield!="")
                {
                    $newline.="(".$countfield.")";
                }

                array_push($groupdef[ "Data" ],$newline);
            }
        }
    }


    //*
    //* function CreateDataHash2SearchVar, Parameter list: $itemdata,$key,$n,$basename=""
    //*
    //* Adds common search var entry for key $key.
    //*

    function CreateDataHash2SearchVar($key,$n,$basename="")
    {
        $this->ItemData[ $basename.$key."1" ][ "Search" ]=1;
        $this->ItemData[ $basename.$key."1" ][ "Compound" ]=1;
        $this->ItemData[ $basename.$key."1" ][ "NVars" ]=$n;
        $this->ItemData[ $basename.$key."1" ][ "Var" ]=$basename.$key;
    }


    //*
    //* function DataHash2ItemData, Parameter list: $itemdata,$n,$basename=""
    //*
    //* Adds itemdata in deffile $file, $n times
    //* as ItemData; keys: $basename.$n.
    //*

    function DataHash2ItemData2($itemdata,$n,$m,$varsn,$varsm,$basename="",$uscore=TRUE)
    {
        for ($i=1;$i<=$n;$i++)
        {
            for ($j=1;$j<=$m;$j++)
            {
                foreach ($itemdata as $data => $datadef)
                {
                    $key="";
                    if ($uscore)
                    {
                        $key=$basename.$data."_".$i."_".$j;
                    }
                    else
                    {
                        $key=$basename.$data.$i."_".$j;
                    }

                    $this->ItemData[ $key ]=$datadef;
                    foreach ($this->ItemData[ $key ] as $id => $entry)
                    {
                        if (!is_array($entry))
                        {
                            $this->ItemData[ $key ][ $id ]=preg_replace('/#Number\b/',$varsn[ $i-1 ],$entry);
                            $this->ItemData[ $key ][ $id ]=preg_replace('/#Mumber\b/',$varsm[ $j-1 ],$this->ItemData[ $key ][ $id ]);
                         }
                    }
                }
            }
        }
    }


}

?>