<?php

trait Curl
{
    var $Curl_Obj=NULL;
    
    function Curl_POST($url,$post)
    {
        $this->Curl_Obj=curl_init();
        $options=
            array
            (
                CURLOPT_POST => 1,
                CURLOPT_HEADER => 0,
                CURLOPT_URL => $url,
                CURLOPT_FRESH_CONNECT => 1,
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_FORBID_REUSE => 1,
                CURLOPT_TIMEOUT => 4,
                CURLOPT_POSTFIELDS => http_build_query($post),
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
            );

        $this->Curl_Options_Set($options);
        if( ! $result = curl_exec($this->Curl_Obj))
        {
            trigger_error( curl_error($this->Curl_Obj) );
        }
        
        curl_close($this->Curl_Obj);

        return $result;
    }
    
    function Curl_Options_Set($options)
    {
        curl_setopt_array($this->Curl_Obj,$options);
    }
}
?>