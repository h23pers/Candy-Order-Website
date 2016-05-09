<?php
require 'functions.php';


$title = 'Candy.com';
echo createHeader($title);
if ($_GET['action']=="submit") {
  echo processForm();
}
else {
  echo createForm();
}
echo createFooter($title);



?>