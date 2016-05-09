<?php

class MyEventAppMail extends MyEventAppMenues
{
    //*
    //* function MailInfo, Parameter list: 
    //*
    //* Returns mail info, that is, content of $this->MailInfo.
    //* Supposed to be overwritten by and ApplicationObj.
    //*

    function MailInfo()
    {
        $mailinfo=parent::MailInfo();
        $unit=$this->Unit();
        if (!empty($unit))
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

            $event=$this->Event();
            if (!empty($event))
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
        }

        return $mailinfo;
    }
}

?>