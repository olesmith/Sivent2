<?php

include_once("Inscription/Read.php");
include_once("Inscription/Cells.php");
include_once("Inscription/Rows.php");
include_once("Inscription/Table.php");
include_once("Inscription/Update.php");
include_once("Inscription/Form.php");
include_once("Inscription/Conflicts.php");

class PreInscriptionsInscription extends PreInscriptionsInscriptionConflicts
{
    var $Submissions=array();
    var $PreInscriptions=array();
    
}

?>