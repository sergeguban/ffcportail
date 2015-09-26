<?php
class RandomGeneratorComponent  extends Component{
    
    
   function generateWord ($size=5, $possible = "12346789abcdefghijklmnopqrstuvwxyz")
   {
      $result = "";
      $length = strlen($possible);

      $i = 0;

      while ($i < $size) {
         $char = substr($possible, mt_rand(0, $length-1), 1);
         $result .= $char;
         $i++;
      }
      return $result;

   }
    
    
}

?>