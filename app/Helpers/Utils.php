<?php

namespace App\Helpers;

use Illuminate\Support\Collection;

class Utils
{
    public static function varExport($var, $indent = '')
    {
        switch (gettype($var)) {
            case 'string':
                return '"'.addcslashes($var, "\\\$\"\r\n\t\v\f").'"';
            case 'array':
                $indexed = array_keys($var) === range(0, count($var) - 1);
                $r = [];
                foreach ($var as $key => $value) {
                    $r[] = "$indent    "
                        .($indexed ? '"'.$key.'" => ' : self::varExport("$key").' => ')
                        .self::varExport($value, "$indent    ");
                }
                return "[\n".implode(",\n", $r)."\n".$indent.']';
            case 'boolean':
                return $var ? 'true' : 'false';
            default:
                return var_export($var, true);
        }
    }
    public static function keyValues($values, $keys)
    {
        $values = $values instanceof Collection ? $values : new Collection($values);
        return $values->map(function ($values) use ($keys) {
            return array_combine($keys, $values);
        });
    }
    public static function asArray($value)
    {
        if (is_array($value)) {
            return $value;
        }
        return array_filter(array_map(function ($item) {
            return trim($item);
        }, explode(',', $value)));
    }

    public static function recursive_implode(array $a1)
    {
      $flatten = function( $array , $keySeparator = '.' ) use ( & $flatten )
        {
        	if( is_array( $array ) ) {
        		foreach( $array as $name => $value ) {
        			$f = $flatten( $value , $keySeparator );
        			if( is_array( $f ) ) {
        				foreach( $f as $key => $val ) {
        					$array[ $name . $keySeparator . $key ] = $val;
        				}
        				unset( $array[ $name ] );
        			}
        		}
        	}
        	return $array;
        };

        return $flatten($a1, ' | ');
    }

}
