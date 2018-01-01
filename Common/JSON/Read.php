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
        
        $done=False;
        $app=$this->JSON_App();
        while (!$done)
        {
            $where[ 'offset' ]=$offset;
            
            $json=
                $this->JSON_Query_Pack
                (
                    $this->JSON_Query_Module_Datas($module,$datas,$offset,$where)
                );

            #print $this->JSON_Show($json);
            
            $json=$this->JSON_Query_Execute($json);
            
            if (
               empty($json[ "data" ])
               ||
               empty($json[ "data" ][ $app ])
               ||
               empty($json[ "data" ][ $app ][ $module ])
            )
            {
                print "JSON_Read_Items: output error:<BR>";
                var_dump($json[ "data" ][ $app ][ $module ]);
                #exit();
                return Null;
            }

            $nitems=0;
            $ritems=0;
            foreach ($this->JSON_Items_Parse($json[ "data" ][ $app ][ $module ]) as $no => $json_item)
            {
                $json_id=$json_item[ $this->JSON_ID_Field() ];
                if (empty($ids[ $json_id ]))
                {
                    if ($this->MyHashes_Search($json_item,$postwhere))
                    {
                        array_push($json_items,$json_item);
                        $ritems++;
                    }
                    
                    $ids[ $json_id ]=True;
                    $nitems++;
                }
                else
                {
                    $done=True;
                    break;
                }
            }

            #We didn't get exactly $this->JSON_Limit items: done
            if ($nitems!=$this->JSON_Limit) { $done=True; }

            var_dump($nitems. " ".$this->ModuleName.", limit: ".$this->JSON_Limit." count ".$ritems);

            $offset+=$this->JSON_Limit;
            $npages++;

            if ($npages>5) { break; }
            
        }

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
            if (count($items)>=1)
            {
                foreach (array_keys($items) as $id)
                {
                    if ($items[ $id ][ $this->JSON_ID_Field() ]==$sigaa_id)
                    {
                        $item=$items[ $id ];
                    }
                }
            }

            if (count($items)>1)
            {
                $this->ApplicationObj()->AddHtmlStatusMessage("Warning! Non-unique SIGAA item!!!");
            }
 
            $this->JSON_Items[ $sigaa_id ]=$item;
        }
        
        return $this->JSON_Items[ $sigaa_id ];
    }
    
}
?>