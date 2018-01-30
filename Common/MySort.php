<?php

trait MySort
{
    function Sort_List($list,$sorts=array(),$reverse=FALSE)
    {
        if (empty($list)) { return array(); }
        
        if (!is_array($sorts) || empty($sorts))
        {
            $sorts=preg_split('/\s*,\s*/',$sorts);
        }

        $rlist=array();
        foreach ($list as $n => $hash)
        {
            $value="";
            foreach ($sorts as $key)
            {
                $rvalue=$hash[ $key ];
                if ($rvalue!="") { $value.=" ".$rvalue; }
            }

            $value=preg_replace('/^\s*/',"",$value);
            $value=preg_replace('/\s*$/',"",$value);

            $value=$this->Text2Sort($value);
            $value=$this->Html2Sort($value);

            //Make sure two items do not have same sort key
            while (isset($rlist[ $value ]))
            {
                $value.="a";
            }

            $value=strtolower($value);
            $rlist[ $value ]=$hash;
        }

        $keys=array_keys($rlist);

        sort($keys);
        if ($reverse || $reverse==1) { $keys=array_reverse($keys); }

        $list=array();
        foreach ($keys as $rkey)
        {
            array_push($list,$rlist[ $rkey ]);
        }


        return $list;
    }
    
    //*
    //* function Sort_List_ByKey, Parameter list: $list,$key
    //*
    //* Returns list sorted by $key.
    //*

    function Sort_List_ByKey($list,$key)
    {
        $rlist=array();
        foreach (array_keys($list) as $id)
        {
            $value=$list[ $id ][ $key ];

            $value=$this->Html2Sort($value);
            $value=strtolower($value);
            while (isset($rlist[ $value ])) { $value.="0"; }

            $rlist[ $value ]=$list[ $id ];
        }

        $values=array_keys($rlist);
        sort($values);

        $list=array();
        foreach ($values as $value)
        {
            array_push($list,$rlist[ $value ]);
        }
         
        return $list;
    }
}

?>