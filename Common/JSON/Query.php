<?php

trait JSON_Query
{
    ##! JSON_Head
    ##! 
    ##! JSON Header part.
    ##!
        
    function JSON_Query_Head()
    {
        return
            array
            (
                "{",
                "   ".$this->JSON_App()." {",
            );
    }
    
    ##! JSON_Tail
    ##! 
    ##! JSON Tail part.
    ##!
        
    function JSON_Query_Tail()
    {
        return
            array
            (
                "   }",
                "}",
            );
    }
    
    ##! JSON_Pack
    ##! 
    ##! Packs JSON code.
    ##!
        
    function JSON_Query_Pack($json)
    {
        return
            array_merge
            (
                $this->JSON_Query_Head(),
                $json,
                $this->JSON_Query_Tail()
            );
    }
    
    
    ##! JSON_Execute
    ##! 
    ##! Executes $json code.
    ##!
        
    function JSON_Query_Execute($json)
    {
        /* print */
        /*     $this->JSON_Show($json); */

        return
            json_decode
            (
                $this->Curl_POST
                (
                    $this->App_Sigaa_URL(),
                    array
                    (
                        "query" => join("\n",$json),
                    )
                ),
                TRUE
            );
    }

    
    ##! JSON_Module
    ##! 
    ##! JSON $module query.
    ##!
        
    function JSON_Query_Module_Count($module,$where=array())
    {
        return
            $this->JSON_Query_Pack
            (
                $this->JSON_Query_Module
                (
                    $module,
                    array('id'),//'count'),
                    $offset=0,
                    $where
                )
            );
        
    }

    
    ##! JSON_Module
    ##! 
    ##! JSON $module query.
    ##!
        
    function JSON_Query_Module($module,$json,$offset=0,$where=array())
    {
        $wheres=
            array
            (
                /* "limit: ".$this->JSON_Limit, */
                /* "offset: ".$offset, */
            );
        
        foreach ($where as $key => $value)
        {
            if (is_array($value))
            {
                if (count($value)>0)
                {
                    array_push($wheres,$key.": [".join(", ",$value)."]");
                }
            }
            else
            {
                array_push($wheres,$key.": ".$value);
            }
        }

        $where="";
        if (!empty($wheres))
        {
            $where="(".join(", ",$wheres).")";
        }

        return
            array_merge
            (
                array("      ".$module.$where." {"),
                $json,
                array("      }")
            );
    }
    
    ##! JSON_Module_Datas
    ##! 
    ##! JSON $module data specification section.
    ##!
        
    
    function JSON_Query_Module_Datas($module,$datas,$offset=0,$where=array(),$indent="")
    {
        #var_dump("JSON_Query_Module_Datas",$module,$where);
        $json=array();
        foreach ($datas as $data)
        {
            if (is_array($data))
            {
                $name=$data[ "Name" ];
                $rdatas=$data[ "Data" ];
                $rjson=$this->JSON_Query_Module_Datas($name,$rdatas,$offset,array(),"   ");
                $json=array_merge($json,$rjson);
            }
            else
            {
                array_push($json,"         ".$indent.$data);
            }
        }

        return $this->JSON_Query_Module($module,$json,$offset,$where);
    }    
}
?>