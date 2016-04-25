<?php


class DataSGroups extends HashesData
{
    /* //\* */
    /* //\* function SGroupCGI2Item, Parameter list: $group,&$item */
    /* //\* */
    /* //\* Reads CGI POST SGroups data to $item. */
    /* //\* */

    /* function SGroupCGI2Item($group,&$item) */
    /* { */
    /*     $updatedata=array(); */
    /*     foreach ($this->MyMod_Item_Group_Data($group,TRUE) as $data) */
    /*     { */
    /*          if ($this->MyMod_Data_Access($data,$item)>=2) */
    /*          { */
    /*             if (preg_match('/^FILE$/',$this->ItemData[ $data ][ "Sql" ])) */
    /*             { */
    /*                 array_push($updatedata,$data); */
    /*             } */
    /*             else */
    /*             { */
    /*                 $value=$this->GetPOST($data); */
    /*                 if (empty($item[ $data ]) || $item[ $data ]!=$value) */
    /*                 { */
    /*                     $item[ $data ]=$value; */
    /*                     array_push($updatedata,$data); */
    /*                 } */
    /*             } */
    /*         } */
    /*     } */

    /*     return $updatedata; */
    /* } */

    /* //\* */
    /* //\* function SGroupsCGI2Item, Parameter list: $groups,&$item */
    /* //\* */
    /* //\* Reads all CGI POST SGroups data to $item. */
    /* //\* */

    /* function SGroupsCGI2Item($groups,&$item) */
    /* { */
    /*     $updatedata=array(); */
    /*     foreach ($groups as $group) */
    /*     { */
    /*         $updatedata=array_merge */
    /*         ( */
    /*             $updatedata, */
    /*             $this->SGroupCGI2Item($group,$item) */
    /*         ); */
    /*     } */

    /*     return $updatedata; */
    /* } */

    /* //\* */
    /* //\* function SGroupItemDataIsDefined, Parameter list: $group,$item,$undefs=array() */
    /* //\* */
    /* //\* Tests whether all SGroup data is defined. Returns undefined data. */
    /* //\* */

    /* function SGroupItemDataIsDefined($group,$item,$undefs=array()) */
    /* { */
    /*     if (empty($this->Actions)) { $this->InitActions(); } */

    /*     $datas=$this->MyMod_Item_Group_Data($group,TRUE); */
    /*     $rdatas=array(); */
    /*     foreach ($datas as $data) */
    /*     { */
    /*         if (!empty($this->ItemData[ $data ])) */
    /*         { */
    /*             array_push($rdatas,$data); */
    /*         } */
    /*     } */


    /*     $this->MakeSureWeHaveRead("",$item,$rdatas); */

    /*     foreach ($datas as $data) */
    /*     { */
    /*         if (!empty($this->Actions[ $data ])) { continue; } */
    /*         if (!$this->ItemData[ $data ][ "Compulsory" ]) {  continue; } */

    /*         if (empty($item[ $data ])) */
    /*         { */
    /*             $undefs[ $data ]=TRUE; */
    /*         }             */
    /*     } */

    /*     return $undefs; */
    /* } */

    /* //\* */
    /* //\* function SGroupsItemIsDefined, Parameter list: $groups,$item */
    /* //\* */
    /* //\* Teests whether all SGroup data is defined. */
    /* //\* */

    /* function SGroupsItemDataIsDefined($groups,$item) */
    /* { */
    /*     $undefs=array(); */
    /*     foreach ($groups as $group) */
    /*     { */
    /*         $undefs=$this->SGroupItemDataIsDefined($group,$item,$undefs);        */
    /*     } */

    /*     return array_keys($undefs); */
    /* } */

    /* //\* */
    /* //\* function SGroupTable, Parameter list: $edit,$group,$item,$plural=FALSE */
    /* //\* */
    /* //\* Generates SGroupsTable, according to layout in $groupdef. */
    /* //\* */

    /* function SGroupTable($edit,$group,$item,$plural=FALSE) */
    /* { */
    /*     if (!empty($this->ItemDataSGroups[ $group ][ "GenTableMethod" ])) */
    /*     { */
    /*         $method=$this->ItemDataSGroups[ $group ][ "GenTableMethod" ]; */

    /*         return $this->$method($edit,$item,$group); */
    /*     } */

    /*     $pre=""; */
    /*     if (!empty($this->ItemDataSGroups[ $group ][ "PreText" ])) */
    /*     { */
    /*         $pre=$this->ItemDataSGroups[ $group ][ "PreText" ]; */
    /*     } */

    /*     $post=""; */
    /*     if (!empty($this->ItemDataSGroups[ $group ][ "PostText" ])) */
    /*     { */
    /*         $post=$this->ItemDataSGroups[ $group ][ "PostText" ]; */
    /*     } */

    /*     $table=""; */
    /*     if (!empty($this->ItemDataSGroups[ $group ][ "Data" ])) */
    /*     { */
    /*         $table= */
    /*               $this->ItemTable */
    /*               ( */
    /*                  $edit, */
    /*                  $item, */
    /*                  TRUE, */
    /*                  $this->ItemDataSGroups[ $group ][ "Data" ], */
    /*                  array(), */
    /*                  $plural, */
    /*                  FALSE, */
    /*                  FALSE */
    /*                ); */

    /*         if ($this->SGroups_NumberItems) */
    /*         { */
    /*             $n=1; */
    /*             foreach (array_keys($table) as $id) */
    /*             { */
    /*                 array_unshift($table[ $id ],$this->B($n.":")); */
    /*                 $n++; */
    /*             } */
    /*         } */
           
    /*         $title=$this->GetRealNameKey($this->ItemDataSGroups[ $group ],"Name"); */
    /*         if ($edit==1) { $title.=$this->SUP("","&dagger;"); } */
           
    /*         array_unshift($table,$this->H(3,$title)); */

    /*         $table= */
    /*            $this->Html_Table */
    /*            ( */
    /*               "", */
    /*               $table, */
    /*               array("WIDTH" => '100%'), */
    /*               array(), */
    /*               array(), */
    /*               TRUE, */
    /*               TRUE */
    /*             ) */
    /*         ; */
    /*     } */

    /*     return  */
    /*         $pre. */
    /*         $table. */
    /*         $post. */
    /*         ""; */
    /* } */

    /* //\* */
    /* //\* function SGroupTables, Parameter list: $groupdefs,$item,$buttons="",$plural=FALSE */
    /* //\* */
    /* //\* Generates SGroupsTables, according to layout in $groupdefs. */
    /* //\* */

    /* function SGroupTables($groupdefs,$item,$buttons="",$plural=FALSE) */
    /* { */
    /*     $tables=array(); */
    /*     $redit=0; */
    /*     foreach ($groupdefs as $groupdef) */
    /*     { */
    /*         $row=array(); */
    /*         foreach ($groupdef as $group => $edit) */
    /*         { */
    /*             $redit=$this->Max($edit,$redit); */
                
    /*             $res=$this->MyMod_Item_Group_Allowed */
    /*             ( */
    /*                $this->ItemDataSGroups[ $group ], */
    /*                $item */
    /*             ); */

    /*             if ($res) */
    /*             { */
    /*                 array_push */
    /*                 ( */
    /*                    $row, */
    /*                    $this->SGroupTable($edit,$group,$item,$plural) */
    /*                 ); */
    /*             } */
    /*             else { array_push($row,$group); } */
                
    /*         } */

    /*         if (!empty($row)) */
    /*         { */
    /*             array_push($tables,$row); */

    /*             if ($redit==1 && !empty($buttons)) */
    /*             { */
    /*                 array_push($tables,$buttons); */
    /*             } */
    /*         } */
    /*     } */


    /*     return $tables; */
    /* } */

    /* //\* */
    /* //\* function UpdateSGroupTablesForm, Parameter list: $updatekey,$groupdefs,&$item */
    /* //\* */
    /* //\* Update SGroup tables form. */
    /* //\* */

    /* function UpdateSGroupTablesForm($updatekey,$groupdefs,&$item) */
    /* { */
    /*     if ($this->GetPOST($updatekey)!=1) */
    /*     { */
    /*         return; */
    /*     } */

    /*     $groups=$this->InscriptionEditGroups($groupdefs); */

    /*     $ritem=$item; */
    /*     $updatedatas=$this->SGroupsCGI2Item */
    /*     ( */
    /*        $groups, */
    /*        $ritem */
    /*     ); */

    /*     $item=$this->UpdateItem($item,$updatedatas); */
    /*     $item=$this->PostProcessItem($item); */
    /* } */

    /* //\* */
    /* //\* function ShouldEditSGroupTablesForm, Parameter list: $groupdefs */
    /* //\* */
    /* //\* Generates SGroupsTables, according to layout in $groupdefs. */
    /* //\* */

    /* function ShouldEditSGroupTablesForm($groupdefs) */
    /* { */
    /*     foreach ($groupdefs as $groupdef) */
    /*     { */
    /*         foreach ($groupdef as $group => $edit) */
    /*         { */
    /*             if ($edit) { return TRUE; } */
    /*         } */
    /*     } */

    /*     return FALSE; */
    /* } */

    /* //\* */
    /* //\* function SGroupTablesForm, Parameter list: $updatekey,$groupdefs,$item,$mayupdate=TRUE */
    /* //\* */
    /* //\* Generates SGroupsTables, according to layout in $groupdefs. */
    /* //\* */

    /* function SGroupTablesForm($updatekey,$groupdefs,$item,$mayupdate=TRUE) */
    /* { */
    /*     if ($mayupdate && $this->GetPOST($updatekey)==1) */
    /*     { */
    /*         $this->UpdateSGroupTablesForm($updatekey,$groupdefs,$item); */
    /*     } */

    /*     $edit=$this->ShouldEditSGroupTablesForm($groupdefs); */

    /*     $pre=""; */
    /*     $post=""; */
    /*     $buttons=""; */
    /*     if ($edit==1) */
    /*     { */
    /*         $pre= */
    /*             $this->StartForm(). */
    /*             ""; */


    /*         $buttons= */
    /*             $this->Buttons(). */
    /*             ""; */
    /*         $post= */
    /*             $this->MakeHidden($updatekey,1). */
    /*             $this->EndForm(). */
    /*             ""; */
    /*     } */

    /*     return */
    /*         $pre. */
    /*         $this->MyMod_Item_Group_Tables_Html($groupdefs,$item,$buttons). */
    /*         $post. */
    /*         ""; */
    /* } */
}
?>