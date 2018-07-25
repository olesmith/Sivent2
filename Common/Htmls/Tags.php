<?php


trait Htmls_Tags
{
    //*
    //* sub Html_Tag_Tag_Start, Parameter list: $tag,$html=array(),$options=array()
    //*
    //* Adds list of subtags to $html;
    //*
    //*

    function Htmls_Tag_Start($tag,$html=array(),$options=array())
    {
        $starttag=array($this->Html_Tag_Start($tag,$options));
        if (empty($html)) { return $starttag; }
        
        if (!is_array($html)) { $html=array(array($html)); }
        
        return array_merge($starttag,$html);
    }
    
    //*
    //* sub Htmls_Tag_Close, Parameter list: $tag
    //*
    //* Closing html tag.
    //*
    //*

    function Htmls_Tag_Close($tag)
    {
        return
            array
            (
                $this->Html_Tag_Close($tag)
            );
    }
    
    //*
    //* sub Htmls_Tag, Parameter list: $tag,$html=array(),$options=array()
    //*
    //* Adds list of subtags to $html;
    //*
    //*

    function Htmls_Tag($tag,$html=array(),$options=array())
    {
        return
            array_merge
            (
                $this->Htmls_Tag_Start($tag,$html,$options),
                $this->Htmls_Tag_Close($tag)
            );
    }
    
    //*
    //* sub Htmls_Tag_List, Parameter list: $tag,$htmls=array(),$options=array()
    //*
    //* Adds tag to list of $htmls.
    //*
    //*

    function Htmls_Tag_List($tag,$htmls=array(),$options=array())
    {
        foreach (array_keys($htmls) as $id)
        {
            $htmls[ $id ]=$this->Htmls_Tag($tag,array($htmls[ $id ]),$options);
        }

        return $htmls;
    }


    //*
    //* sub Htmls_HR, Parameter list: $width,$options=array()
    //*
    //* Html HR as list html.
    //*
    //*

    function Htmls_HR($width,$options=array())
    {
        return
            $this->Htmls_Tag_Start
            (
                "HR",
                array(),
                array_merge
                (
                    $options,
                    array("WIDTH" => $width)
                )
            );
    }
    
    //*
    //* sub Htmls_DIV, Parameter list: $contents,$options=array()
    //*
    //* DIV tag as list html
    //*
    //*

    function Htmls_DIV($contents,$options=array())
    {
        return $this->Htmls_Tag("DIV",$contents,$options);
    }
    //*
    //* sub Htmls_SPAN, Parameter list: $contents,$options=array()
    //*
    //* DIV tag as list html
    //*
    //*

    function Htmls_SPAN($contents,$options=array())
    {
        return $this->Htmls_Tag("SPAN",$contents,$options);
    }
    
    //*
    //* sub Htmls_H, Parameter list: $h,$contents,$options=array()
    //*
    //* DIV tag as list html
    //*

    function Htmls_H($h,$contents,$options=array())
    {
        return $this->Htmls_Tag("H".$h,$contents,$options);
    }
    
    //*
    //* sub Htmls_A, Parameter list: $url,$contents,$title="",$options=array()
    //*
    //* A tag as listed html.
    //*

    function Htmls_A($url,$contents,$title="",$options=array())
    {
        if (!empty($title)) { $options[ "TITLE" ]=$title; }
        $options[ "HREF" ]=$url;
        return
            $this->Htmls_Tag
            (
                "A",
                $contents,
                $options
            );
    }

    
    //*
    //* function Htmls_Buttons, Parameter list:
    //*
    //* Generates a HTML buttons as html list.
    //*

    function Htmls_Buttons($submit="",$reset="",$options=array())
    {
        if (empty($submit))
        {
            $submit=
                $this->GetMessage($this->HtmlMessages,"SendButton");
        }
        
        if (empty($reset))
        {
            $reset=$this->GetMessage($this->HtmlMessages,"ResetButton");
        }

        return
            array
            (
                $this->Html_Input_Button_Make("submit",$submit,$options),
                $this->Html_Input_Button_Make("reset",$reset,$options)
            );
    }
    
    //*
    //* function Htmls_Join, Parameter list: $glue,$list
    //*
    //* Puts glue inbetween elements of $list.
    //*

    function Htmls_Join($glue,$list)
    {
        $n=1;
        $nelements=count($list);

        $rlist=array();
        foreach ($list as $item)
        {
            array_push($rlist,$item);
            if ($n<$nelements)
            {
                array_push($rlist,$glue);
            }

            $n++;
        }

        return $rlist;
    }
}
?>