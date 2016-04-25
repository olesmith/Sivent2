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
       $selected=0,$disabledkey="",
       $selectoptions=array(),$optionsoptions=array()
    )
    {
        $select=$this->Html_EmptyOptionField($optionsoptions);
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
               $optionsoptions
            );

            if ($selected==$item[ $valuekey ])
            {
                if (!empty($titlefilter))
                {
                    $selectoptions[ "TITLE" ]=
                        "Selecionado: ".
                        $this->FilterHash($titlefilter,$item);
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

    function Html_OptionField($item,$valuekey,$namefilter,$titlefilter,$disabledkey,$selected,$options=array())
    {
        $options[ "VALUE" ]=$item[ $valuekey ];

        if (!empty($disabledkey) && !empty($item[ $disabledkey ]))
        {
            $options[ "DISABLED" ]="";
        }

        if ($selected==$item[ $valuekey ])
        {
            $options[ "SELECTED" ]="";
        }

        if (!empty($titlefilter))
        {
            $options[ "TITLE" ]=$this->FilterHash($titlefilter,$item);
        }

        return $this->Html_Tags("OPTION",$this->FilterHash($namefilter,$item),$options);

    }


    //*
    //* sub Html_EmptyOptionField, Parameter list: $options=array(),$emptytext=""
    //*
    //* Creates select option from iitem.
    //*

    function Html_EmptyOptionField($options=array(),$emptytext="")
    {
        $options[ "VALUE" ]=0;
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
       $namekey="Name",$titlekey="Title",
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
            
            $id=$item[ "ID" ];
            if ($id==$selected)
            {
                $roptionsoptions[ "SELECTED" ]="";
                if (!empty($item[ $titlekey ]))
                {
                    $selectoptions[ "TITLE" ]=$item[ $titlekey ];
                }
            }

            $roptionsoptions[ "VALUE" ]=$id;

            if (!empty($item[ $titlekey ]))
            {
                $roptionsoptions[ "TITLE" ]=$item[ $titlekey ];
            }

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
}
?>