<?php


trait MyApp_Messages_Edit_Language
{
    //*
    //* function MyApp_Messages_Edit_Hash_Key_Lang_Rows, Parameter list: $edit,$path,$file,$hashkey,$hash,$key,$lkey
    //*
    //* Creates rows with $hash $key.$lkey entry. Several rows if value is array.
    //*

    function MyApp_Messages_Edit_Hash_Key_Lang_Rows($edit,$path,$file,$hashkey,$hash,$key,$lkey)
    {
        $rows=array();
        
        $language=preg_replace('/^_/',"",$lkey);
        if (empty($language)) { $language=$this->ApplicationObj()->Language_Default; }
        

        $rkey=$key.$lkey;

        $value="";
        if (!empty($hash[ $rkey ])) { $value=$hash[ $rkey ]; }
        if (empty($value) && !empty($hash[ $key ])) { $value=$hash[ $key ]; }

        if (is_array($value))
        {
            //something sensible, more rows!?
            $rows=array(array($language,join(", ",$value)));
        }
        else
        {
            $rows=$this->MyApp_Messages_Edit_Hash_Key_Lang_Cell($edit,$path,$file,$hashkey,$hash,$key,$lkey,$value);
        }
      
       
        return $rows;
    }

    //*
    //* function MyApp_Messages_Edit_Hash_Key_Lang_CGI_Name, Parameter list: $hashkey,$key,$lkey
    //*
    //* Returns CGI key associated with $hashkey, $key and $lkey.
    //*

    function MyApp_Messages_Edit_Hash_Key_Lang_CGI_Name($hashkey,$key,$lkey)
    {
        return $hashkey."_".$key.$lkey;
    }
    
    //*
    //* function MyApp_Messages_Edit_Hash_Key_Lang_CGI_Value, Parameter list: $hashkey,$key,$lkey
    //*
    //* Returns CGI value associated with $hashkey, $key and $lkey.
    //*

    function MyApp_Messages_Edit_Hash_Key_Lang_CGI_Value($hashkey,$key,$lkey)
    {
        return
            preg_replace
            (
               '/&#039;/',
               "'",
               html_entity_decode
               (
                  $this->CGI_POST
                  (
                   $this->MyApp_Messages_Edit_Hash_Key_Lang_CGI_Name($hashkey,$key,$lkey)
                  )
               )
            );
    }
    
    //*
    //* function MyApp_Messages_Edit_Hash_Key_Lang_Cell, Parameter list: $edit,$path,$file,$hashkey,$hash,$key,$lkey,$value
    //*
    //* Creates cell with 
    //*

    function MyApp_Messages_Edit_Hash_Key_Lang_Cell($edit,$path,$file,$hashkey,$hash,$key,$lkey,$value)
    {
        $row=array();
        
        $language=preg_replace('/^_/',"",$lkey);
        if (empty($language)) { $language=$this->ApplicationObj()->Language_Default; }
        
        $rkey=$this->MyApp_Messages_Edit_Hash_Key_Lang_CGI_Name($hashkey,$key,$lkey);

        if ($edit==1)
        {
            if (!preg_match('/\n/',$value))
            {
                $size=strlen($value);
                $value=$this->Html_Input("TEXT",$rkey,$value,array("SIZE" => $size));
            }
            else
            {
                $values=preg_split('/\n/',$value);
                $value=$this->Html_Input_Area($rkey,count($values),50,$value);
            }
        }
        
        $row=array($language,$value);
       
        return array($row);
    }

    //*
    //* function MyApp_Messages_Edit_Key_Language_Update, Parameter list: $hashkey,&$hash,$key,$lkey
    //*
    //* Updates $hash $key, for all languege $lkey.
    //*

    function MyApp_Messages_Edit_Key_Language_Update($hashkey,&$hash,$key,$lkey)
    {
        $updateds=0;
        
        $rkey=$key.$lkey;

        $value="";
        if (!empty($hash[ $rkey ])) { $value=$hash[ $rkey ]; }

        $newvalue=$this->MyApp_Messages_Edit_Hash_Key_Lang_CGI_Value($hashkey,$key,$lkey);

        if (!is_array($value) && $value!=$newvalue)
        {
            $hash[ $rkey ]=$newvalue;
            $updateds=1;
        }
        
        return $updateds;
     }


}

?>