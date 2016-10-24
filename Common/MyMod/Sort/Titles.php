<?php


trait MyMod_Sort_Titles
{
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
        $args=$this->Query2Hash();

        $title=$this->GetDataTitle($data);

        $title=preg_replace('/#ItemName/',$this->MyMod_ItemName(),$title);
        $title=preg_replace('/#ItemsName/',$this->MyMod_ItemName("ItemsName"),$title);

        $options=array();
        if (!empty($this->ItemData[ $data ][ "Title" ]))
        {
            $options[ "TITLE" ]=$title;
        }

        $title=$this->MyMod_Sort_Title_Get($title,$options,$latex);

        if (
              $data=="No"
              ||
              !$this->HashKeySetAndTRUE($this->ItemData,$data)
              ||
              $this->HashKeySetAndTRUE($this->ItemData[ $data ],"NoSort")
            )
        {
            return $title;
        }

        $sort=$this->MyMod_Sort_Get();
        if (!$sortlinks || $latex) {}
        elseif ($sort!=$data)
        {
            $args[ $this->ModuleName."_Sort" ]=$data;

            $img=$this->IMG
            (
               $this->Icons."/nosort.png",
               $this->Language_Message("Reverse"),
               0,0,
               array
               (
                  "CLASS" => 'datatitleimg'
               )
            )."\n";
            $stitle=
                $this->Language_Message("OrderBy").
                " ".
                $this->GetRealNameKey($this->ItemData[ $data ]);

            $query="?".$this->Hash2Query($args);

            $title.=" ".$this->Href($query,$img,$stitle,"",'datatitleimg');
        }
        else
        {
            $args[ $this->ModuleName."_Sort" ]=$sort;

            $text="Normal";
            if ($this->MyMod_Sort_Reverse_Get()==1)
            {
                $args[ $this->ModuleName."_Reverse" ]=0;
                $img="/sortup.png";
            }
            else
            {
                $args[ $this->ModuleName."_Reverse" ]=1;
                $img="/sortdown.png";
                $text="Reversa";                  
            }

            $img=$this->IMG
            (
               $this->Icons.$img,
               "Reversar",
               0,0,
               array
               (
                  "CLASS" => 'datatitlelink'
               )
            )."\n";
            $query="?".$this->Hash2Query($args);
            $title.=$this->Href($query,$img,"Colocar em Ordem ".$text,"12",'datatitleimg');

            unset($args[ $this->ModuleName."_Reverse" ]);
        }

        return $title;
    }

    //*
    //* function MyMod_Sort_Title_Get, Parameter list: $title,$options=array(),$latex=FALSE
    //*
    //* Returns sort title, as SPAN element. $opt's are added as options.
    //* If latex is on, simply bold faces.
    //*

    function MyMod_Sort_Title_Get($title,$options=array(),$latex=FALSE)
    {
        if ($latex)
        {
            return "\\textbf{".$title."}\n";
        }
        else
        {
            if (!is_array($options))
            {
                $options=$this->Options2Hash($options);
            }

            $options[ "CLASS" ]='datatitlelink';
            return $this->HtmlTags("SPAN",$title,$options)."\n";
        }
    }
    
}

?>