<?php

class MyEventApp_Mail extends MyEventApp_Menues
{
    //*
    //* function MyApp_Mail_Info_Unit, Parameter list: $unit,&$mailinfo
    //*
    //* Adds $unit email options to mailinfo.
    //*

    function MyApp_Mail_Info_Unit($unit,&$mailinfo)
    {
        foreach ($this->Unit2MailInfo as $key)
        {
            if (
                  !empty($unit[ $key ])
                  &&
                  $mailinfo[ $key ]!=$unit[ $key ]
                )
           {
               $mailinfo[ $key ]=$unit[ $key ];
           }
        }
    }
    
    //*
    //* function MyApp_Mail_Info_Unit, Parameter list: $event,&$mailinfo
    //*
    //* Adds $event email options to mailinfo.
    //*

    function MyApp_Mail_Info_Event($event,&$mailinfo)
    {
        foreach ($this->Event2MailInfo as $key)
        {
            if (
                  !empty($event[ $key ])
                  &&
                  $mailinfo[ $key ]!=$event[ $key ]
               )
            {
                $mailinfo[ $key ]=$event[ $key ];
            }
        }
    }
    
    //*
    //* function MyApp_Mail_Info_Get, Parameter list: $key=""
    //*
    //* Returns mail info, that is, content of $this->MailInfo.
    //* Supposed to be overwritten by and ApplicationObj.
    //*

    function MyApp_Mail_Info_Get($key="")
    {
        if (empty($this->MailInfo))
        {
            $mailinfo=parent::MyApp_Mail_Info_Get();
            $unit=$this->Unit();
            if (!empty($unit))
            {
                $this->MyApp_Mail_Info_Unit($unit,$mailinfo);

                $event=$this->Event();
                if (!empty($event))
                {
                    $this->MyApp_Mail_Info_Event($unit,$mailinfo);
                }
            }
            
            $this->MailInfo=$mailinfo;
        }
        
        if (!empty($key))
        {
            if (!empty($this->MailInfo[ $key ]))
            {
                return $this->MailInfo[ $key ];
            }
            else
            {
                return $key;
            }
        }
        
        return $this->MailInfo;
    }
}

?>