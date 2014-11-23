<?php

include 'User.php';

$result = User::createuser("lafickens", "abcd", "bcdf");
var_dump($result);

?>