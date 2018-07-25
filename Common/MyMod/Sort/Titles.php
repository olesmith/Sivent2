<?php


trait MyMod_Sort_Titles
{
    //*
    //* function MyMod_Sort_Title_Get, Parameter list: $data
    //*
    //* Returns array of sort titles.
    //*

    function MyMod_Sort_Title_Get($data,$options=array(),$latex=FALSE)
    {
        $title=$this->MyMod_Data_Title($data);
        if ($latex)
        {
            return "\\textbf{".$title."}\n";
        }
        
        return $title;
    }
    
    //*
    //* function MyMod_Sort_Title_Cells, Parameter list: $datas,$sortlinks=TRUE,$latex=FALSE
    //*
    //* Returns array of sort titles.
    //*

    function MyMod_Sort_Title_Cells($datas,$sortlinks=TRUE,$latex=FALSE)
    {
        $sort=$this->MyMod_Sort_Get();
        $reverse=$this->MyMod_Sort_Reverse_Get();

        $titles=array();
        for ($n=0;$n<count($datas);$n++)
        {
            if (preg_match('/newline/',$datas[ $n ]))
            {
                break;
            }

            $titles[$n]=$this->MyMod_Sort_Title_Cell($datas[$n],$sortlinks,$latex);
        }

        return $titles;
    }

    //*
    //* function MyMod_Sort_Title_Cell, Parameter list: $data,$sortlinks=TRUE,$latex=FALSE
    //*
    //* Make sort title cell for data $data.
    //*

    function MyMod_Sort_Title_Cell($data,$sortlinks=TRUE,$latex=FALSE)
    {
        $title=$this->MyMod_Sort_Title_Get($data);
        if (
              $data!="No"
              &&
              $this->HashKeySetAndTRUE($this->ItemData,$data)
              &&
              !$this->HashKeySetAndTRUE($this->ItemData[ $data ],"NoSort")
              &&
              $sortlinks
              &&
              !$latex
            )
        {
            $options=array();
            if (!empty($this->ItemData[ $data ]) && !empty($this->ItemData[ $data ][ "Title" ]))
            {
                $rtitle=$this->GetRealNameKey($this->ItemData[ $data ],"Title");
                if (!empty($rtitle))
                {
                    $options[ "TITLE" ]=$rtitle;
                }
            }

            $sort=$this->MyMod_Sort_Get();
            $sorticon="";
            if ($sort!=$data)
            {
                $sorticon=$this->MyMod_Sort_Icon_Unsorted($data);
            }
            else
            {
                if ($this->MyMod_Sort_Reverse_Get()!=1)
                {
                    $sorticon=$this->MyMod_Sort_Icon_Reversed($data);
                }
                else
                {
                    $sorticon=$this->MyMod_Sort_Icon($data);
                }
                
            }
            $title=
                array
                (
                    array($title),
                    $sorticon,
                );
        }

        return $title;
    }

    
}

?>