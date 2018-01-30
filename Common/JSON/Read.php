<?php

trait JSON_Read
{
    var $JSON_Items=array();
    
    ##! JSON_Read_NItems
    ##! 
    ##! Detects number of itmes to read.
    ##!
        
    function JSON_Read_NItems($module,$where)
    {
        $where[ 'limit' ]=1;
        #$module="Municipios";
        $json=$this->JSON_Query_Module_Count($module,$where);
        $json=$this->JSON_Query_Execute($json);

        $result=$this->JSON_Items_Parse($json[ "data" ][ $app ][ $module ]);

        return 0;
    }
    
    ##! JSON_Read_Item_Values
    ##! 
    ##! Reads JSON items and extracts $field values.
    ##!
        
    function JSON_Read_Item_Values($module,$field,$where=array(),$postwhere=array())
    {
        //Fields to read
        $fields=array($field => True);

        //Add fields in postwhere
        foreach (array_keys($postwhere) as $key)
        {
            $fields[ $key ]=True;
        }

        return
            $this->MyHash_HashesList_Values
            (
                $this->JSON_Read_Items
                (
                    $module,
                    array_keys($fields),
                    $where,
                   $postwhere
                ),
                $field
            );
    }
    
    ##! JSON_Items_Search_Post
    ##! 
    ##! Detects $json_items matching $postwhere.
    ##! Chekcs for previously seen items, in order
    ##! to stop paging, when repeated items has been met.
    ##!
        
    function JSON_Items_Search_Post($postwhere,&$json_items,&$ids,$done)
    {
        foreach ($json_items as $no => $json_item)
        {
            $json_id=$json_item[ $this->JSON_ID_Field() ];
            if (empty($ids[ $json_id ]))
            {
                #var_dump($this->MyHash_Match($json_item,$postwhere));
                //Not seen yet
                if (!$this->MyHash_Match($json_item,$postwhere))
                {
                    unset($json_items[ $no ]);
                }

                //Mark as seen
                $ids[ $json_id ]=True;
            }
            else
            {
                //Seen, repeated page
                $done=True;
                break;
            }
        }

        return $done;
    }
    
    ##! JSON_Read_Items_Page
    ##! 
    ##! Queries and parses one page of items.
    ##!
        
    function JSON_Read_Items_Page($module,$datas,$where,$offset)
    {
        $app=$this->JSON_App();
        
        $where[ 'offset' ]=$offset;        
        $json=
            $this->JSON_Query_Execute
            (
                $this->JSON_Query_Pack
                (
                    $this->JSON_Query_Module_Datas($module,$datas,$offset,$where)
                )
            );
            
        if
            (
               empty($json[ "data" ])
               ||
               empty($json[ "data" ][ $app ])
               ||
               empty($json[ "data" ][ $app ][ $module ])
            )
        {
            $this->ApplicationObj()->AddHtmlStatusMessage("JSON_Read_Items: output error");
            $query=
                $this->JSON_Query_Pack
                (
                    $this->JSON_Query_Module_Datas($module,$datas,$offset,$where)
                );
            print join($this->BR(),$query);
            return Null;
        }

        return $this->JSON_Items_Parse($json[ "data" ][ $app ][ $module ]);
    }
    
    ##! JSON_Read_Items
    ##! 
    ##! Creates module JSON code reading $items according to $where and executes it on GraphQL server.
    ##! Afterwards, eliminate $items not confirming to $postwhere. Returns parsed items.
    ##!
        
    function JSON_Read_Items($module,$datas,$where=array(),$postwhere=array())
    {
        $offset=0;
        $where[ 'limit' ]=$this->JSON_Limit;

        $npages=1;
        $json_items=array();
        $ids=array();

        $read_nitems=0;
        $post_nitems=0;

        $done=False;

        $table=array();
        while (!$done)
        {
            $json_items_page=$this->JSON_Read_Items_Page($module,$datas,$where,$offset);

            if (is_array($json_items_page))
            {
                #If we didn't get exactly $this->JSON_Limit items: done
                $nitems=count($json_items_page);
                if ($nitems!=$this->JSON_Limit) { $done=True; }

                $read_nitems+=$nitems;
                $row=
                    array
                    (
                        $npages++,
                        $nitems
                    );
                
                $done=
                    $this->JSON_Items_Search_Post
                    (
                        $postwhere,
                        $json_items_page,
                        $ids,
                        $done
                    );
               
                array_push($row,count($json_items_page));
                $post_nitems+=count($json_items_page);

                $json_items=
                    array_merge
                    (
                        $json_items,
                        $json_items_page
                    );


                $offset+=$this->JSON_Limit;
                
                array_push($table,$row);
            }
            else
            {
                $done=True;
            }
        }

        array_push
        (
            $table,
            array
            (
                $this->B($this->ApplicationObj()->Sigma),
                $read_nitems,
                $post_nitems
            )
        );
        
        $this->ApplicationObj()->AddHtmlStatusMessage
        (
            $this->ModuleName.": ".
            $this->Html_Table
            (
                array("Page","Read","Post"),
                $table
            ).
            ""
        );

        return $this->MyHashes_Search($json_items,$postwhere);
    }
    
    ##! JSON_Read_Item
    ##! 
    ##! Creates module JSON code reading one item and executes it on GraphQL server.
    ##! Returns parsed item.
    ##!
        
    function JSON_Read_Item($module,$datas,$sigaa_id)
    {
        if (empty($this->JSON_Items[ $sigaa_id ]))
        {
            $items=
                $this->JSON_Read_Items
                (
                    $module,
                    $datas,
                    array
                    (
                        $this->JSON_ID_Field() => $sigaa_id,
                    )
                );
        
            #Should be unique, take first anyway.
            $item=array();
            $found=0;
            if (count($items)>=1)
            {
                foreach (array_keys($items) as $id)
                {
                    if ($items[ $id ][ $this->JSON_ID_Field() ]==$sigaa_id)
                    {
                        $item=$items[ $id ];
                        $found++;
                    }
                }
            }

            if (empty($item))
            {
                $this->ApplicationObj()->AddHtmlStatusMessage("Warning! SIGAA item '".$sigaa_id."' not found!!!");
                #var_dump($items);
            }
            
            if ($found>1)
            {
                $this->ApplicationObj()->AddHtmlStatusMessage("Warning! Non-unique SIGAA item!!!");
                #var_dump($items);
            }
 
            $this->JSON_Items[ $sigaa_id ]=$item;
        }
        
        return $this->JSON_Items[ $sigaa_id ];
    }
    
    
}
?>