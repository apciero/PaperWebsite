<?php
// Create connection
$con=mysqli_connect("localhost","root","","Paper_Website");

// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
else{
    echo "success asshole";
    echo "<br>";
  }
if (isset($_POST['submit'])) {
    $example = $_POST['papers'];
    
    echo $example;
  }?>


<!-- SELECT * FROM `Reviews`,`User`,`Paper` WHERE `Reviews`.`written_to` = 12345 and `User`.`userid` != 12345 and `Paper`.`userid` != 12345 and `Reviews`.`paperid` = 11111 and ((`Paper`.`reviewers_assigned1` = `Reviews`.`userid`) or (`Paper`.`reviewers_assigned2` = `Reviews`.`userid`))-->
