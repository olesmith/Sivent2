<?php

trait MyMod_Handle_Export_CGI
{
    var $NFields=0;
    var $Fields=array();
    
    //*
    //* Number of CGI field vars.
    //*

    function MyMod_Handle_Export_CGI_NFields()
    {
        if (empty($this->NFields))
        {
            $this->NFields=$this->CGI_POSTint("NFields");
            if (empty($this->NFields)){ $this->NFields=$this->MyMod_Handle_Export_Defaults("NFields"); }
            if (empty($this->NFields)){ $this->NFields=5; }
        }
        
        return $this->NFields;
    }
    
    
    //*
    //* CGI reverse order value.
    //*

    function MyMod_Handle_Export_CGI_Reverse()
    {
        return $this->GetCGIVarValue("Sort_Reverse");
    }
    
    //*
    //* CGI GO value.
    //*

    function MyMod_Handle_Export_CGI_Go()
    {
        return $this->GetCGIVarValue("GO");
    }
    
    //*
    //* return list of vars defined by CGI.
    //*

    function MyMod_Handle_Export_CGI_Type()
    {
        $type=$this->GetCGIVarValue("Export_Type");
        if ($type=="") { $type="HTML"; }

        return $type;
    }
    
    //*
    //* CGI apply enums.
    //*

    function MyMod_Handle_Export_CGI_No_Enums()
    {
        return $this->GetCGIVarValue("No_Enums");
    }
    
    //*
    //* CGI include all data.
    //*

    function MyMod_Handle_Export_CGI_All_Data()
    {
        return $this->GetCGIVarValue("Apply_Data");
    }
    
    //*
    //* Return list of var defs defined by CGI.
    //*

    function MyMod_Handle_Export_CGI_Field_Value($n,$type)
    {
        $value=$this->CGI_POST($type."_".$n);
        $default=$this->MyMod_Handle_Export_Defaults($type,$n);
        
        if (empty($value) && !empty($default))
        {
            $value=$default;
        }

        return $value;        
    }
    
    //*
    //* Return list of var defs defined by CGI.
    //*

    function MyMod_Handle_Export_CGI_Fields($no=0,$key="")
    {
        if (empty($this->Fields))
        {
            $this->Fields=array();
            for ($n=1;$n<=$this->MyMod_Handle_Export_CGI_NFields();$n++)
            {
                array_push
                (
                    $this->Fields,
                    array
                    (
                        "Data" => $this->MyMod_Handle_Export_CGI_Field_Value($n,"Data"),
                        "Sort" => $this->MyMod_Handle_Export_CGI_Field_Value($n,"Sort"),
                    )
                );
            }
        }

        if (!empty($no))
        {
            if (!empty($key))
            {
                return $this->Fields[ $no-1 ][ $key ];
            }
            
            return $this->Fields[ $no-1 ];
        }

        return $this->Fields;
    }
    
    //*
    //* Translates fields to datas list.
    //*

    function MyMod_Handle_Export_CGI_Fields_Datas()
    {
        $datas=array();
        for ($n=1;$n<=$this->NFields;$n++)
        {
            $data=$this->Fields[ $n-1 ][ "Data" ];
            if (preg_match('/\S/',$data))
            {
                $datas[ $data ]=1;
            }
        }

        return array_keys($datas);
    }
}
?>