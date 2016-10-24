<?php

class EventsCertificates extends EventsSchedules
{
    /* //\* Moved to EventApp/MyEvents/Certificates.php */
    /* //\* function Event_Certificates_Has, Parameter list: $item */
    /* //\* */
    /* //\* Returns true or false, whether event should provide certificates. */
    /* //\* */

    /* function Event_Certificates_Has($item=array()) */
    /* { */
    /*     if (empty($item)) { $item=$this->Event(); } */

    /*     $res=FALSE; */
    /*     if (!empty($item[ "Certificates" ]) && $item[ "Certificates" ]==2) */
    /*     { */
    /*         $res=TRUE; */
    /*     } */

    /*     return $res; */
    /* } */
    
    /* //\* */
    /* //\* function Event_Certificates_Published, Parameter list: $item */
    /* //\* */
    /* //\* Returns true or false, whether event should provide certificates. */
    /* //\* */

    /* function Event_Certificates_Published($item=array()) */
    /* { */
    /*     if (empty($item)) { $item=$this->Event(); } */

    /*     $res=FALSE; */
    /*     if (!empty($item[ "Certificates_Published" ]) && $item[ "Certificates_Published" ]==2) */
    /*     { */
    /*         $res=TRUE; */
    /*     } */

    /*     return $res; */
    /* } */


    
    /* //\* */
    /* //\* function Event_Certificate_Table, Parameter list: $edit,$item,$group */
    /* //\* */
    /* //\* Creates info table concerning Certificates. */
    /* //\* */

    /* function Event_Certificate_Table($edit,$item,$group) */
    /* { */
    /*     $rdatas=$this->GetGroupDatas($group); */

    /*     if ($item[ "Certificates" ]!=2) */
    /*     { */
    /*         $rdatas=array("Certificates"); */
    /*     } */

    /*     return */
    /*         $this->H(3,$this->GetRealNameKey($this->ItemDataSGroups[ $group ])). */
    /*         $this->MyMod_Item_Table_Html($edit,$item,$rdatas). */
    /*         ""; */
    /* } */
}

?>