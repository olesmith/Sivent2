<?php


class HandleZip extends HandleFiles
{
    /* //\* */
    /* //\* function HandleZip, Parameter list:  */
    /* //\* */
    /* //\* Handles Module zipping of file. */
    /* //\* */

    /* function HandleZip() */
    /* { */
    /*     $this->MyMod_Handle_Zip(); */
        
    /* } */




    /* //\* */
    /* //\* function ZipItemFileField, Parameter list: $zip,$item,$data */
    /* //\* */
    /* //\* Will do the actual zipping on $item. */
    /* //\* */

    /* function ZipItemFileField_000($zip,$item,$data) */
    /* { */
    /*     $ftime=$this->MySqlItemValue("","ID",$item[ "ID" ],$data."_Time"); */
    /*     if (empty($ftime)) { return; } */

    /*     $contents=$this->DB2FileContents */
    /*     ( */
    /*        $this->MySqlItemValue("","ID",$item[ "ID" ],$data."_Contents") */
    /*     ); */

    /*     $file=$item[ $data ]; */
    /*     $tmpname="/tmp/".basename($file); */
    /*     file_put_contents($tmpname, $contents); */

    /*     $zip->addFile($tmpname,basename($file));  */

    /*     return $tmpname; */
    /* } */
}

?>