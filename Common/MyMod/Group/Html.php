<?php

trait MyMod_Group_HTML
{
     //*
    //* function MyMod_Group_HTML, Parameter list: ($title="",$edit=0,$datas=array(),$items=array(),$countdef=array(),$titles=array(),$sumvars=TRUE,$cgiupdatevar="Update")
    //*
    //* Returns Html version of Items table. Only in SiMON!!!
    //* 

    function MyMod_Group_HTML($title="",$edit=0,$datas=array(),$items=array(),$countdef=array(),$titles=array(),$sumvars=TRUE,$cgiupdatevar="Update")
    {
        return
            $this->Html_Table
            (
               $this->MyMod_Data_Titles($datas),
               $this->MyMod_Group_Datas_Table
               (
                  $title,
                  $edit,
                  $datas,
                  $items,
                  $countdef,
                  $titles,
                  $sumvars,
                  $cgiupdatevar
               ),
               array(),
               array(),
               array(),
               TRUE,TRUE
            ).
            "";
    }
}

?>