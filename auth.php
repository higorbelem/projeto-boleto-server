<?php
   
   function auth($usr, $psw){ 
        if($usr != 'admin' || $psw != 'admin'){
            exit();
        }
    }
   
?>

