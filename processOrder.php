<?php
require 'functions.php';

processOrder($_GET['id']);
header("location: /project2/admin.php");



?>