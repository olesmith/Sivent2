<?php

#include_once("Doc/Head.php");
include_once("Doc/Body.php");
include_once("Doc/Tail.php");


trait MyApp_Interface_Doc
{
    use
        MyApp_Interface_Doc_Body,
        MyApp_Interface_Doc_Tail;
}

?>