<?php


trait Html_Input_Select
{
    //*
    //* sub Html_SelectField, Parameter list: 
    //*
    //* HTML select input field from list of items.
    //*

    function Html_SelectField
    (
       $items,$fieldname,$valuekey="ID",
       $namefilter="#Name",$titlefilter="",
       $selected=0,$addempty=TRUE,$disabledkey="",
       $selectoptions=array(),$optionsoptions=array(),
       $maxlen=100
    )
    {
        $select="\n";
        if ($addempty) { $select.=$this->Html_Option_Field_Empty($optionsoptions)."\n"; }
        foreach ($items as $item)
        {
            
            $select.=
                $this->Html_Option_Field
                (
                    $item,
                    $valuekey,
                    $namefilter,
                    $titlefilter,
                    $disabledkey,
                    $selected,
                    $optionsoptions,
                    $maxlen
                );

            if ($this->Html_Option_Field_Selected_Is($item,$valuekey,$selected))
            {
                if (!empty($titlefilter))
                {
                    $selectoptions[ "TITLE" ]=
                        $this->MyHash_Filter($titlefilter,$item);
                }
            }
        }

        $selectoptions[ "NAME" ]=$fieldname;
        return
            $this->Htmls_DIV(
                $this->Html_Tags
                (
                    "SELECT",
                    $select,
                    $selectoptions
                ),
                array(
                    "CLASS" => "select"
                )
            );
    }

    //*
    //* sub Html_Option_Field_Selected_Is, Parameter list: 
    //*
    //* Creates select option from item.
    //*

    function Html_Option_Field_Selected_Is($item,$valuekey,$selected)
    {
        $isselected=False;
        if (is_array($selected))
        {
            if (preg_grep('/^'.$item[ $valuekey ].'$/',$selected))
            {
                $isselected=True;
            }
        }
        else
        {
            if ($selected==$item[ $valuekey ])
            {
                $isselected=True;
            }
        }

        return $isselected;
    }
    
    //*
    //* sub Html_Option_Field, Parameter list: 
    //*
    //* Creates select option from item.
    //*

    function Html_Option_Field($item,$valuekey,$namefilter,$titlefilter,$disabledkey,$selected,$options=array(),$maxlen=30)
    {
        $options[ "VALUE" ]=$item[ $valuekey ];
        
        if (
              !empty($disabledkey)
              &&
              !empty($item[ $disabledkey ])
              &&
              $selected!=$item[ $valuekey ]
           )
        {
            $options[ "DISABLED" ]="";
            $options[ "CLASS" ]="disabled";
        }
        
        if ($this->Html_Option_Field_Selected_Is($item,$valuekey,$selected))
        {
            $options[ "SELECTED" ]="";
            $options[ "CLASS" ]="selected";
        }

        $name=$this->MyHash_Filter($namefilter,$item);
        $title=$name;
        if (strlen($name)>$maxlen)
        {
            $name=substr($name,0,30)."...";
        }
        
        if (!empty($titlefilter))
        {
            $title=" ".$this->MyHash_Filter($titlefilter,$item);
        }
        
        $title.=" (".$item[ $valuekey ].")";

        $options[ "TITLE" ]=$title;
        return $this->Html_Tags("OPTION",$name,$options)."\n";

    }

    //*
    //* sub Html_Option_Title, Parameter list: 
    //*
    //* Genrates option title.
    //*

    function Html_Option_Title($titlekey,$item,$namekey="")
    {
        $title="";
        if (preg_match('/#/',$titlekey))
        {
            $title=$this->FilterHash($titlekey,$item);
        }
        elseif (!empty($item[ $titlekey ]))
        {
            $title=$item[ $titlekey ];
        }

        if (empty($title) && !empty($namekey))
        {
            $title=$this->Html_Option_Title($namekey,$item);
        }
        
        return $title;
    }


    //*
    //* sub Html_Option_Field_Empty, Parameter list: $options=array(),$emptytext=""
    //*
    //* Creates select option from iitem.
    //*

    function Html_Option_Field_Empty($options=array(),$emptytext="<<-- Selecione -->>")
    {
        $options[ "VALUE" ]=" 0";
        return $this->Html_Tags("OPTION",$emptytext,$options);
    }


    //*
    //* sub Html_Select_Hashes2Field, Parameter list: 
    //*
    //* HTML select input field from list of items.
    //*

    function Html_Select_Hashes2Field
        (
            $fieldname,$items,
            $selected=0,
            $namekey="Name",$titlekey="Title",$idkey="ID",
            $selectoptions=array(),$optionsoptions=array(),
            $emptytext=""
        )
    {
        return
            $this->Htmls_Text
            (
                $this->Htmls_Select_Hashes_Field
                (
                    $fieldname,$items,
                    array
                    (
                        "Selected" => $selected,
                        "Name_Key" => $namekey,
                        "Title_Key" => $titlekey,
                        "ID_Key" => $idkey,
                        "Empty_Text" => $emptytext,
                    ),
                    $selectoptions,$optionsoptions
                )
            );
        /* $optionsoptions[ "VALUE" ]=" 0"; */
        /* $selects= */
        /*     array */
        /*     ( */
        /*         $this->Html_Tags */
        /*         ( */
        /*             "OPTION", */
        /*             $emptytext, */
        /*             $optionsoptions */
        /*         ) */
        /*     ); */

        /* foreach ($items as $rid => $item) */
        /* { */
        /*     //Copy of options, preventing mixing option options. */
        /*     $roptionsoptions=$optionsoptions; */
            
        /*     $id=$item[ $idkey ]; */
        /*     $title=$this->Html_Option_Title($titlekey,$item,$namekey);; */
        /*     if ($id==$selected) */
        /*     { */
        /*         $roptionsoptions[ "SELECTED" ]=""; */
        /*         $roptionsoptions[ "CLASS" ]="selected"; */
        /*         $selectoptions[ "TITLE" ]=$title; */
        /*     } */

        /*     $roptionsoptions[ "VALUE" ]=$id; */

        /*     $roptionsoptions[ "TITLE" ]=$title; */

        /*     if (!empty($item[ "Disabled" ])) */
        /*     { */
        /*         $roptionsoptions[ "DISABLED" ]=" "; */
        /*         $roptionsoptions[ "CLASS" ]= "disabled"; */
        /*     } */

        /*     array_push */
        /*     ( */
        /*         $selects, */
        /*         $this->Html_Tags */
        /*         ( */
        /*            "OPTION", */
        /*            $item[ $namekey ], */
        /*            $roptionsoptions */
        /*         ) */
        /*     ); */
        /* } */
        
        /* $selectoptions[ "NAME" ]=$fieldname; */

        /* return */
        /*     "\n". */
        /*     $this->Html_Tags */
        /*     ( */
        /*         "SELECT", */
        /*         join("\n",$selects), */
        /*         $selectoptions */
        /*     ). */
        /*     "\n"; */
    }
    
    //*
    //* sub Html_Select_Multi_Field, Parameter list: 
    //*
    //* HTML select input field from list of items.
    //*

    function Html_Select_Multi_Field
        (
            $items,$fieldname,$valuekey="ID",
            $namefilter="#Name",$titlefilter="",
            $selecteds=array(),$addempty=TRUE,$disabledkey="",
            $selectoptions=array(),$optionsoptions=array()
        )
    {
        $select="";
        if ($addempty) { $select.=$this->Html_Option_Field_Empty($optionsoptions); }
        foreach ($items as $item)
        {
            $selected="";
            if (is_array($selecteds))
            {
                $selected=preg_grep('/^'.$item[ $valuekey ].'$/',$selecteds);
                if (!empty($selected))
                {
                    $selected=array_shift($selected);
                }
            }

            $select.=
                $this->Html_Option_Field
                (
                    $item,
                    $valuekey,
                    $namefilter,
                    $titlefilter,
                    $disabledkey,
                    $selected,
                    $optionsoptions
                );
        }

        if (!preg_match('/\[\]/',$fieldname)) { $fieldname.="[]"; }
        
        $selectoptions[ "NAME" ]=$fieldname;
        $selectoptions[ "MULTIPLE" ]=1;
        if (empty($selectoptions[ "SIZE" ])) { $selectoptions[ "SIZE" ]=count($items); }

        return $this->Html_Tags("SELECT",$select,$selectoptions);
    }
}
?>