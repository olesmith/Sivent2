<?php


trait ItemsFormDetails
{
    //*
    //* function ItemsForm_Details_Should, Parameter list: $item
    //*
    //* Generates table listing, with possible edit row - and add row.
    //* 
    //*

    function ItemsForm_Details_Should($item)
    {
        $value=$this->CGI_GETint($this->Args[ "DetailsCGIVar" ]);
        if (empty($value)) { $value=$this->Args[ "DetailsDefault" ]; }
        
        $res=TRUE;
        if ($value!=$item[ $this->Args[ "DetailsItemVar" ] ])
        {
            $res=FALSE;
        }
        
        foreach ($this->Args[ "DetailsCGIVars" ] as $key)
        {
            if ($this->CGI_GETint($key)!=$item[ $key ]) { $res=FALSE; }
        }

        return $res;
    }
    
    //*
    //* function ItemsForm_Details_URI, Parameter list: $item
    //*
    //* Returns suitable details URI for $item.
    //* 
    //*

    function ItemsForm_Details_URI($item)
    {
        $args=$this->CGI_URI2Hash();

        $args[ $this->Args[ "DetailsCGIVar" ] ]=$item[ "ID" ];
        foreach ($this->Args[ "IgnoreGETVars" ] as $key)
        {
            unset($args[ $key ]);
        }

        $args[ $this->Args[ "DetailsCGIVar" ] ]=$item[ $this->Args[ "DetailsItemVar" ] ];
        
        foreach ($this->Args[ "DetailsAddVars" ] as $key)
        {
            $args[ $key ]=$item[ $key ];
        }

        return
            $this->CGI_Hash2URI($args).
            "";
    }
    
     //*
    //* function ItemsForm_Details_ID, Parameter list: 
    //*
    //* Returns anchor for use by item form and item anchor.
    //* 
    //*

    function ItemsForm_Details_ID()
    {
        $anchor="TOP";
        if (!empty($this->Args[ "Anchor" ]))
        {
            $anchor=$this->Args[ "Anchor" ];
        }

        return $anchor;
    }

    
    //*
    //* function ItemsForm_Details_Href, Parameter list: $item
    //*
    //* Returns suitable details Href for $item.
    //* 
    //*

    function ItemsForm_Details_Href($item)
    {
        return $this->Href
        (
           "?".
           $this->ItemsForm_Details_URI($item),
           "++",
           
           "Detalhes",
           "","",FALSE,array(),
           $this->ItemsForm_Details_ID()
        );
    }
    
    //*
    //* function ItemsForm_Un_Details_Href, Parameter list: $item
    //*
    //* Returns suitable details Href for $item.
    //* 
    //*

    function ItemsForm_Un_Details_Href($item)
    {
        $args=$this->CGI_URI2Hash();
        
        unset($args[ $this->Args[ "DetailsCGIVar" ] ]);

        return $this->Href
        (
           "?".$this->CGI_Hash2URI($args),
           "--",
           "Menos"
        );
    }
    
    //*
    //* function ItemsForm_DetailsSGroupsMatrix, Parameter list: $edit,$item
    //*
    //* Returns matrix of SGroups to include for detailed $item.
    //* 
    //*

    function ItemsForm_DetailsSGroupsMatrix($edit,$item)
    {
        if (is_string($this->Args[ "DetailsSGroups" ]))
        {
            $method=$this->Args[ "DetailsSGroups" ];
            if (method_exists($this,$method))
            {
                return $this->$method($edit,$item);
            }

            die("Invalid DetailsSGroups method: ".$method);
        }

        $groupsm=array();
        foreach (array_keys($this->Args[ "DetailsSGroups" ]) as $key)
        {
            foreach (array_keys($this->Args[ "DetailsSGroups" ][ $key ]) as $group)
            {
                if (empty($groupsm[ $key ])) { $groupsm[ $key ]=array(); }

                $groupsm[ $key ][ $group ]=$edit;
            }
        }

        return $this->Args[ "DetailsSGroups" ];
    }

    
    //*
    //* function ItemsForm_ItemDetailsCell, Parameter list: $edit,$item
    //*
    //* Generates detailed item cell as text..
    //* 
    //*

    function ItemsForm_ItemDetailsCell($edit,$item)
    {
        $table=
            $this->MyMod_Item_Group_Tables
            (
                $edit,
                $this->ItemsForm_DetailsSGroupsMatrix($edit,$item),
                $item,
                ""
            );
            
        
        return $this->Html_Table("",$table);
    }
    
    //*
    //* function ItemsForm_ItemDetails_Cell_Rows, Parameter list: $edit,$item,$n
    //*
    //* Generates detailed item cell as rows.
    //* 
    //*

    function ItemsForm_ItemDetails_Cell_Rows($edit,$item,$n)
    {
        $cellmethod=$this->Args[ "DetailsMethod" ];
        $obj=$this->Args[ "DetailsObject" ];

        return array
        (
           array
           (
              "",
              $this->MultiCell
              (
                  $obj->$cellmethod($edit,$item),
                  $this->ItemsForm_ItemRows_NCols()+1
              )
           )
        );
    }


    //*
    //* function ItemsForm_ItemDetails_Rows, Parameter list: $edit,$item,$n
    //*
    //* Generates detailed item cell as rows.
    //* 
    //*

    function ItemsForm_ItemDetails_Rows($edit,$item,$n)
    {
        $args=$this->CGI_URI2Hash();

        $args[ $this->Args[ "DetailsCGIVar" ] ]=$item[ $this->Args[ "DetailsItemVar" ] ];
        
        unset($args[ $this->Args[ "DetailsCGIVar" ] ]);

        $rows1=array();
        if ($this->Args[ "DetailsIncludeDataRow" ])
        {
            $rows1=$this->Table_Rows($edit,$item,$n);
        }

        
        $rows2=$this->ItemsForm_ItemDetails_Cell_Rows($edit,$item,$n);
        $rows=array_merge($rows1,$rows2);
        
        $rows[0][0]=
            " ".
            $this->B
            (
                sprintf("%02d",$n),
                array
                (
                    "ID" => $this->ItemsForm_Details_ID(),
                )
            ).
            " ".
            $this->ItemsForm_Un_Details_Href($item).
            "";

        return $rows;
    }



    //*
    //* function ItemsForm_ItemDetailsUpdate, Parameter list: &$item
    //*
    //* Updates detailed item cell as row.
    //* 
    //*

    function ItemsForm_ItemDetailsUpdate(&$item)
    {
        $groups=array();
        foreach ($this->ItemsForm_DetailsSGroupsMatrix(1,$item) as $group => $rgroups)
        {
            $groups=array_merge($groups,array_keys($rgroups));
        }

        $updatedatas=$this->MyMod_Item_Groups_CGI2Item
        (
           $groups,
           $item
        );

        if (count($updatedatas)>0)
        {
            $this->Sql_Update_Item_Values_Set($updatedatas,$item);
            $item=$this->MyMod_Item_PostProcess($item);
        }

        return count($updatedatas);
    }
}

?>