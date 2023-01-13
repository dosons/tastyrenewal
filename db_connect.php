<?php
    // 로컬호스트용
   //$db = new PDO("mysql:host=localhost;port=3306;dbname=aapp76","aapp76","june7933@"); 
try {

   //서버용
   $db = new PDO("mysql:host=tastyrenewal.cafe24.com; port=3306;dbname=tastyrenewal","tastyrenewal","shingu1617@");
   $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   } catch (PDOException $e) {
    exit($e->getMessage());
} 

?>