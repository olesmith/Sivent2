<?php

trait JSON_Parse
{
    
    ##! JSON_Item_Parse
    ##! 
    ##! Parses one JSON item.
    ##!
        
    function JSON_Item_Parse($json)
    {
        $item=array();
        foreach (array_keys($json) as $key)
        {
            if (is_array($json[ $key ]))
            {
                foreach (array_keys($json[ $key ]) as $rkey)
                {
                    if (is_array($json[ $key ][ $rkey ]))
                    {
                        foreach (array_keys($json[ $key ][ $rkey ]) as $rrkey)
                        {
                            if (is_array($json[ $key ][ $rkey ][ $rrkey ]))
                            {
                                foreach (array_keys($json[ $key ][ $rkey ][ $rrkey ]) as $rrrkey)
                                {
                                    if (is_array($json[ $key ][ $rkey ][ $rrkey ][ $rrrkey ]))
                                    {
                                        foreach (array_keys($json[ $key ][ $rkey ][ $rrkey ][ $rrrkey ]) as $rrrrkey)
                                        {
                                            if (is_array($json[ $key ][ $rkey ][ $rrkey ][ $rrrkey ][ $rrrrkey ]))
                                            {
                                                #More levels??
                                                var_dump("deeper???");
                                                var_dump($json[ $key ][ $rkey ][ $rrkey ][ $rrrkey ][ $rrrrkey ]);
                                            }
                                            else
                                            {
                                                $keys=array($key,$rkey,$rrkey,$rrrkey,$rrrrkey);
                                                $keys=preg_grep('/^0?$/',$keys,PREG_GREP_INVERT);
                                        
                                                $reskey=join("_",$keys);
                                                $item[ $reskey ]=$json[ $key ][ $rkey ][ $rrkey ][ $rrrkey ][ $rrrrkey ];
                                            }
                                        }
                                    }
                                    else
                                    {
                                        $keys=array($key,$rkey,$rrkey,$rrrkey);
                                        $keys=preg_grep('/^0?$/',$keys,PREG_GREP_INVERT);
                                        
                                        $reskey=join("_",$keys);
                                        $item[ $reskey ]=$json[ $key ][ $rkey ][ $rrkey ][ $rrrkey ];
                                    }
                                }
                                
                            }
                            else
                            {
                                $reskey=join("_",array($key,$rkey,$rrkey));
                                $item[ $reskey ]=$json[ $key ][ $rkey ][ $rrkey ];
                            }
                        }
                    }
                    else
                    {
                        $reskey=join("_",array($key,$rkey));
                        $item[ $reskey ]=$json[ $key ][ $rkey ];
                    }
                        
                }
            }
            else
            {
                $item[ $key ]=$json[ $key ];
            }

            
        }

        return $item;
    }
    
    ##! JSON_Item_Parse
    ##! 
    ##! Parses JSON $items.
    ##!
        
    function JSON_Items_Parse($json)
    {
        $items=array();
        foreach (array_keys($json) as $jid)
        {
            $item=$this->JSON_Item_Parse($json[ $jid ]);
            array_push($items,$item);
        }

        foreach (array_keys($items) as $id)
        {
            foreach (array_keys($items[ $id ]) as $key)
            {
                $items[ $id ][ $key ]=preg_replace('/^\s*/',"",$items[ $id ][ $key ]);
                $items[ $id ][ $key ]=preg_replace('/\s*$/',"",$items[ $id ][ $key ]);
            }
        }
        
        return $items;
    }
}
?>