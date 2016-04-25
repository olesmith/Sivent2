<?php

trait Accessor
{
    var $Accessor_N=0;

    //*
    //* sub Accessor_Key, Parameter list: $accessor,$key=""
    //*
    //* Returns $key in $this->$accessor hash.
    //*
    //*

    function Accessor_Key($accessor,$key="")
    {
        if (isset($this->$accessor))
        {
            $value=$this->$accessor;
            if (empty($key))
            {
                return $value;
            }
            else
            {
                if (isset($value[ $key ]))
                {
                    return $value[ $key ];
                }
            }
        }

        return NULL;
    }

    //*
    //* sub Accessor_Key_Set, Parameter list: $accessor,$key,$value
    //*
    //* Sets $key in $this->$accessor hash.
    //*
    //*

    function Accessor_Key_Set($accessor,$key,$value="")
    {
        if (empty($value) && is_array($key))
        {
            $this->$accessor=$key;
        }
        elseif (!empty($key))
        {
            return $this->$accessor[ $key ]=$value;
        }

        return $this->Accessor_Key_Get($accessor,$key);
    }

    //*
    //* sub Accessors_Item, Parameter list: $accessor,$id=0,$key=""
    //*
    //* Tries to return something sensible in $this->$accessor hash,
    //* according to $id, $key and $value..
    //*
    //*

    function Accessors_Item($accessor,$id=0,$key="")
    {
        //No parms given, return full list.
        if (empty($id) && empty($key)) { return $this->$accessor; }

        foreach ($this->$accessor as $rid => $item)
        {
            //Item found
            if ($id==$item[ "ID" ])
            {
                //Empty $key, return full item.
                if (empty($key))
                {
                    return $item;
                }
                else
                {
                    return $this->MyHash_Key($item,$key);
                }
            }
        }

        return NULL;
    }
}

?>