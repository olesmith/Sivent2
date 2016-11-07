<?php


trait MyMod_Sort_Items
{
    //*
    //*
    //* function MyMod_Sort_Items, Parameter list: $sort="",$reverse=""
    //*
    //* Do actual sorting on items in $this->ItemHashes.
    //*

    function MyMod_Sort_Items($sort="",$reverse="")
    {
        if ($sort=="") { $sort=$this->MyMod_Sort_Get(); }
        if ($reverse=="") { $reverse=$this->MyMod_Sort_Reverse_Get($reverse); }

        if (!is_array($sort))
        {
            $sort=preg_split('/\s*,\s*/',$sort);
        }

        array_push($sort,"ID"); //ID makes sort fields unique!

        $hashes=array();
        foreach ($this->ItemHashes as $n => $hash)
        {
            $value="";
            foreach ($sort as $iid => $key)
            {
                if (!isset($this->ItemData[ $key ]))
                {
                    if (!empty($hash[ $key ]))
                    {
                        $value.=" ".$hash[ $key ]; 
                    }
                    continue;
                }

                $rvalue="";
                if (!empty($hash[ $key ])) { $rvalue=$hash[ $key ]; }

                if (isset($this->ItemData[ $key ][ "SqlObject" ]))
                {
                    $object=$this->ItemData[ $key ][ "SqlObject" ];
                    $rvalue=$this->ApplicationObj->$object->GetItemName($rvalue);
                }

                if (
                    isset($this->ItemData[ $key ][ "NumericalSort" ])
                    &&
                    $this->ItemData[ $key ][ "NumericalSort" ]==TRUE)
                {
                    if (
                        isset($this->ItemData[ $key ][ "SortReverse" ])
                        &&
                        $this->ItemData[ $key ][ "SortReverse" ]==TRUE
                       )
                    {
                        $rvalue=sprintf("%06d",100000-$hash[ $key ]);
                    }
                    else
                    {
                        $rvalue=sprintf("%06d",$hash[ $key ]);
                    }
                }
                elseif (isset($this->ItemData[ $key ][ "SqlTable" ]))
                {
                    $rvalue=$this->GetEnumValue($key,$hash);
                }
                elseif ($this->ItemData[ $key ][ "Sql" ]=="INT")
                {
                    $rvalue=sprintf("%06d",$rvalue);
                }
                elseif (!empty($this->ItemData[ $key ][ "DerivedFilter" ]))
                {
                    $rvalue=$this->FilterHash($this->ItemData[ $key ][ "DerivedFilter" ],$hash);
                }
                elseif (!empty($this->ItemData[ $key ][ "DerivedNamer" ]))
                {
                    $rvalue=$hash[ $this->ItemData[ $key ][ "DerivedNamer" ] ];
                }
                elseif (!empty($this->ItemData[ $key ][ "SortAsDate" ]))
                {
                    $rvalue=$this->Date2Sort($hash[ $key ]);
                }

                if ($rvalue!="") { $value.=" ".$rvalue; }
            }

            $value=preg_replace('/^\s*/',"",$value);
            $value=preg_replace('/\s*$/',"",$value);

            $value=$this->Text2Sort($value);
            $value=$this->Html2Sort($value);

            //Make sure two items do not have same sort key
            while (isset($hashes[ $value ]))
            {
                $value.="a";
            }

            $value=strtolower($value);
            $hashes[ $value ]=$hash;
        }

        $this->ItemHashes=array();

        $keys=array_keys($hashes);
        sort($keys);
        if ($reverse) { $keys=array_reverse($keys); }

        foreach ($keys as $rkey)
        {
            array_push($this->ItemHashes,$hashes[ $rkey ]);
        }

        //return $this->ItemHashes;
    }

}

?>