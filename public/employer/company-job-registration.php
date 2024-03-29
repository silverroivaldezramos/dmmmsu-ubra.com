<?php
  session_start();
	if (!isset($_SESSION['emp_uname'])){
		header("location: ./");
	}
?>
<?php

	include 'database.php';

	$conn = mysqli_connect($servername, $username, $password, $dbname);
	$query2 = "SELECT * FROM job ORDER BY job_id DESC LIMIT 1";
  $result2 = mysqli_query($conn,$query2);
	if (mysqli_num_rows($result2) == 0) { 
		$job_id = "JOB1";
	}
	else {
		$row = mysqli_fetch_array($result2);
    	$last_id = $row['job_id'];
		  $job_id = substr($last_id, 3);
      $job_id = intval($job_id);
      $job_id = "JOB" . ($job_id + 1);
	}
  if (isset($_POST['next'])) {
		foreach ($_POST as $key => $value)
		{
			$_SESSION ['info'][$key] = $value;
		}

		$keys = array_keys($_SESSION['info']);

		if (in_array('next', $keys)) {
			unset($_SESSION['info']['next']);
		}
	}

  $_SESSION['job_id'] = $job_id;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Post/Edit Job Registration/Step 1</title>

  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="js/script.js"></script>

  <style>
    .logo{
      color:#64b5f6;
      font-weight: bolder;
      text-transform: uppercase;
    }

    .header{
      font-weight: 600;
      margin-bottom: 20px;
    }

    .material1{
      display: inline-flex;
      vertical-align: top;
      margin-right: 10px;
      margin-bottom: 5px;
    }

    .cardhorizontal{
      margin-bottom: -50px;
    }
    
    .btn-flat{
      background-color: #e0e0e0 ;
    }

    .material{
      display: inline-flex;
      vertical-align: top;
      margin-right: 10px;
      color: #64b5f6;
    }

    .job{
      font-size: 25px;
      font-weight: normal;
      text-transform: uppercase;
    }
  </style>
</head>
<body class="body">

<!--Navigation Bar-->
  <nav class=" blue darken-4" role="navigation">
    <div class="nav-wrapper container"><a id="logo-container" href="#" class="brand-logo"><span class="logo">UBRA</span></a>
      <ul class="right hide-on-med-and-down">
        <li><a href="home.php">Home</a></li>
        <li><a href="profile.php">Company Profile</a></li>
        <li><a href="job-annoucements.php">Job Announcements</a></li>
        <li><a href="job-registered.php">Job Registered</a></li>
        <li><a href="logout.php"><i class="material-icons">logout</i></a></li>
      </ul>

      <ul id="nav-mobile" class="sidenav">
        <li><a href="home.php">Home</a></li>
        <li><a href="profile.php">Company Profile</a></li>
        <li><a href="job-annoucements.php">Job Announcements</a></li>
        <li><a href="job-registered.php">Job Registered</a></li>
        <li><a href="logout.php">Log Out</a></li>
      </ul>
      <a href="#" data-target="nav-mobile" class="sidenav-trigger"><i class="material-icons icon">menu</i></a>
    </div>
  </nav>
<!--End-->

<!--Banner-->
  <div class="section no-pad-bot work" id="index-banner">
    <div class="container">
      <h5 class="header left-align blue-grey-text">Step 1!</h5>
    </div>
  </div>

<!--Post and Edit-->
<div class="container">
<div class="col s12 m7">
    <div class="card horizontal" style="margin-top:20px;margin-bottom: 107px;">
      <div class="card-stacked">
        <div class="card-content cardhorizontal">
          <div class="row">
            <form class="col s12">
              <div class="row">

                <input type="hidden" name="job_id" id="job_id" class="validate" value="<?php echo $job_id; ?>" placeholder="Job ID">

                <?php
                  include 'database.php';

                  $conn = new mysqli($servername, $username, $password,$dbname);

                  if ($conn->connect_error) 
                  {
                    die("Connection failed: " . $conn->connect_error);
                  }

                  $sql = "SELECT * FROM employer WHERE emp_uname='{$_SESSION['emp_uname']}'";
                  $result = $conn->query($sql);	
                  if ($result->num_rows > 0)  
                  {
                    while ($row = mysqli_fetch_assoc($result)){
                ?>
                
                <div class="input-field col s12 m6">
                  <input placeholder="Job Position" id="job_position" name="job_position" type="text" class="validate">
                  <label for="jobtitle">Job Position</label>
                </div>

                <div class="input-field col s12 m6">
                  <input placeholder="Location" id="job_location" name="job_location" type="text" class="validate" value="<?php echo $row["emp_barangay"]. $row["emp_municipal"].$row["emp_province"];?>" disabled>
                  <label for="job_location">Location</label>
                </div>

                <div class="input-field col s12 m6">
                  <input placeholder="Company/Employer" id="employer" name="employer" type="text" class="validate" value="<?php echo $row["emp_name"]; ?> " disabled>
                  <label for="Date">Company/Employer</label>
                </div>

                <div class="input-field col s12 m6">
                  <input placeholder="Job Position Available" id="available" name="available" type="text" class="validate">
                  <label for="available">Job Position Available</label>
                </div>

                <div class="center ">
                  <a class="btn btn-medium waves-effect waves-light blue disabled"><i class="material-icons">navigate_before</i></a>
                  <a id="postjob" name="postjob" class="btn btn-medium waves-effect waves-light blue"><i class="material-icons">navigate_next</i></a>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
  }
} 
?>

<!--Footer-->
  <footer class="page-footer  blue darken-4">
    <div class="container">
      <div class="row">
        <div class="col l6 s12">
          <h5 class="white-text">About Us</h5>
          <p class="grey-text text-lighten-4">UBRA is a Job Finder System by DMMMSU-MLUC to help
          people, graduates and working students find the suitable job for them.</p>
        </div>
        <div class="col l3 s12">
          <h5 class="white-text">Connect With Us</h5>
          <ul>
            <li><a class="white-text" href="#!"><i class="material-icons material1">phone</i>09997589145</a></li>
            <li><a class="white-text" href="#!"><i class="material-icons material1">mail</i>DMMMSU-MLUC EMAIL</a></li>
            <li><a class="white-text" href="#!"><i class="material-icons material1">facebook</i>DMMMSU-MLUC FACEBOOK</a></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="footer-copyright">
      <div class="container">
      <a class="orange-text text-lighten-3" href="#">Copyright © 2022 UBRA. All rights reserved.</a>
      </div>
    </div>
  </footer>


  <!--  Scripts-->
  <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script src="js/materialize.js"></script>
  <script src="js/init.js"></script>
  <script type="text/javascript">
	  function preventBack(){window.history.forward()};
	  setTimeout("preventBack()",0);
			window.onunload=function(){null;}
  </script>

  </body>
</html>
