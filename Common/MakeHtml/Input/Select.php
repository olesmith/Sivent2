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
        if ($addempty) { $select.=$this->Html_EmptyOptionField($optionsoptions)."\n"; }
        foreach ($items as $item)
        {
            $select.=$this->Html_OptionField
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

            if ($selected==$item[ $valuekey ])
            {
                if (!empty($titlefilter))
                {
                    $selectoptions[ "TITLE" ]=
                        $this->MyHash_Filter($titlefilter,$item);
                }
            }
        }

        $selectoptions[ "NAME" ]=$fieldname;
        return $this->Html_Tags("SELECT",$select,$selectoptions);
    }

    //*
    //* sub Html_OptionField, Parameter list: 
    //*
    //* Creates select option from item.
    //*

    function Html_OptionField($item,$valuekey,$namefilter,$titlefilter,$disabledkey,$selected,$options=array(),$maxlen=30)
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

        if ($selected==$item[ $valuekey ])
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
            $title.=" ".$this->MyHash_Filter($titlefilter,$item);
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

    function Html_Option_Title($titlekey,$item)
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
        
        return $title;
    }


    //*
    //* sub Html_EmptyOptionField, Parameter list: $options=array(),$emptytext=""
    //*
    //* Creates select option from iitem.
    //*

    function Html_EmptyOptionField($options=array(),$emptytext="<<-- Selecione -->>")
    {
        $options[ "VALUE" ]=" 0";
        return $this->Html_Tags("OPTION",$emptytext,$options);
    }


    //*
    //* sub Html_Select_Hashes2Field, Parameter list: 
    //*
    //* HTML select input field from list of items.
    //*

    function Html_Select_Hashes2Field(
       $fieldname,$items,
       $selected=0,
       $namekey="Name",$titlekey="Title",$idkey="ID",
       $selectoptions=array(),$optionsoptions=array(),
       $emptytext=""
    )
    {
        $optionsoptions[ "VALUE" ]=" 0";
        $select=
            "\n".
            "   ".
            $this->Html_Tags
            (
               "OPTION",
               $emptytext,
               $optionsoptions
            ).
            "\n";

        foreach ($items as $rid => $item)
        {
            //Copy of options, preventing mixing option options.
            $roptionsoptions=$optionsoptions;
            
            $id=$item[ $idkey ];
            if ($id==$selected)
            {
                $roptionsoptions[ "SELECTED" ]="";
                $selectoptions[ "TITLE" ]=$this->Html_Option_Title($titlekey,$item);
            }

            $roptionsoptions[ "VALUE" ]=$id;

            $roptionsoptions[ "TITLE" ]=$this->Html_Option_Title($titlekey,$item);

            if (!empty($item[ "Disabled" ]))
            {
                $roptionsoptions[ "DISABLED" ]=" ";
                $roptionsoptions[ "CLASS" ]= "disabled";
            }

           $select.=
                "   ".
                $this->Html_Tags
                (
                   "OPTION",
                   $item[ $namekey ],
                   $roptionsoptions
                ).
                "\n";
        }
        
        $selectoptions[ "NAME" ]=$fieldname;

        return "\n".$this->Html_Tags("SELECT",$select,$selectoptions)."\n";
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
        if ($addempty) { $select.=$this->Html_EmptyOptionField($optionsoptions); }
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

            $select.=$this->Html_OptionField
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