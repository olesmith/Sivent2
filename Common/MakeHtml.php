<?php

include_once("MakeCGI.php");
include_once("MakeOptions.php");

include_once("MakeHtml/Input.php");
include_once("MakeHtml/Form.php");
include_once("MakeHtml/Tags.php");
include_once("MakeHtml/CSS.php");
include_once("MakeHtml/Table.php");

trait MakeHtml
{
    use
        MakeOptions,MakeCGI,
        MakeHtml_Tags,
        MakeHtml_Form,
        MakeHtml_Input,
        MakeHtml_CSS,
        MakeHtml_Table;


}
?>