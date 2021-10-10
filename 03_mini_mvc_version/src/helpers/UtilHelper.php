<?php 
    namespace app\helpers;

    class UtilHelper {
      /**
       * [randomString description]
       * @param  [int] $n [number of characters]
       * @return [string]    [randomized string of supplied number of chars]
       */
      public static function randomString($n)
        {
          $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
          $str = '';

          for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($chars) - 1);
            $str .= $chars[$index];
          }

          return $str;      

        }
    }
 ?>
