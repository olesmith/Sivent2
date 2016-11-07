<?php


trait MyMod_Data_Fields_Access
{
    //*
    //* function MyMod_Data_Access, Parameter list: $data,$item=array()
    //*
    //* Generates data field.
    //*

    function MyMod_Data_Access($data,$item=array())
    {
        $itemdata=$this->ItemData($data);
        if (empty($itemdata)) { return 0; }

        $lres=$this->GetHashKeyValue($this->ItemData[ $data ],$this->LoginType());
        $pres=$this->GetHashKeyValue($this->ItemData[ $data ],$this->Profile());

        $res=$this->Max($lres,$pres);

        if ($res==2)
        {
            if ($this->ReadOnly) 
            {
                $res=1;
            }
            elseif (!empty($this->ItemData[ $data ][ "ReadOnly" ]))
            {
                $res=1;
            }
            elseif (!empty($this->ItemData[ $data ][ $this->LoginType."ReadOnly" ]))
            {
                $res=1;
            }
            elseif (!empty($item[ $data."_ReadOnly" ]))
            {
                $res=1;
            }
        }

        if (!empty($itemdata[ "PermsMethod" ]))
        {
            $method=$itemdata[ "PermsMethod" ];
            return $this->$method($data,$item);
        }
        

        return $res;
    }
}

?>