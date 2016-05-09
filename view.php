<?php

require 'functions.php';

$title = 'Admin Table';
echo createHeader($title);

echo displayTable('AdminTable');

echo createFooter($title);

?>