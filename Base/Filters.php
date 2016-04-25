<?php



class Filters extends Time
{
    //*
    //* Filter item values in $item or $this->ItemHash.
    //*

    function Filter($lines,$item=array())
    {
        if (count($item)==0 && isset($this->ItemHash)) { $item=$this->ItemHash; }

        $datas=array();
        if (is_array($item)) { $datas=array_keys($item); }
        sort($datas);
        $datas=array_reverse($datas);

        foreach ($datas as $data)
        {
            if (is_string($item[ $data ]))
            {
                $item[ $data ]=preg_replace("/\\\\\\\\/","%%newline%%",$item[ $data ]);

                $lines=preg_replace("/#$data\b/",$item[ $data ],$lines);
                //$lines=preg_replace('/%%newline%%/',"\\\\",$lines);
                while (preg_match("/#{([^}]+)}$data/",$lines,$matches))
                {
                    $format=$matches[1];
                    $value=sprintf($format,$item[ $data ]);

                    $format=preg_replace('/%/',"\\%",$format);
                    $lines=preg_replace('/'.$matches[0].'/',$value,$lines);
                }
                $lines=preg_replace('/%%newline%%/',"\\\\\\\\",$lines);
            }
        }

        return $lines;
    }

    //*
    //* Filter item values in $item or $this->ItemHash.
    //*

    function FilterFileContents($file,$item=array())
    {
        $lines=$this->MyReadFile($file);
        return join("",$this->Filter($lines,$item));
    }

    //*
    //* FilterObject object values in $this.
    //*

    function FilterObject($lines)
    {
        //We must put longest keys first, in order to filter f.inst.
        //#UnitName before #Unit. To achieve this, find
        //the keys, sort and reverse.
        $keys=array();
        foreach ($this as $data => $value)
        {
            array_push($keys,$data);
        }

        sort($keys);
        $keys=array_reverse($keys);

        $vals=preg_grep('/Unit/',$keys);
        foreach ($keys as $data)
        {
            if (is_string($this->$data))
            {
                $lines=preg_replace("/#$data\b/",$this->$data,$lines);
            }
        }

        return $lines;
    }

    //*
    //* FilterHashKeys object values in $this.
    //*

    function FilterHashKeys($hash,$filter)
    {
        foreach (array_keys($hash) as $id => $data)
        {
            if (
                  isset($hash[ $data ]) && 
                  !is_array($hash[ $data ])
                )
            {
                $hash[ $data ]=$this->Filter($hash[ $data ],$filter);
            }
        }

        return $hash;
    }

    //*
    //* Filter $lines according to $hash. Pre adds $key.
    //*

    function FilterHash($lines,$hash,$prekey="")
    {
        $datas=array();
        if ($hash) { $datas=array_keys($hash); }

        //this way shortest filtered first (#Line before #Lines)
        sort($datas);

        $datas=array_reverse($datas);
        foreach ($datas as $data)
        {
            $value=$hash[ $data ];
            $rdata=$prekey.$data;

            if (!is_array($value))
            {
                $lines=preg_replace("/#$rdata\b/",$value,$lines);
                while (preg_match("/#{([^}]+)}$rdata/",$lines,$matches))
                {
                    $format=$matches[1];
                    $value=sprintf($format,$value);

                    $format=preg_replace('/%/',"\\%",$format);
                    $lines=preg_replace('/'.$matches[0].'/',$value,$lines);
                }
            }
        }

        return $lines;
    }

    //*
    //* Filter lines according to $hash.
    //*

    function FilterHashes($lines,$hashes,$filterobj=FALSE)
    {
        foreach ($hashes as $hash)
        {
            $lines=$this->FilterHash($lines,$hash);
        }

        if ($filterobj)
        {
            $obj=$this;
            if (is_object($filterobj)) { $obj=$filterobj; }

            $lines=$this->FilterObject($lines,$obj);
        }

        return $lines;
    }

}
?>