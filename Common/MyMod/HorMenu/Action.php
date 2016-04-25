<?php

trait MyMod_HorMenu_Action
{
    //*
    //* function MyMod_HorMenu_Action, Parameter list: $pactions,$cssclass="",$id="",$item=array(),$title="",$caction=""
    //*
    //* Generates and prints menu of actions as in $pactions,
    //* using $cssclass as CSS class parameter to ActionEntry.
    //* Prints horisontal menu of Singular and Plural actions.
    //*

    function MyMod_HorMenu_Action($pactions,$cssclass="",$id="",$item=array(),$title="",$caction="")
    {
        if (empty($cssclass)) { $cssclass="ptablemenu"; }
        if (empty($caction))  { $caction=$this->MyActions_Detect(); }

        if (empty($item)) { $item=$this->ItemHash; }

        $args=$_SERVER[ "QUERY_STRING" ];
        $hrefs=array();

        $included=array();
        foreach ($pactions as $action)
        {
            $raction=$action;
            $res=$this->MyAction_Allowed($action,$item);

            if (!empty($this->Actions[ $action ][ "AltAction" ]))
            {
                if (!$res || $caction==$action)
                {
                    $raction=$this->Actions[ $action ][ "AltAction" ];
               }
            }

            if (!empty($included[ $raction ])) { continue; }

            //Exlude both - or just one
            $included[ $raction ]=1;
            $included[ $action ]=1;

            if ($res)
            {
                if ($caction!=$action)
                {
                    array_push
                    (
                       $hrefs,
                       $this->MyActions_Entry($action,$item,1,$cssclass)
                    );
                }
                elseif (
                          $raction
                          &&
                          $raction!=$action
                          &&
                          $this-> MyAction_Allowed($raction,$item)
                          &&
                          !empty($this->Actions[ $raction ])
                       )
                {
                     array_push
                    (
                       $hrefs,
                       $this->MyActions_Entry($raction,$item,1,$cssclass)
                    );
                }
                else
                {
                    $itemname=$this->GetItemName();

                    $name=$this->Actions[ $action ][ "Name" ];
                    $name=preg_replace('/#ID/',$id,$name);
                    $name=preg_replace('/#ItemName/',$this->ItemName,$name);
                    $name=preg_replace('/#ItemsName/',$this->ItemsName,$name);

                    array_push($hrefs,$this->SPAN($name,array("CLASS" => 'inactivemenuitem')));
                }
            }
       }

        return 
            preg_replace('/#ID/',$id,$this->HRefMenu($title,$hrefs)).
            $this->BR();
    }
}

?>