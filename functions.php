<?php  session_start();

function databaseConnect() {
	$mysqli = new mysqli("localhost", "breimern_orders", "orders1234", "breimern_orders");
	if ($mysqli->connect_errno) {
		die("Database connection failed");
	}
	else {
		return $mysqli;
	}
}	

function createHeader($title) {
	$isAdmin = "";
	$viewAdmin = "";
	if ($_SESSION['admin'] > 0){
		$isAdmin = '<a class="btn btn-info" href="addAdmin.php">Add Admin</a>';
		$viewAdmin = '<a class="btn btn-warning" href="view.php">View Accounts</a>';
	}
	$name = "Login";
	$link="";
	$style="primary";
	if (isset($_SESSION['userid'])) {
		$name = "Logout";
		$link = "?action=logout";
		$style = "danger";
	}
  return '
  <!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>'.$title.'</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Dancing+Script:700" rel="stylesheet" type="text/css">
	<style>
		h1{font-family: "Dancing Script", cursive;}
	</style>
  </head>
  <body>
  <nav class="navbar navbar-default">
	  <div class="container-fluid">
			<div class="btn-group">
			<a class="btn btn-success" href="order.php">New Order</a>
			'.$isAdmin.'
			<a class="btn btn-default" href="admin.php">View Orders</a>
			'.$viewAdmin.'
			<a class="btn btn-'.$style.' pull-right" href="login.php'.$link.'" >'.$name.'</a>
		</div>
	</nav>	
	
    <div class="container">
    	<h1 >'.$title.'</h1> 
		<br>';
		
}

function createFooter($title) {
  $year = date('Y');
  return '
    <footer>
	  <div class="panel panel-primary">
      <div class="panel-heading"></div>
      <div class="panel-body">Copyright '.$year.' '.$title.'</div>
    </div>	
	</footer>
    </div><!-- /.container -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  </body>
  </html>';
}


function createForm() {	

  return'
  <form method="post" action="order.php?action=submit">
   <div class ="row">
   <div class="col-sm-6">
   <h2>Customer Info</h2>
   </div>
   </div>
   <div class="row">'.		
   createTextField("cust_name", "Name", 8,"").
   createTextField("cust_phone", "Phone", 4,"").
   createTextField("cust_address", "Address", 12,"").
   createTextField("cust_city", "City", 6,"").
   createTextField("cust_state", "State", 3,"").
   createTextField("cust_zip", "Zip",3,"").
   '</div>
   <div class="row">
   <div class="col-sm-4">
   <h2>Candy Size</h2>
   <div class= "radio">'.
   createRadioButton("size","small","Small","").
   createRadioButton("size","medium","Medium","").
   createRadioButton("size","large","Large","").
   createRadioButton("size","extra_large","Extra Large","").
   '</div>
   </div>
   <div class="col-sm-4">
   <h2> Quantity </h2>
   <select class="form-control" name="quantity">
		<option value="1">1</option>
		<option value="2">2</option>
		<option value="3">3</option>
		<option value="4">4</option>
	</select>
	</div>
	<div class="col-sm-4">
	<h2> Candy Types </h2>'.
		createCheckBox("candy[]","Gum","Gum", "").
		createCheckBox("candy[]","Chocolate","Chocolate", "").
		createCheckBox("candy[]","Mints","Mints").
		createCheckBox("candy[]","Gummi Worms","Gummi Worms", "").
		createCheckBox("candy[]","Gummi Bears","Gummi Bears", "").
		createCheckBox("candy[]","Jelly Beans","Jelly Beans", "").
   '</div>
   </div> <!-- end of row -->
   <input type="submit" class="btn btn-success">
   <br>
   <br>
</form>';}
   
function createAdminForm() {	
	$radio_id = "employee_type";
	
	
	
	return 
	'
	<form method="post" action="addAdmin.php?action=submit">
	<h2>Admin Info</h2>
	<div class="row">'.		
	createTextField("user_name", "Admin Name", 8).'
	</div>
	<div class="row">
	'.createPasswordField("password","Password",8).'
	</div>
	
	<div class="row">		
	<div class="col-sm-4">
	<h3>Employee Type</h3>'.
	createRadioButton($radio_id, "0", "User").
	createRadioButton($radio_id, "1", "Admin").'

	</div>
	</div>
	<div class="row">
	<div class="col-sm-12">
	<button type="submit" class="btn btn-success">Submit</button>
	</div>
	</div>
	<br>
	<br>
	</form>';
}


function createTextField($id, $label, $size, $value2) {
	$errorClass = null;
	$errorSpan = null;
	$value = $_POST[$id];
	if ($_POST[$id] == "!missing!") {
		$errorClass = " has-error";
		$errorSpan = '<span class="help-block">Missing information.</span>';
		$value = "";
	}
	
	return '
	<div class="col-sm-'.$size.'">	
	<div class="form-group  '.$errorClass.'">
	 <label class="control-label" for="'.$id.'">'.$label.'</label>
	 <input type="text" class="form-control" id="'.$id.'" name="'.$id.'" placeholder="'.$label.
	 '" value="'.$value2.'"> '.$errorSpan.'
	</div>
	</div>';	
	
}

function createPasswordField($id, $label, $size) {
	$errorClass = null;
	$errorSpan = null;
	$value = $_POST[$id];
	if ($_POST[$id] == "!missing!") {
		$errorClass = " has-error";
		$errorSpan = '<span class="help-block">Missing information.</span>';
		$value = "";
	}
	
	return '
	<div class="col-sm-'.$size.'">	
	<div class="form-group  '.$errorClass.'">
	 <label class="control-label" for="'.$id.'">'.$label.'</label>
	 <input type="password" class="form-control" id="'.$id.'" name="'.$id.'" placeholder="'.$label.
	 '" value="'.$value.'"> '.$errorSpan.'
	</div>
	</div>';	
	
}


function createRadioButton($id, $value, $label, $selected) {
 $errorClass = null;
 $errorSpan = null;
 if ($_POST[$id] == "!missing!") {
  $errorClass = " has-error";
  $errorSpan = '<span class="help-block"> One option must be selected.</span>';
 }	

 return '
  <div class="form-group'.$errorClass.'">	
  <div class="radio">
    <label>
      <input type="radio" name="'.$id.'" id="'.$id.'" value="'.$value.'" '.$selected.'> '.$label.
      $errorSpan.'
    </label>
  </div>
  </div> ';
}  

function createCheckBox($name, $value, $label, $selected){	 
	$errorClass = null; 
	$errorSpan = null; 
	if ($_POST[$name] == "!missing!") {  
		$errorClass = " has-error";  
		$errorSpan = '<span class="help-block">Topping must be selected.</span>';
	}	 
	return '  
	<div class="form-group'.$errorClass.'">	  
	<div class="checkbox">    
	<label>       
		<input type="checkbox" name="'.$name.'" value="'.$value.'" '.$selected.' />'.$label.
		$errorSpan.'    
		</label> 
	</div>
	</div> ';}
	
function displayOrder() {	
	foreach ($_POST as $key => $value) {
		if (is_array($value))
		{
			$value = implode(", ", $value);
		}
		$output .=  '
			<div class="panel panel-primary">
		  	<div class="panel-heading">'.$key.'</div>
				<div class="panel-body"><p>'.$value.'</p></div>	
			</div>';
	}
	$output .= '<a class="btn btn-primary" href="order.php">Back</a>';
	return $output;
}


function insertOrder() {

	// 1. We have to connect to the database.  $mysqli is a database connection object
	
	$mysqli = databaseConnect();
	
	// 2. We get the current date and time in the form 2015-10-30 8:30:59 
	
	$orderDate = date("Y-m-d H:i:s");
	
	// 3. We take the toppings array and convert it to a comma separated string
	
	$candy_type = implode(",",$_POST['candy']);
	
	// 4. We prepare the query.  We will insert a row into the table.
	// 5. The values have to be inserted in the defined order of the table
	// 6. My table has 11 fields, the first row is an auto-increment id used as the primary key
	// 7. The other 10 fields come from the posted form. They are all strings except for pizza_quantity
	
	if (!($stmt = $mysqli->prepare("INSERT INTO `PM4Orders` VALUES (DEFAULT,?,?,?,?,?,?,?,?,?,?,DEFAULT)"))) {
		die("Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
	}
	
	// 8. There are 10 parameter, the first 8 are strings, the 9th is an integer, the 10th is a string		
	
	$stmt->bind_param("ssssssssis", 
		$orderDate, 
		$_POST['cust_name'],
		$_POST['cust_phone'],
		$_POST['cust_address'],
		$_POST['cust_city'],
		$_POST['cust_state'],
		$_POST['cust_zip'],
		$_POST['size'],
		$_POST['quantity'],
		$candy_type
	);
	

  // 9. Once the query is prepared, we can execute it
  
  if (!$stmt->execute()) {
  	die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
	}
	else {
		// 10. If the query had no errors, we display the order
		return displayOrder();
	}
	$stmt->close();
	$mysqli->close();
}

function processForm() {
	$hasError = false;
	foreach ($_POST as $name => $value) {
		if (empty($_POST[$name])) {
			$_POST[$name] = "!missing!";
			$hasError = true;
		}
	}
	echo $hasError;
	if ($hasError) {
		
		return createForm($displayDate);
	}
	else {

		$output = "";
		foreach ($_POST as $key => $value) {
		$output .=  '
		 <div class="panel panel-primary">
		  <div class="panel-heading">'.$key.'</div>
		  <div class="panel-body"><p>'.$value.'</p></div>	
		 </div>';
		}
		return insertOrder();
		return $output;
	
		 
	}

}


function processAdminForm() {
	$fieldMissing = false;
	foreach ($_POST as $key => $value) {
			if ($value == null)  {
				$_POST[$key] = "!missing!";
				$fieldMissing = true;
			}
	}
	if ($_POST['employee_type'] == null) {
		$_POST['employee_type'] = "!missing!";
		$fieldMissing = true;
	}
	if ($fieldMissing) {
		return createAdminForm();
	}
	else {
		return insertAdmin();
	}
}


function insertAdmin() {
	$mysqli = databaseConnect();
	if (!($stmt = $mysqli->prepare("INSERT INTO `AdminTable` VALUES (?,?,?)"))) {
		die("Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
	}		
	$hashed_passwd = hash("sha256", $_POST['password']);
	$stmt->bind_param("ssi", 
		$_POST['user_name'],
		$hashed_passwd,
		$_POST['employee_type']
	);

  if (!$stmt->execute()) {
  	die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
	}
	else {
		return displayOrder();
	}
	$stmt->close();
	$mysqli->close();
}


function displayTable($table) {
	// 1. Connect to the database
	
	$mysqli = databaseConnect();
	
	// 2. Define the query as string
	// Note that we don't have to prepare it because there are no variables, i.e. the query is hardcoded and cannot be change by a user
	
	$query = "SELECT * FROM `".$table."`";
	
	// 3. Run the query.  Prepared queries must be executed.  But hardcoded queries can be run with one function call
	// $results is a pointer to the query's output
	
	$result = $mysqli->query($query);
	
	// 4. Fetch the fields that the query returned
	// $finfo is an object that stores all the field information
	
	$finfo = $result->fetch_fields();
		
	// 5. Create an HTML table
	
	$output = '<table class="table table-bordered">';

	// 6. Loop for all the fields and print them as table headers
	
	$output .= '<thead><tr>';
	foreach ($finfo as $field) {
		$output .= '<th>'.$field->name.'</th>';
	}
	$output .= '</tr></thead><tbody>';
	
	// 7. Fetch each row of the query result to make an HTML row
	
	while ($row = $result->fetch_row()) {
		$output .= '<tr>';
		
		// 8. Loop for each column and make an HTML table data column
		foreach ($row as $val) {
			$output .= '<td>'.$val.'</td>';
		}
		$output .= '</tr>';
	}
	$output .= '</tbody></table>';

	$result->free();
	$mysqli->close();
	return $output;
}

  
function createAdminTable() {
    $mysqli = databaseConnect();
	$dropquery = "DROP TABLE IF EXISTS `AdminTable`";
	$createquery = "CREATE TABLE IF NOT EXISTS `AdminTable` (
		`user_name` varchar(24) NOT NULL,
		`password` varchar(256) NOT NULL,
		`employee_type` int(2) NOT NULL,
		PRIMARY KEY (`user_name`)
	)";
	if (!$mysqli->query($dropquery)) {
		echo 'Table drop failed: (' . $mysqli->errno . ') ' . $mysqli->error;
	}
	else if (!$mysqli->query($createquery)) {
		echo 'Table create failed: (' . $mysqli->errno . ') ' . $mysqli->error;
	}
	else {
		echo 'Table created';
	}
	$mysqli->close();
}
function processLoginForm() {
  $fieldMissing = false;
  foreach ($_POST as $key => $value) {
    if ($value == null)  {
      $_POST[$key] = "!missing!";
      $fieldMissing = true;
    }
  }
  if ($fieldMissing) {
    return createLoginForm();
  }
  else {
    if (checkPassword())
      header("location: /project2/admin.php?status=active");
    else
      header("location: /project2/login.php");
  }
}

function createLoginForm() {
	
	return 
	'
	<form method="post" action="login.php?action=submit">
	<h2>Admin Info</h2>
	<div class="row">'.		
	createTextField("user_name", "Admin Name", 8).'
	</div>
	<div class="row">
	'.createPasswordField("password","Password",8).'
	</div>
	

	<div class="row">
	<div class="col-sm-12">
	<button type="submit" class="btn btn-success">Submit</button>
	</div>
	</div>
	<br>
	<br>
	</form>';
	
	

}

function checkPassword() {
  $mysqli = databaseConnect();
  $submitted_passwd = hash('sha256', $_POST['password']);
  $submitted_userid = $_POST['user_name'];
  if (!($stmt = $mysqli->prepare("SELECT user_name, password, employee_type FROM `AdminTable` WHERE user_name=?"))) {
    die("Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
  }
  $stmt->bind_param("s", $submitted_userid );
  if (!$stmt->execute()) {
    die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
  }
  $stored_passwd = null;
  if (!$stmt->bind_result($user_name, $stored_passwd, $employee_type)) {
    echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
  }
  if ($stmt->fetch()) {
    if ($stored_passwd == $submitted_passwd){
		$_SESSION['admin'] = $employee_type; // or, $employee_type
		$_SESSION['userid'] = $user_name;
		return true;
	}
    else
      return false;
  }
}
function displayOrderControlPanel($table) {
	$mysqli = databaseConnect();
	$status = $_GET['status'];
	$query = "SELECT * FROM $table WHERE status = '$status'";
	$result = $mysqli->query($query);
	$finfo = $result->fetch_fields();
	$output .= '<p>';
	$output .= '<ul class="nav nav-pills">';
	$output .= '<li role="presentation" ><a class="btn btn-primary" href="admin.php?status=active">Active Orders</a></li>';
	$output .= '<li role="presentation"><a class="btn btn-primary" href="admin.php?status=complete">Complete Orders</a></li>';
	$output .= '</ul>';
	$output .= '<p>';
	$output .= '<table class="table table-bordered">';
	$output .= '<thead><tr>';
	foreach ($finfo as $field) {
		$output .= '<th>'.$field->name.'</th>';
	}
	$color = "";
	$counter = 1;
	$output .= '</tr></thead><tbody>';
	while ($row = $result->fetch_row()) {
		if($counter%4==1){
			$color = "success";
		}
		elseif($counter%4==2){
			$color = "active";
		}
		elseif($counter%4==3){
			$color = "warning";
		}
		else{
			$color = "danger";}
		
		$output .= '<tr class="'.$color.'">';
		foreach ($row as $val) {
			$output .= '<td>'.$val.'</td>';
		}	
		$output .= '<td align="center"><a align="center" class="btn btn-primary" href="processOrder.php?id='.$row[0].'">Process</a><br>
		<a  align="center" class="btn btn-info" href="editOrder.php?id='.$row[0].'">Edit</a><br>'
		;
		if ($_SESSION['admin'] > 0)
		$output .= '<a align="center" class="btn btn-danger" href="deleteOrder.php?id='.$row[0].'">Delete</a></td>
		</tr>';
		$counter++;
	}
	$output .= '</tbody></table>';
	$result->free();
	$mysqli->close();
	return $output;
}

function processOrder($id){
	$mysqli = databaseConnect();
	if (!($stmt = $mysqli->prepare("UPDATE PM4Orders SET status='complete' WHERE id=?")))
	{
		die("Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
	}	
	$stmt->bind_param("i", $id);
	
	if (!$stmt->execute()) {
		die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
	}
	$stmt->close();
	$mysqli->close();

}

function deleteOrder($id){
	$mysqli = databaseConnect();
	if (!($stmt = $mysqli->prepare("DELETE FROM `PM4Orders` WHERE id=?")))
	{
		die("Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
	}	
	$stmt->bind_param("i", $id);
	
	if (!$stmt->execute()) {
		die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
	}
	$stmt->close();
	$mysqli->close();
}

function editOrder($row){
	
	
    $output .= '<form method="post" action="editOrder.php?action=submit">';	
	$output .= '<div class="row">';
	$output .= '<div clas="col-sm-12">';
    $output .= '<h2>Order Info</h2>';
	$output .= '</div>';
	$output .= '</div>';
	$output .= '<div class="row">';
	$output .= createTextField("date", "Date", 6,$row['date']);
	$output .= createTextField("status", "Status", 6,$row['status']);
	$output .= '</div>';
    $output .= '<div class="row">';		
    $output .= createTextField("cust_name", "Name", 8,$row['name']);
    $output .= createTextField("cust_phone", "Phone", 4,$row['city']);
    $output .= createTextField("cust_address", "Address", 12,$row['address']);
    $output .= createTextField("cust_city", "City", 6,$row['city']);
    $output .= createTextField("cust_state", "State", 3,$row['state']);
    $output .= createTextField("cust_zip", "Zip",3,$row['zip']);
    $output .= '</div>';
	$output .= '<div clas="row">';
	$output .= '<div class="col-sm-3">';
	$output .= '<h3>Candy Size</h3>';
	$candySize =  array("Small" => "small",
                     "Medium" => "medium",
                     "Large" => "large",
					 "Extra Large" => "extra_large");
                        	
	foreach ($candySize as $key => $v) {
		$selected = "";
		if ($v == $row['candy_size']){
			$selected = "checked";
		}
		$output .= createRadioButton("size", $v, $key, $selected);
		
	}	

	$output .= '</div>';
	$output .= '<div class="col-sm-3">';
	$output .= '<h3>Quantity</h3>';
	$output .= '<select class="form-control" name="quantity">';
	for($i = 1; $i < 5; $i++){
		if($i == $row['quantity']){		
			$output .= '<option value="'.$i.'" selected="selected">'.$i.'</option>';
		}
		else{
			$output .= '<option value="'.$i.'" >'.$i.'</option>';
			
		}
	}
	$output .=  '</select>';
	$output .= '</div>';
	$output .= '<div class="col-sm-2">';
	$output .= '<p></p>';
	$output .= '</div>';
	$output .= '<div class="col-sm-4">';
	$output .= '<h3>Candy Type </h3>';
	$possibleValues['Gum'] = false;
	$possibleValues['Chocolate'] = false;
	$possibleValues['Mints'] = false;
	$possibleValues['Gummi Worms'] = false;
	$possibleValues['Gummi Bears'] = false;
	$possibleValues['Jelly Beans'] = false;
	
	$selectedValues = explode("," ,$row['candy_type']);
	
	foreach ($selectedValues as $s) {
	$possibleValues[$s] = true;
	}	
	foreach ($possibleValues as $key => $value) {
	  $selected = "";
	  if ($value == true){
	  $selected = "checked";}
	  $output .= createCheckbox("candy[]",$key,$key,$selected);
	}
	$output .= '</div>';
	$output .= '<button type="submit" class="btn btn-success">Submit</button>';
	$output .= '<br>';
	$output .= '<br>';
	return $output;
	$result->free();
	$mysqli->close();

	
}

function getOrder($id){
	$mysqli = databaseConnect();
	if (!($stmt = $mysqli->prepare("SELECT * FROM PM4Orders WHERE id=?")))
	{
		die("Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
	}	
	$stmt->bind_param("i", $id);
	if (!$stmt->execute()) {
		die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
	}
	
	$stmt->bind_result( $row['id'],
                    $row['date'],										
                    $row['name'],
                    $row['phone'],
					$row['address'],
					$row['city'],
					$row['state'],
                    $row['zip'],
					$row['candy_size'],
					$row['quantity'],
					$row['candy_type'],
                    $row['status']);
	$stmt->fetch();				
				
	$stmt->close();
	$mysqli->close();	
	return $row;
}
function updateOrder($id){
	$mysqli = databaseConnect();
	if (!($stmt = $mysqli->prepare("UPDATE PM4Orders SET date=?, name=?, phone=?, address=?, city=?, state=?, zip=?, candy_size=?, quantity=?, candy_type=?, status=? WHERE id=?"))){
		die("Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
	}
	$stmt->bind_param("ssssssssissi", 
		$_POST['date'], 
		$_POST['cust_name'],
		$_POST['cust_phone'],
		$_POST['cust_address'],
		$_POST['cust_city'],
		$_POST['cust_state'],
		$_POST['cust_zip'],
		$_POST['size'],
		$_POST['quantity'],
		implode(",",$_POST['candy_type']),
		$_POST['status'],
		$id
	);
	$f = $stmt->execute();
	if (!$f) {
		die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
	}	
	$stmt->close();
	$mysqli->close();	
}

	
?>