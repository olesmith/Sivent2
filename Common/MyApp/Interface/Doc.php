<?php

include_once("Doc/Head.php");
include_once("Doc/Tail.php");


trait MyApp_Interface_Doc
{
    use MyApp_Interface_Doc_Head,MyApp_Interface_Doc_Tail;
}

?>