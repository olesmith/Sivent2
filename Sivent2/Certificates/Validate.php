<?php

class Certificates_Validate extends Certificates_Access
{
    //*
    //* function Certificates_Validate_CGI2Code, Parameter list: 
    //*
    //* Handles cert validation process.
    //*

    function Certificates_Validate_CGI2Code()
    {
        $code=$this->CGI_GETOrPOST("Code");
        return preg_replace('/\s+/',"",$code);
    }
    
    //*
    //* function Certificates_Validate_Where, Parameter list: 
    //*
    //* Handles cert validation process.
    //*

    function Certificates_Validate_Where($code="")
    {
        if (empty($code)) { $code=$this->Certificates_Validate_CGI2Code(); }
        
        return
             array
             (
                "Code" => $code,
             );
    }
    
    //*
    //* function Certificates_Validate_Read, Parameter list: $datas=array()
    //*
    //* Handles cert validation process.
    //*

    function Certificates_Validate_Read($code="",$datas=array())
    {
         return
             $this->Sql_Select_Hashes
             (
                $this->Certificates_Validate_Where($code),
                $datas,
                "Type"
             );
    }
    
    //*
    //* function Certificates_Validate_Read, Parameter list: 
    //*
    //* Returns numbver of certs cooresponding to actual code.
    //*

    function Certificates_Validate_NMatch($code="")
    {
        return
             $this->Sql_Select_NHashes
             (
                $this->Certificates_Validate_Where($code)
             );
    }
   
    //*
    //* function Certificates_Validate_Show, Parameter list: 
    //*
    //* Acts on entered code and shows list of certs.
    //*

    function Certificates_Validate_Show($code="")
    {
        if (empty($code)) { $code=$this->Certificates_Validate_CGI2Code(); }

        $html="";
        if (preg_match('/^\d{3}\.\d{3}\.\d{6}\.\d{6}$/',$code))
        {
            $certs=$this->Certificates_Validate_Read();
            
            if (count($certs)>0)
            {
                $html.=
                    $this->H(2,$this->MyLanguage_GetMessage("Certificates_Validation_Table_Title")).
                    $this->H(3,$code).
                    $this->MyMod_Items_Table_Html(0,$certs,"Validate");
            }
            else
            {
                $html.=
                    $this->H(2,$this->MyLanguage_GetMessage("Certificates_Validation_Table_Empty")).
                    $this->H(3,$code).
                    "";
            }
        }
        else
        {
            $html.=
                $this->H(1,$this->MyLanguage_GetMessage("Certificates_Validation_Empty").": ".$code).
                $this->H(3,$code).
                "";
        }

        return $html;
    }
    
    //*
    //* function Certificates_Validate, Parameter list: 
    //*
    //* Handles cert validation process.
    //*

    function Certificates_Validate()
    {
        $code=$this->Certificates_Validate_CGI2Code();

        
        echo
            $this->H(1,$this->MyLanguage_GetMessage("Certificates_Validation_Form_Title")).
            $this->StartForm().
            $this->Html_Table
            (
               "",
               array
               (
                  array
                  (
                     $this->B($this->MyLanguage_GetMessage("Certificates_Validation_Form_Code_Title").":"),
                     $this->Html_Input_Field("Code",$code,array("SIZE" => 25))
                  ),
                  array
                  (
                     $this->Html_Input_Button_Make
                     (
                        'submit',
                        $this->MyLanguage_GetMessage("Certificates_Validation_Form_Button_Title")
                     )
                  ),
               )
            ).
            $this->EndForm().
            $this->Certificates_Validate_Show($code).
            "";
    }
}

?>