<?php

class Backup extends ModPerms
{
    function MySqlTableFields($table)
    {
        $table=$this->SqlTableName($table);

        $query='SHOW COLUMNS FROM '.$table;
        $result = $this->QueryDB($query);

        $titles=array("Field","Type","Null","Default","Extra");
        $fields=array();

        $m=0;
        while ($row = mysql_fetch_assoc($result))
        {
            $fields[$m]=$row;
            $m++;
        }

        mysql_free_result($result);

        return $fields;
    }


    //*
    //* function MySqlTableDef2Sql, Parameter list: $table
    //*
    //* Makes a SQL dump of Table $table's definition part.
    //*
    //* 

    function MySqlTableDef2Sql($table)
    {
        $table=$this->SqlTableName($table);
        $fields=$this->MySqlTableFields($table);

        $sql=array("CREATE TABLE IF NOT EXISTS `".$table."`\n(");

        $rfields=array();
        foreach ($fields as $id => $field)
        {
            $rfields[ $field[ "Field" ] ]=$field;
        }

        $fields=array_keys($rfields);
        sort($fields);
        foreach ($fields as $id => $fieldname)
        {
            $field= $rfields[ $fieldname ];
           $fsql= 
               "`".$field[ "Field" ]."` ".
               $field[ "Type" ];

           if ($field[ "Null" ]=="NO")
           {
               $fsql.=" NOT NULL";
           }

           if ($field[ "Key" ]=="PRI")
           {
               $fsql.=" PRIMARY KEY";
           }

           if ($field[ "Default" ]!=NULL)
           {
               $fsql.=" DEFAULT '".$field[ "Default" ]."'";
           }

           if ($field[ "Extra" ]!=NULL)
           {
               $fsql.=" ".$field[ "Extra" ];
           }

           array_push($sql,$fsql.",");

        }
        $sql[ count($sql)-1 ]=preg_replace('/,$/',"",$sql[ count($sql)-1 ]);

        $query="SELECT MAX(ID) AS ID FROM ".$table;
        $result = $this->QueryDB($query);
        $res=mysql_fetch_array($result);

        array_push($sql,") ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=".($res[0]+1)." ;\n");

        return $sql;
    }
    //*
    //* function MySqlBackupTable, Parameter list: $table
    //*
    //* Makes a SQL dump of Table $table
    //*
    //* 

    function MySqlBackupTable($table)
    {
        $table=$this->SqlTableName($table);
        $fields=$this->MySqlTableFields($table);
        $items=$this->SelectHashesFromTable($table);

        if (count($items)==0)
        {
            return array();
        }

        $fieldnames=array();
        foreach ($fields as $id => $field)
        {
            array_push($fieldnames,$field[ "Field" ]);
        }

        $sql=array
        (
            "INSERT INTO `".$table."`",
            "(`".join("`, `",$fieldnames)."`) VALUES",
        );
 

        foreach ($items as $id => $item)
        {
            $values=array();
            foreach ($fields as $id => $field)
            {
                $value=utf8_encode($item[ $field[ "Field" ] ]);
                $value=addslashes($value);
                $value=preg_replace('/\n/',"\\r\\n",$value);
                $value=preg_replace('/\t/',"\\t",$value);
                array_push($values,$value);
            }

            array_push($sql,"('".join("', '",$values)."'),");
        }

        $sql[ count($sql)-1 ]=preg_replace('/,$/',";",$sql[ count($sql)-1 ]);
        return $sql;
    }

    //*
    //* function MySqlBackupDB, Parameter list: $table
    //*
    //* Makes a SQL dump of all Tables in DB
    //*
    //* 

    function MySqlBackupDB()
    {
        $tables=$this->Sql_Table_Names();
        $text=array
        (
           'SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";'.
           ''.
           ''.
           '/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;'.
           '/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;'.
           '/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;'.
           '/*!40101 SET NAMES utf8 */;',
        );

        foreach ($tables as $id => $table)
        {
            $defsql=$this->MySqlTableDef2Sql($table);
            $itemsql=$this->MySqlBackupTable($table);

            array_push($text,join("\n",$defsql));
            array_push($text,join("\n",$itemsql));
        }
        $text=join("\n\n",$text);


        $filename=$this->DBHash[ "DB" ].".".$this->LTimeStamp2DateSort().".sql";

        $this->MyMod_Doc_Header_Send("sql",$filename);

        echo $text;
    }


    //*
    //* function BackupForm, Parameter list: $table
    //*
    //* Creates form to do Backup
    //*
    //* 

    function BackupForm()
    {
        $go=$this->GetGETOrPOST("Go");
        if ($go==1)
        {
            $this->MySqlBackupDB();
        }
        else
        {
            $this->MyApp_Interface_Head();
            echo
                $this->H(2,"Para Efetuar Backup do Sistema, clique em BACKUP abaixo").
                $this->StartForm("?Action=Backup&Go=1").
                $this->MakeHidden("Go",1).
                "<CENTER>".$this->Button("submit","BACKUP")."</CENTER>".
                $this->EndForm();
          }

    }

}

?>