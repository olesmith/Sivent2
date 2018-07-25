<?php



trait MyMod_Data_Triggers
{
    //*
    //* Returns name of Trigger function, if any for $data
    //*

    function MyMod_Data_Trigger_Function($data)
    {
        if (!empty($this->ItemData[ $data ][ "TriggerFunction" ]))
        {
            return $this->ItemData[ $data ][ "TriggerFunction" ];
        }
        elseif (isset($this->TriggerFunctions[ $data ]))
        {
            return $this->TriggerFunctions[ $data ];
        }


        return FALSE;
    }
    
    //*
    //* Applies trigger function, for data $data item in DB.
    //*

    function MyMod_Data_Trigger_Apply($data,$item,$prepostkey="",$plural=FALSE)
    {
        $method=$this->MyMod_Data_Trigger_Function($data);
        if ($method)
        {
            if (method_exists($this,$method))
            {
                $rdata=$data;
                if (!empty($this->ItemData[ $data ][ "CGIName" ]) && !$plural)
                {
                    $rdata=$this->ItemData[ $data ][ "CGIName" ];
                }

                $newvalue=$this->GetPOST($prepostkey.$rdata);
                $ritem=$this->$method($item,$data,$newvalue);

                if (is_array($ritem) && count($ritem)>0)
                {
                    $item=$ritem;
                }
            }
            else
            {
                die("Warning: ($data) TriggerFunction: $method(\$item,\$data,\$newvalue): undefined");
            }
        }
        
        return $item;
    }
}

?>