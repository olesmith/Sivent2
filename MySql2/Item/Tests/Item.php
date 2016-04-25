<?php


class ItemTestsItem extends ItemBackRefs
{
    //*
    //* function TestItem, Parameter list: $item=array()
    //*
    //* Tests item data according to prescribed data definitions.
    //* Messages are stored in $data."_Message" keys of item.
    //* Modified item is returned.
    //*


    function TestItem($item=array())
    {
        if (count($item)==0) { $item=$this->ItemHash; }

        $item=$this->ReadItemDerivedData($item);

        $messages=array();
        $nerrors=0;

        if (!$item) { $item=array(); }

        foreach ($item as $data => $value)
        {
            if (!isset($this->ItemData[ $data ]))
            {
                continue;
            }

            unset($item[ $data."_Message" ]);
            if ($item[ $data ]!="" && isset($this->ItemData[ $data ][ "Regexp" ]))
            {
                if (!preg_match('/'.$this->ItemData[ $data ][ "Regexp" ].'/',$item[ $data ]))
                {
                    if (isset($this->ItemData[ $data ][ "RegexpText" ]))
                    {
                        $item[ $data."_Message" ]=$this->GetRealNameKey($this->ItemData[ $data ],"RegexpText");
                    }
                    else
                    {
                        $item[ $data."_Message" ]=
                            "Não Conforme à Regexp: ".
                            $this->ItemData[ $data ][ "Regexp" ];
                    }

                    array_push
                    (
                       $messages,
                       $this->GetDataTitle($data)." '".$item[ $data ]."': ".$item[ $data."_Message" ]
                    );
                    $nerrors++;
                }
            }

            if (!empty($this->ItemData[ $data ][ "Compulsory" ]))
            {
               $value=$item[ $data ];
               if (
                      (preg_match('/^ENUM/',$this->ItemData[ $data ][ "Sql" ]) && $value=="0")
                      ||
                      (isset($this->ItemData[ $data ][ "SqlClass" ]) && $value=="0")
                      ||
                      $value==""
                   )
                {
                    $vmarker=$this->GetMessage($this->ItemDataMessages,"CompulsoryFieldTag");
                    if ($this->ItemData[ $data ][ "CompulsoryText" ])
                    {
                        $vmarker=$this->ItemData[ $data ][ "CompulsoryText" ];
                    }

                    $item[ $data."_Message" ]="<SPAN CLASS='errors'> ".$vmarker."</SPAN>";
                    array_push
                    (
                       $messages,
                       $this->GetDataTitle($data)." '".$item[ $data ]."': ".$item[ $data."_Message" ]
                    );
                    $nerrors++;
                }
            }

            if (!empty($this->ItemData[ $data ][ "Unique" ]))
            {
                if (!$this->ItemDataIsUnique($item,$data))
                {
                    $item[ $data."_Message" ]=
                        "<SPAN CLASS='errors'>&lt;&lt; ".
                        $item[ $data ].
                        ": Não Único(a)</SPAN>";
                    array_push
                    (
                       $messages,
                       $this->GetDataTitle($data)." '".$item[ $data ]."': ".$item[ $data."_Message" ]
                    );
                    
                    $nerrors++;
                }
            }

            if (!isset($item[ $data."_Message" ]) || $item[ $data."_Message" ]=="")
            {
                unset($item[ $data."_Message" ]);
            }
        }

        if ($this->TestMethod)
        {
            $method=$this->TestMethod;
            if (method_exists($this,$method))
            {
                $item=$this->$method($item);
            }
            else
            {
                $this->AddMsg("TestMethod '".$method."' undefined");
            }
        }

        unset($item[ "__Error_Messages__" ]);
        unset($item[ "__Errors__" ]);
        if ($nerrors>0)
        {
            $item[ "__Error_Messages__" ]=$messages;
            $item[ "__Errors__" ]=$nerrors;
        }

        $this->ItemHash=$item;

        return $item;
    }

}
?>