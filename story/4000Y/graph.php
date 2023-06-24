<?php

session_start();  //Starting the Session 

//If the user session is not declared, it means the user is not logined, therefore, it will redirect him to the Login Page
if(empty($_SESSION['ActiveuserID'])){
    header("Location: login.php");
}


//Setting the variables 
//session of active userID in activer user varriable
$activeuser = $_SESSION['ActiveuserID'];
//first name of active user 
$first_name = $_POST['first_name'] ?? NULL;
//array of all memo values that were updated
$memo_values = $_POST['memo'] ?? [];
//schedule id array
$schedule_id_values = $_POST['s_id'] ?? [];
//array of list ids for the manager only
$listID = $_GET['listID'] ?? NULL;


include 'includes/library.php'; // Including the library
$pdo = connectDB();             //connnecting it to the database

//get all provider name and code
//$pr_stmt=$pdo->query("SELECT first_name, user_code FROM user_name WHERE role_id=1 OR role_id=3");
//$stmt=$pdo->query("SELECT first_name, user_code FROM user_name WHERE role_id=1 OR role_id=3");
$pr_stmt=$pdo->query("SELECT first_name, user_code FROM user_name WHERE role_id=1 OR role_id=3");
$stmt=$pdo->query("SELECT first_name, user_code FROM user_name WHERE role_id=1 OR role_id=3");
//dealing with the possibilties of not getting any results
if(!$pr_stmt){
    die("Database pull did not return data");
}
if(!$stmt){
    die("Database pull did not return data");
}


//In order to display the Name of the active user : We are fetching the first name from the database for the activeuser 
$GetFirstNameQuery = "SELECT * FROM user_name WHERE user_code='$activeuser'"; 
$FQuery = $pdo->prepare($GetFirstNameQuery);
$FQuery->execute();
$AnsUser=$FQuery->fetch();
$user = $AnsUser['first_name'];   //Stores the value in variable username (It will store the Username)
$current_user_role = $AnsUser['role_id']; //stores the value of role id in the variable


//In order to display the position of the active user
$GetRoleQuery = "SELECT * FROM user_name INNER JOIN role ON user_name.role_id=role.role_id WHERE user_code='$activeuser'"; 
$RQuery = $pdo->prepare($GetRoleQuery);
$RQuery->execute();
$AnsRole=$RQuery->fetch();
$role = $AnsRole['position_name'];   


//SQL Query to select schedule data from database table - provider_schedule
/*$fetchedScheduleData = "SELECT schedule_id, user_code, schedule_date, start_time, end_time, Memo FROM provider_schedule ORDER BY schedule_date DESC";
$scheduleColumns = $pdo->prepare($fetchedScheduleData);
$scheduleColumns->execute();
*/
//if MEMO input is clicked on to be edited and the current user is manager or general manager, then the memo field is editable, otherwise only readonly
//only the logged in user's data is displayed
if($current_user_role != 2 && $current_user_role != 5){ 
    $readonly = "readonly";
    /*
    $fetchedScheduleData = "SELECT schedule_id, user_code, schedule_date, start_time, end_time, Memo FROM provider_schedule WHERE user_code = ? ORDER BY schedule_date DESC";
    $scheduleColumns = $pdo->prepare($fetchedScheduleData);
    $scheduleColumns->execute([$activeuser]);
    */
}
else{
    $readonly = "";
}


//loop through each provider name
foreach ($pr_stmt as $provider):
    if($provider['user_code'] == $listID){
        $fetchedScheduleData = "SELECT schedule_id, user_code, schedule_date, start_time, end_time, Memo FROM provider_schedule WHERE user_code = ? ORDER BY schedule_date DESC";
        $scheduleColumns = $pdo->prepare($fetchedScheduleData);
        $scheduleColumns->execute([$listID]);
    }
endforeach;

//if the import button is pressed then refresh the page
if(isset($_POST['file-import'])){
    header("Location: dashboardNumbers.php");
    exit;
}

//if database import button is pressed then push the MEMO column value to database and delete checked rows
if(isset($_POST['dbimport'])){
    for($i = 0; $i< count($memo_values); $i++){
        $UpdateMemoQuery = "UPDATE provider_schedule SET Memo = ? WHERE schedule_id = ? ";
        $UpdateMemo = $pdo->prepare($UpdateMemoQuery);
        $UpdateMemo->execute([$memo_values[$i], $schedule_id_values[$i]]); 
    }
    foreach ($_POST['checked'] as $id){
        $UpdateCheckedQuery = "DELETE FROM provider_schedule WHERE schedule_id = ? ";
        $UpdateChecked = $pdo->prepare($UpdateCheckedQuery);
        $UpdateChecked->execute([$id]); 
    }
    header("Location: dashboardNumbers.php");
    exit;    
}

//database
define('DB_HOST', 'loki.trentu.ca');
define('DB_USERNAME', 'sidaksinghsra');
define('DB_PASSWORD', 'Sidak@8121');
define('DB_NAME', 'sidaksinghsra');

//get connection
$mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

if(!$mysqli){
  die("Connection failed: " . $mysqli->error);
}

//query to get data from the table
$query = sprintf("select DAY(transaction_date) day, sum(total) total from ledger where MONTH(transaction_date)=MONTH(now()) and YEAR(transaction_date)=YEAR(now()) group by day");
$query1 = sprintf("select DAY(transaction_date) day, sum(total) total from ledger where MONTH(transaction_date)=MONTH(DATE_SUB(now(), INTERVAL 1 MONTH)) and YEAR(transaction_date)=YEAR(now()) group by day");
$query2 = sprintf("select DAY(transaction_date) day, sum(total) total from ledger where MONTH(transaction_date)=MONTH(now()) and YEAR(transaction_date)=YEAR(DATE_SUB(now(), INTERVAL 1 YEAR)) group by day");
$bar_query = sprintf("select sum(total) total,user_code from ledger where MONTH(transaction_date)=MONTH(now()) and YEAR(transaction_date)=YEAR(DATE_SUB(now(), INTERVAL 1 YEAR)) group by user_code");
//query to get data from the table for the bar graph
//$bar_result=$pdo->query("select sum(total) total,user_code from ledger where MONTH(transaction_date)=MONTH(now()) and YEAR(transaction_date)=YEAR(DATE_SUB(now(), INTERVAL 1 YEAR)) group by user_code");
//execute querybar
$bar_result = $mysqli->query($bar_query);

//execute query
$result = $mysqli->query($query);
$result1 = $mysqli->query($query1);
$result2 = $mysqli->query($query2);

//loop through the returned data
$data = array();
foreach ($result as $row) {
  $data[] = $row;
}
$data1 = array();
foreach ($result1 as $row) {
  $data1[] = $row;
}
$data2 = array();
foreach ($result2 as $row) {
  $data2[] = $row;
}
//loop through the returned data
$bar_data = array();
foreach ($bar_result as $row) {
  $bar_data[] = $row;
}

//free memory associated with result
$result->close();
$result1->close();
$result2->close();
$bar_result->close();


//close connection
$mysqli->close();

//now print the data
$data_from_db=array();
foreach($data as $d){
    $loop_data=array("y" => $d['total'], "x" =>$d['day']);
    array_push($data_from_db,$loop_data);
}
$data_from_db1=array();
foreach($data1 as $d){
    $loop_data=array("y" => $d['total'], "x" =>$d['day']);
    array_push($data_from_db1,$loop_data);
}
$data_from_db2=array();
foreach($data2 as $d){
    $loop_data=array("y" => $d['total'], "x" =>$d['day']);
    array_push($data_from_db2,$loop_data);
}



//now print the data
$bar_from_db=array();
foreach($bar_data as $d){
    $loop_data=array("y" => $d['total'], "label" =>$d['user_code']);
    array_push($bar_from_db,$loop_data);
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta
            name="description"
            content="Main Landing Page of the Dashboard of Longworth Dental Boutique" />
        <link rel="stylesheet" href="styles/main.css" />
        <link rel="stylesheet" href="styles/style.css" />
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
            href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap"
            rel="stylesheet" />
        <script
            src="https://kit.fontawesome.com/170f096220.js"
            crossorigin="anonymous"></script>

        

        <link
            href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css"
            rel="stylesheet" />
        <title>Analytics | Story</title>
        <script>
window.onload = function () {
 
var chart = new CanvasJS.Chart("chartContainer", {
	title: {
		text: "Total Revenue"
	},
	axisY: {
		title: "Revenue"
	},
    axisX: {
		title: "Days of the month"
	},
	data: [{
		type: "line",
		dataPoints: <?php echo json_encode($data_from_db, JSON_NUMERIC_CHECK); ?>
	},{
		type: "line",
		dataPoints: <?php echo json_encode($data_from_db1, JSON_NUMERIC_CHECK); ?>
	},{
		type: "line",
		dataPoints: <?php echo json_encode($data_from_db2, JSON_NUMERIC_CHECK); ?>
	}]
});

chart.render();

var bar_chart = new CanvasJS.Chart("bar_chartContainer", {
	animationEnabled: true,
	theme: "light2",
	title:{
		text: "Gross Production of every month"
	},
	axisY:{
		includeZero: true,
        title: "Revenue"
	},
    axisX: {
		title: "user_codes of the providers"
	},
	legend:{
		cursor: "pointer",
		verticalAlign: "center",
		horizontalAlign: "right",
		itemclick: toggleDataSeries
	},
	data: [{
		type: "column",
		name: "Revenue",
		indexLabel: "{y}",
		yValueFormatString: "$#0.##",
		showInLegend: true,
		dataPoints: <?php echo json_encode($bar_from_db, JSON_NUMERIC_CHECK); ?>
	}]
});
bar_chart.render();
 
function toggleDataSeries(e){
	if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
		e.dataSeries.visible = false;
	}
	else{
		e.dataSeries.visible = true;
	}
	bar_chart.render();
}
 
}
</script>
    </head>
    <body>
        
    <div class="dashSideBar" id="mySidebar">
            
            <ul class="sideNavList">
                
                <li class="navLink">
                    <a href="dashboard.php">
                    <i class="fa-solid fa-table-columns"></i>
                        <span class="linksName">Dashboard</span>
                    </a>
                </li>
                <li class="navLink">
                    <a href="dashboardNumbers.php">
                    <i class="fa-sharp fa-solid fa-hashtag"></i>
                        <span class="linksName">Numbers</span>
                    </a>
                </li>
                <!-- If user is not a manager, then the list of provider names will nto be visible -->
                <li 
                    <?php if($current_user_role != 2 && $current_user_role != 5){ ?> 
                        style="display:none;"
                    <?php } ?>
                > 
                    <a
                        href="dashboardNumbers.php?listID=''"
                        class="userNamesDrop">
                        <i class="fa fa-caret-down"></i
                        ><span class="linksName">Users Report</span>
                    </a>
                    <div class="dropNumbers" id="dropNumbers">
                    <!-- change this for a particular user table when clicked -->
                    <?php foreach ($stmt as $row): ?>
                        <a id="provider_name_report" href="dashboardNumbers.php?listID=<?= $row['user_code']; ?>" ><i class="fa-solid fa-circle-small"></i><span class="linksName"><?= $row['first_name']  ?></span></a>
                        <?php endforeach; ?>
                    </div>  
                </li>
                <li class="profile">
                    <div class="profileInfo">
                        <div class="name_position">
                            <div class="name"><?php echo $user; ?></div>
                            <div class="position">Position: <?php echo $role; ?></div>
                        </div>
                       
                    </div>
                </li>
            </ul>
        </div>
        <div class ="dashboardPage" id="main">
                <div id="navHead" class="navHead">
                    <nav class="accountDrop">
                        <button
                            class="openBtn"
                            onclick="closeNav()"
                            id="openCloseButton">
                            <i class="fa-solid fa-bars"></i>
                        </button>
                        <span>
                            <i class="fa-solid fa-book-open-reader"></i>
                        </span>
                        
                    </nav>
                    <!-- User Profile Dropdown -->
                    <div id="userProfileDropdown" class="userProfileDropdown">
                       <?php include "includes/navAccount.php"?>
                    </div>
                </div>

                <!-- Main Page Contents -->
                
            <!-- Main Page Contents -->
            <!-- <input type="submit" name = "add-row" class="button" value = "add-row"/> -->
            <section  id="mainContent" class="homeContent">     
            <div id="chartContainer" style="height: 370px; width: 100%;"></div>
            <div id="bar_chartContainer" style="height: 370px; width: 100%;"></div>
              <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
            </section>
        
    </body>
</html>
