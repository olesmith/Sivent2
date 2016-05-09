<?php


class Certificates_Code extends Certificates_Mail
{
    var $Code_Data=array
    (
       "Unit" => "%02d",
       "Event" => "%03d",
       "Friend" => "%06d",
       "ID" => "%06d",       
    );
    
    
    //*
    //* function Certificate_Code, Parameter list: $item,$type=0
    //*
    //* Generates certificate code.
    //*

    function Certificate_Code($item,$type=0)
    {
        if (empty($type) || empty($type)) { $type=$item[ "Type" ]; }
        
        $code="";
        if (
              !empty($item[ "ID" ])
              &&
              !empty($item[ "Friend" ])
              &&
              !empty($item[ "Event" ])
           )
        {
            
            $comps=array();
            foreach ($this->Code_Data as $data => $format)
            {
                array_push($comps,sprintf($format,$item[ $data ]));
            }

            array_push($comps,$type);
            $code=join(".",$comps);
        }

        return $code;
    }
    //*
    //* function Certificate_Decode, Parameter list: $code
    //*
    //* Generates certificate code.
    //*

    function Certificate_Decode($code)
    {
        $comps=preg_split('/\./',$code);
        $item=array();
        foreach (array_keys($this->Code_Data) as $data)
        {
            $item[ $data ]=intval(array_shift($comps));
        }

        
        $item[ "Type" ]=intval(array_shift($comps));
        $typekey=$this->Type2Key($item);
        $item[ $typekey ]=$item[ "ID" ];
        unset($item[ "ID" ]);
                
        return $item;
    }

     //*
    //* function Certificate_Code2Where, Parameter list: $code=""
    //*
    //* Generates cert.
    //*

    function Certificate_Code2Where($code)
    {
        if (empty($code)) { $code=$this->CGI_GET("Code"); }

        $codes=preg_split('/\./',$code);

        $where=array();
        foreach (array_keys($this->Code_Data) as $data)
        {
            $where[ $data ]=array_shift($codes);
        }

        $where[ "Type" ]=array_shift($codes);
        
        $key=$this->Type2Key($where);
        $where[ $key ]=$where[ "ID" ];
        unset($where[ "ID" ]);

        return $where;
    }
    
     //*
    //* function Certificate_Code2Certs, Parameter list: $code
    //*
    //* Generates cert.
    //*

    function Certificate_Code2Cert($code)
    {
        $where=$this->Certificate_Decode($code);

        return $this->Sql_Select_Hashes($where);
    }

    //*
    //* function Certificate_Code_PostProcess, Parameter list: &$item,&$updatedatas
    //*
    //* Postprocesses certificate code.
    //*

    function Certificate_Code_PostProcess(&$item,&$updatedatas)
    {
        $code=$item[ "Code" ];

        $subitem=array
        (
           "Unit" => $item[ "Unit" ],
           "Event" => $item[ "Event" ],
           "Friend" => $item[ "Friend" ],
        );
        
        $key=$this->Type2Key($item);
        $obj=$key."sObj";
        
        $subitem[ "ID" ]=$item[ $key ];
        $code=$this->$obj()->Certificate_Code($subitem);
       
        if ($item[ "Code" ]!=$code)
        {
            $item[ "Code" ]=$code;
            array_push($updatedatas,"Code");
        }
    }

}

?>