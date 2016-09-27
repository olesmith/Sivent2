<?php


trait MyMod_Data_Fields_Module
{
    //*
    //* function MyMod_Data_Fields_Module_Class, Parameter list: $data
    //*
    //* Returns slq class name to apply - or null.
    //*

    function MyMod_Data_Fields_Module_Class($data)
    {
        return $this->ItemData[ $data ][ "SqlClass" ];
    }

    //*
    //* function MyMod_Data_Fields_Module_Filter, Parameter list: $data,$title=FALSE
    //*
    //* Returns slq object to apply - or null.
    //*

    function MyMod_Data_Fields_Module_Filter($data,$title=FALSE)
    {
        $key="SqlFilter";
        if ($title) { $key="SqlTitleFilter"; }

         $filter="";
        if (!empty($this->ItemData[ $data ][ $key ]))
        {
            $filter=$this->ItemData[ $data ][ $key ];
        }
        else
        {
            $filter=$this->SubModulesVars($this->MyMod_Data_Fields_Module_Class($data),$key);
        }

        return $filter;
    }

    //*
    //* function MyMod_Data_Fields_Module_Datas, Parameter list: $data
    //*
    //* Returns data to read for subitem $data.
    //*

    function MyMod_Data_Fields_Module_Datas($data)
    {
        if (!empty($this->ItemData[ $data ][ "SqlDerivedData" ]))
        {
            $datas=$this->ItemData[ $data ][ "SqlDerivedData" ];
        }
        else
        {
            $class=$this->MyMod_Data_Fields_Module_Class($data);
            $datas=$this->SubModulesVars($class,"SqlDerivedData");
        }

        //Make sure IDs will be read
        if (!preg_grep('/^ID$/',$datas)) { array_unshift($datas,"ID"); }

        return $datas;
    }

    //*
    //* function MyMod_Data_Fields_Module_SqlWhere, Parameter list: $data,$item
    //*
    //* Generates $data object select field.
    //*

    function MyMod_Data_Fields_Module_SqlWhere($data,$item)
    {
        $where="";
        if (!empty($this->ItemData[ $data ][ "SqlWhere" ]))
        {
            $where=$this->ItemData[ $data ][ "SqlWhere" ];
        }
        elseif (!empty($this->ItemData[ $data ][ "SqlWhere".$this->Profile() ]))
        {
            $where=$this->ItemData[ $data ][ "SqlWhere".$this->Profile() ];
        }
        elseif (!empty($this->ItemData[ $data ][ "SqlWhere".$this->LoginType() ]))
        {
            $where=$this->ItemData[ $data ][ "SqlWhere".$this->LoginType() ];
        }

        if (is_array($where))
        {
            $where=$this->Hash2SqlWhere($where);
        }

        $where=$this->FilterHash($where,$this->LoginData);
        $where=$this->FilterHash($where,$item);
        $where=$this->ApplicationObj->FilterObject($where);

        return $where;
    }

    //*
    //* function MyMod_Data_Module_2Object, Parameter list: $data
    //*
    //* Returns slq object to apply - or null.
    //*

    function MyMod_Data_Fields_Module_2Object($data)
    {
        return $this->ApplicationObj()->MyApp_Module_GetObject($this->MyMod_Data_Fields_Module_Class($data));
    }

    //*
    //* function MyMod_Data_Fields_Module_Edit, Parameter list: $data,$item,$value="",$tabindex="",$plural=FALSE,$links=TRUE,$callmethod=TRUE,$rdata=""
    //*
    //* Creates sql object select field.
    //*

    function MyMod_Data_Fields_Module_Edit($data,$item,$value="",$tabindex="",$plural=FALSE,$options=array(),$rdata="")
    {
        return $this->MyMod_Data_Fields_Module_Select($data,$item,"",0,$rdata,"",FALSE);
    }

    //*
    //* function MyMod_Data_Fields_Module_Show, Parameter list: $data,$item,$value="",$tabindex="",$plural=FALSE,$links=TRUE,$callmethod=TRUE
    //*
    //* Creates sql object show field.
    //*

    function MyMod_Data_Fields_Module_Show($data,$item,$value="",$plural=FALSE)
    {
        if (empty($value) && !empty($item[ $data ])) { $value=$item[ $data ]; }

        $empty=$this->GetEnumEmptyName($data);
        $emptytext="";
        if (!empty($empty)) { $emptytext=$empty; }

        if (!empty($value))
        {
            if (empty($this->ItemData[ $data ][ "Items" ]))
            {
                $this->ItemData[ $data ][ "Items" ]=array();
            }

            if (empty($this->ItemData[ $data ][ "Items" ][ $value ]))
            {
                $subitem=$this->MyMod_Data_Fields_Module_SubItems_Read($data,$item,array($value));
                $this->ItemData[ $data ][ "Items" ][ $value ]=array_pop($subitem);
            }

            $value=$this->ItemData[ $data ][ "Items" ][ $value ][ "Name" ];
            if (!empty($this->ItemData[ $data ][ "Items" ][ $value ][ "Title" ]))
            {
                $value=$this->Span
                (
                   $value,
                   array
                   (
                      "TITLE" => $this->ItemData[ $data ][ "Items" ][ $value ][ "Title" ],
                   )
                );
            }
        }
        else { $value=$this->MyMod_Data_EmptyText($data); }

        $href=$this->ItemData[ $data ][ "HRef" ];
        if (!empty($item[ $data ]) && !empty($href))
        {
            $args=$this->CGI_URI2Hash();
            $args=$this->CGI_URI2Hash($href,$args);
            $href=$this->CGI_Hash2URI($args);

            $href=$this->Filter($href,$item);
            $value=$this->Href("?".$href,$value);
        }

        return $value;
    }


    //*
    //* function MyMod_Data_Module_Select, Parameter list: $data,$item,$id="",$ignoredefault=0,$rdata="",$fieldtitle="",$multiple=FALSE,$searchfield=FALSE
    //*
    //* Generates $data object select field.
    //*

    function MyMod_Data_Fields_Module_Select($data,$item,$id="",$ignoredefault=0,$rdata="",$fieldtitle="",$multiple=FALSE)
    {
        if (empty($id) && !empty($item[ $data ])) { $id=$item[ $data ]; }

        $subobject=$this->MyMod_Data_Fields_Module_2Object($data);

        $empty=$this->GetEnumEmptyName($data);
        $emptytext="";
        if (!empty($empty)) { $emptytext=$empty; }

        return $this->Html_Select_Hashes2Field
        (
           $rdata,
           $this->MyMod_Data_Fields_Module_Options($data,$item),
           $id,
           "Name","Title",array(),array(),
           $this->MyMod_Data_EmptyText($data)
        );
    }

    //*
    //* function MyMod_Data_Object_Module_Options, Parameter list: $data,$item
    //*
    //* Generates $data object data select field (not search).
    //*

    function MyMod_Data_Fields_Module_Options($data,$item)
    {
        $subobject=$this->MyMod_Data_Fields_Module_2Object($data);

        $subobject->IncludeAll=TRUE;

        if (!empty($this->ItemData[ $data ][ "Compound" ]))
        {
            $data=$this->ItemData[ $data ][ "Compound" ];
        }

        if (empty($this->ItemData[ $data ][ "Options" ]))
        {
            $ids=$subobject->Sql_Select_Unique_Col_Values
            (
               "ID",
               $this->MyMod_Data_Fields_Module_SqlWhere($data,$item),
               $this->ItemData($data,"SqlGroupBy"),
               $this->ItemData($data,"SqlOrderBy")
           );
 
           $options=
                $this->MyMod_Data_Fields_Module_SubItems_Read($data,$item,$ids);

          

           $soptions=array();
           foreach ($options as $option)
           {
               $soptions
               [
                 $this->Html2Sort($option[ "Name" ]).
                 sprintf("%06d",$option[ "ID" ])
               ]=$option;
           }

           $keys=array_keys($soptions);
           sort($keys);
            
           $this->ItemData[ $data ][ "Options" ]=array();
           foreach ($keys as $key)
           {
               array_push($this->ItemData[ $data ][ "Options" ],$soptions[ $key ]);
           }
        }

         if (!empty($this->ItemData[ $data ][ "SqlSelectReverse" ]))
         {
             $this->ItemData[ $data ][ "Options" ]=array_reverse($this->ItemData[ $data ][ "Options" ]);
         }

        return $this->ItemData[ $data ][ "Options" ];
      }


     //*
    //* function MyMod_Data_Module_SubItems_2Options, Parameter list: $data,$subitems
    //*
    //* Converts $subitems to ID =>, Name =>, Title => hash, according to
    //* Filters according to MyMod_Data_Fields_Module_Filter function.
    //*

    function MyMod_Data_Fields_Module_SubItems_2Options($data,$subitems)
    {
        $filter=$this->MyMod_Data_Fields_Module_Filter($data);
        $titlefilter=$this->MyMod_Data_Fields_Module_Filter($data,TRUE);
        
        $options=array();
        foreach (array_keys($subitems) as $id)
        {
            $subitems[ $id ]=$this->Module2Object($data)->ApplyAllEnums($subitems[ $id ]);

            $rid=$subitems[ $id ][ "ID" ];
            
            $options[ $rid ]=array
            (
               "ID" => $rid,
               "Name" => $this->Filter($filter,$subitems[ $id ])
            );

                        
            if (!empty($titlefilter))
            {
                $options[ $rid ][ "Title" ]=$this->Filter($titlefilter,$subitems[ $id ]);
            }
        }

        return $options;
    }


    //*
    //* function MyMod_Data_Module_SubItems_Read, Parameter list: $data,$item,$ids
    //*
    //* Generates $data object select field.
    //*

    function MyMod_Data_Fields_Module_SubItems_Read($data,$item,$ids)
    {
        $subobject=$this->Module2Object($data);

        $where=array("ID" => $this->Sql_Where_IN($ids));

        $subitems=array();
        if (!empty($ids))
        {
            $subitems=$subobject->Sql_Select_Hashes
            (
               $where,
               $this->MyMod_Data_Fields_Module_Datas($data),
               join(",",$subobject->Sort)
            );
        }
        
        return $this->MyMod_Data_Fields_Module_SubItems_2Options($data,$subitems);
    }
}

?>