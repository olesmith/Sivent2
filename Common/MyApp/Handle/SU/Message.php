<?php

trait MyApp_Handle_SU_Message
{

    //*
    //* function MyApp_Handle_SU_Message_Or_Do, Parameter list:
    //*
    //* Returns the handle message - or tries to redirect.
    //*

    function MyApp_Handle_SU_Message_Or_Do()
    {
        $msg="";
        if ($this->GetPOST("Shift")==1)
        {
            $user=$this->MyApp_Handle_SU_CGI_Value();
            if (!empty($user))
            {
                $this->MyApp_Handle_SU_Do();
            }

            //Still here, user id invalid.
            $msg=$this->H(4,"Usário Inválido, tente de novo");
        }

        return $msg;
    }
}

?>