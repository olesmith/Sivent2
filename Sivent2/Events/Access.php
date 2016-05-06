<?php

class MyInscriptionsAccess extends ModulesCommon
{
    /* var $Access_Methods=array */
    /* ( */
    /*    "Show"   => "CheckShowAccess", */
    /*    "Edit"   => "CheckEditAccess", */
    /*    "Delete"   => "CheckDeleteAccess", */
    /* ); */

    /* //\* */
    /* //\* function CheckShowAccess, Parameter list: $item */
    /* //\* */
    /* //\* Checks if $item may be viewed. Admin may - */
    /* //\* and Person, if LoginData[ "ID" ]==$item[ "ID" ] */
    /* //\* Activated in System::Friends::Profiles. */
    /* //\* */

    /* function CheckShowAccess($item) */
    /* { */
    /*     if (empty($item)) { return TRUE; } */
        
    /*     $res=FALSE; */
    /*     if (preg_match('/^(Friend)$/',$this->Profile())) */
    /*     { */
    /*         if ( */
    /*               !empty($item[ "Friend" ]) */
    /*               && */
    /*               $item[ "Friend" ]==$this->LoginData("ID") */
    /*            ) */
    /*         { */
    /*             $res=TRUE; */
    /*         } */
    /*     } */
    /*     elseif (preg_match('/^Coordinator$/',$this->Profile())) */
    /*     { */
    /*         $res=TRUE; */
    /*     } */
    /*     elseif (preg_match('/^(Admin|Public)$/',$this->Profile())) */
    /*     { */
    /*         $res=TRUE; */
    /*     } */

    /*     return $res; */
    /* } */

    /* //\* */
    /* //\* function CheckEditAccess, Parameter list: $item */
    /* //\* */
    /* //\* Checks if $item may be edited. Admin may - */
    /* //\* and Person, if LoginData[ "ID" ]==$item[ "ID" ]. */
    /* //\* Activated in  System::Friends::Profiles. */
    /* //\* */

    /* function CheckEditAccess($item) */
    /* { */
    /*     $res=FALSE; */
    /*     if (preg_match('/^(Friend)$/',$this->Profile())) */
    /*     { */
    /*         if ( */
    /*               !empty($item[ "Friend" ]) */
    /*               && */
    /*               $item[ "Friend" ]==$this->LoginData("ID") */
    /*            ) */
    /*         { */
    /*             $res=TRUE; */
    /*         } */
    /*     } */
    /*     elseif (preg_match('/^(Coordinator|Admin)$/',$this->ApplicationObj->Profile)) */
    /*     { */
    /*         $res=TRUE; */
    /*     } */
 
    /*     return $res; */
    /* } */

    /* //\* */
    /* //\* function CheckDeleteAccess, Parameter list: $item */
    /* //\* */
    /* //\* Checks if $item may be deleted. That is: */
    /* //\* No questionary data defined - and no inscriptions. */
    /* //\* */

    /* function CheckDeleteAccess($item) */
    /* {  */
    /*     $res=parent::CheckDeleteAccess($item); */

    /*     return $res; */
    /* } */
}

?>