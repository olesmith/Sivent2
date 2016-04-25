<?php

class TInterfaceTail extends TInterfaceHead
{

    /* //\* */
    /* //\* sub ReadSupports, Parameter list: $where,$datas=array() */
    /* //\* */
    /* //\* Read Supports according to $where */
    /* //\* */
    /* //\* */

    /* function ReadSupports($where,$datas=array()) */
    /* { */
    /*     if (empty($this->SupportsObject)) { return array(); } */
 
    /*     return $this->SupportsObj()->SelectHashesFromTable */
    /*     ( */
    /*        "", */
    /*        $where, */
    /*        $datas, */
    /*        FALSE, */
    /*        "Name" */
    /*     ); */
    /* } */


    /* //\* */
    /* //\* sub ShowSupports, Parameter list: */
    /* //\* */
    /* //\* Show Supports in middle right row. */
    /* //\* */
    /* //\* */

    /* function ShowSupports() */
    /* { */
    /*     $where=array */
    /*     ( */
    /*        "Unit" => 0, */
    /*     ); */

    /*     $supports=$this->ReadSupports($where); */
    /*     $where=array */
    /*     ( */
    /*        "Unit" => $this->GetGET("Unit"), */
    /*        "EventGroup" => 0, */
    /*        "Event" => 0, */
    /*     ); */
    /*     $supports=array_merge($supports,$this->ReadSupports($where)); */

    /*     $eventgroup=0; */
    /*     if (!empty($this->EventGroup)) */
    /*     { */
    /*         $eventgroup=$this->EventGroup[ "ID" ]; */
    /*     } */
    /*     elseif (!empty($this->Event[ "EventGroup" ])) */
    /*     { */
    /*         $eventgroup=$this->Event[ "EventGroup" ]; */
    /*     } */

    /*     if ($eventgroup>0) */
    /*     { */
    /*         $where[ "EventGroup" ]=$eventgroup; */
    /*         $supports=array_merge($supports,$this->ReadSupports($where)); */
    /*     } */

    /*     $event=0; */
    /*     if (!empty($this->Event)) */
    /*     { */
    /*         $event=$this->Event[ "ID" ]; */
    /*     } */

    /*     if ((!empty($this->Event))>0) */
    /*     { */
    /*         $where[ "Event" ]=$event; */
    /*         $supports=array_merge($supports,$this->ReadSupports($where)); */
    /*     } */

    /*     $table=array(); */
    /*     foreach ($supports as $support) */
    /*     { */
    /*         $img=$this->A */
    /*         ( */
    /*            $support[ "WWW" ], */
    /*            $this->IMG($support[ "Logo" ],$support[ "Name" ].", ".$support[ "WWW" ],0,50), */
    /*            array */
    /*            ( */
    /*               "TITLE" => $support[ "Name" ], */
    /*               "TARGET" => "_new", */
    /*            ) */
    /*         ); */

    /*         array_push($table,array($img)); */
    /*     } */


    /*     return */
    /*         $this->BR(). */
    /*         //$this->B("Patrocinadores:"). */
    /*         //$this->Html_Table("",$table). */
    /*         ""; */
    /* } */
}
?>