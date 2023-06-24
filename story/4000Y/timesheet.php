<?php
$schedule_id = $_POST['schedule_id'] ?? null;
$doctorName = $_POST['doctorName'] ?? null;
$date =$_POST['date'] ?? null;
$startTime =$_POST['startTime'] ?? null;
$endTime=$_POST['endTime'] ?? null;
$MEMO=$_POST['MEMO'] ?? null;

session_start();  //Starting the Session 

//If the user session is not declared, it means the user is not logined, therefore, it will redirect him to the Login Page
if(empty($_SESSION['ActiveuserID'])){
    header("Location: login.php");
}

//Setting the variable for the session of active userID in activer user varriable
$activeuser = $_SESSION['ActiveuserID'];
$first_name = $_POST['first_name'] ?? NULL;

include 'includes/library.php'; // Including the library
$pdo = connectDB();             //connnecting it to the database

$stmt=$pdo->query("SELECT * FROM user_name WHERE role_id=1 OR role_id=3");
//dealing with the possibilties of not getting any results
if(!$stmt){
    die("Database pull did not return data");
}

//In order to display the Name of the active user : We are fetching the first name from the database for the activeuser 
$GetFirstNameQuery = "SELECT * FROM user_name WHERE user_code='$activeuser'"; 
$FQuery = $pdo->prepare($GetFirstNameQuery);
$FQuery->execute();
$AnsUser=$FQuery->fetch();
$user = $AnsUser['first_name'];   //Stores the value in variable username (It will store the Username)

//In order to display the position of the active user
$GetRoleQuery = "SELECT * FROM user_name INNER JOIN role ON user_name.role_id=role.role_id WHERE user_code='$activeuser'"; 
$RQuery = $pdo->prepare($GetRoleQuery);
$RQuery->execute();
$AnsRole=$RQuery->fetch();
$role = $AnsRole['position_name'];

if($role != "Receptionist"){
    header("Location: login.php");
    exit();
}
if (isset($_POST['submit'])){
    $GetUserIDQuery = "SELECT * FROM user_name WHERE first_name='$doctorName'"; 
    $UserIDQuery = $pdo->prepare($GetUserIDQuery);
    $UserIDQuery->execute();
    $AnsUserID=$UserIDQuery->fetch();
    $userID = $AnsUserID['user_code'];  

    $queryInsert = "INSERT INTO provider_schedule VALUES (?,?,?,?,?,?)";
    $stmtInsert = $pdo->prepare($queryInsert);
    $result = $stmtInsert->execute([$schedule_id,$userID, $date,$startTime,$endTime,$MEMO]);

    header("Location: scheduleReport.php");
    exit();

}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="styles/style.css" />
        <link rel="stylesheet" href="styles/main.css" />
        <link
            href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css"
            rel="stylesheet" />
        <script
            src="https://kit.fontawesome.com/170f096220.js"
            crossorigin="anonymous"></script>
        <link
            href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css"
            rel="stylesheet" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    </head>
    <body>
        <?php include "includes/receptionistNav.php"?>
        <section class="homeContent">
            <div>
                <h1>Timesheet</h1>
            </div>
            <div class="submitTimesheet">
                <form id="TimeSheetPage" name="submitTimesheet" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                    <div class="enterTimeInfo">
                        <label for="datetime">Date</label>
                        <input
                            type="date"
                            id="date"
                            name="date"
                            required />
                        <label for="userName">Dr. Name</label>
                        <select id="userName" name="doctorName">
                            
                            <?php foreach ($stmt as $row): ?>
                                <option><?php echo $row['first_name']?></option>
            			<?php endforeach; ?>
                        </select>
                        <label for="time">Start Time</label>
                        <input
                            type="time"
                            id="startTime"
                            name="startTime"
                            required />
                        <label for="time">End Time</label>
                        <input
                            type="time"
                            id="endTime"
                            name="endTime"
                            required />

                        <!-- The form Login button -->
                        <div>
                            <button
                                type="submit"
                                name="submit"
                                value="submit"
                                class="submit">
                                Submit Time
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </body>
</html>
