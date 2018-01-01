<?php

trait MyEmail_Recipients
{
    //*
    //* function MyEmail_Recipient_2_Email, Parameter list: $mailhash,$key
    //*
    //* Detects recipient $key.s.
    //*

    function MyEmail_Recipient_2_Email($mailhash,$key)
    {
        $tos=array();
        if (!empty($mailhash[ $key ]))
        {
            if (!is_array($mailhash[ $key ]))
            {
                $tos=preg_split('/\s*[,;]\s*/',$mailhash[ $key ]);
            }
            else
            {
                $tos=$mailhash[ $key ];
            }
        }

        return $tos;
    }


    //*
    //* function MyEmail_Email_2_Hash, Parameter list: $mailhash
    //*
    //* Returns hash with To, CC and BCC as lists.
    //*

    function MyEmail_Recipients_2_Hash($mailhash)
    {
        foreach (array("To","CC","BCC") as $key)
        {
            $mailhash[ $key ]=$this->MyEmail_Recipient_2_Email($mailhash,$key);
        }

        return $mailhash;
    }

 }
?>