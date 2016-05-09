<?php
require 'functions.php';

deleteOrder($_GET['id']);
header("location: /project2/admin.php");

?>