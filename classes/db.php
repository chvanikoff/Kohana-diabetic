<?php

/**
 * @author Roman Chvanikoff <chvanikoff@gmail.com>
 * @copyright 2011
 */

class DB extends Kohana_DB {
    
    /**
     * Wrapper for DB::expr('NULL')
     * 
     * @return Database_Expression
     */
    public static function NULL()
    {
        return DB::expr('NULL');
    }
    
    /**
     * Wrapper for DB::expr('NOW()')
     * 
     * @return Database_Expression
     */
    public static function NOW()
    {
        return DB::expr('NOW()');
    }
}