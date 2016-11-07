<?php

class Friends_Access extends Friends_Clean
{
    //*
    //* function CheckDownloadAccess, Parameter list: $item=array()
    //*
    //* Checks if $item may be downloaded. Admin may -
    //* and Person, if LoginData[ "ID" ]==$item[ "ID" ]
    //* Activated in System::Friends::Profiles.
    //*

    function CheckDownloadAccess($item=array())
    {
        if (empty($item)) { return TRUE; }

        return TRUE;
    }
}

?>