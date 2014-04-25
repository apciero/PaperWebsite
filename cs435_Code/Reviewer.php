<?php
$profpic = "images/sign-up-btn.gif";
?>
<?php
// Create connection

$con=mysqli_connect("localhost","root","","Paper_Website");

// Check connection

if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

$paper_selected_download = 0;
$paper_selected_review = 0;
$paper_selected_comments = 0;
if (isset($_POST['download'])) {
    $paper_selected_download = $_POST['papers'];
    unset($_POST['download']);    
  }
if (isset($_POST['Review'])) {
    $paper_selected_review = $_POST['papers'];
    unset($_POST['Review']);    
  }
if (isset($_POST['comments'])) {
    $paper_selected_comments = $_POST['papers'];
    unset($_POST['comments']);    
  }


?>
<head>
<link href="style.css" rel="stylesheet" type="text/css" />
</head>

<style>
table,th,td
{
border:1px solid black;
}
</style>

<body>
	<div class = "AuthorDiv" style="float: left;">
		<div class = "AuthorDiv2" style="float: left; bottom: 10px">
			<form action="" method="post">
			<table class="tablesmall" style="position:relative; width:100%;">
				<th COLSPAN="4">
					<h3><br>Awaiting Review</h3>
				</th>
				<tr>
					<td width="60%">Title</td>
					<td width="15%">Date</td>					
					<td width="10%">Selected</td>
				<?php  $result = mysqli_query($con,"SELECT * FROM (SELECT * FROM `Paper` WHERE `Paper`.`paperid` NOT IN(SELECT `paperid` FROM `Reviews`)) tab WHERE ".							      "((tab.`reviewers_assigned1` = 12346) or(tab.`reviewers_assigned2` = 12346))");//this needs the usersession id
				while($row = mysqli_fetch_array($result)){ ?>
					  <tr>
					    <td><?php echo $row['title'];?></td>
					    <td><?php echo $row['date'];?></td>
					    <td>						
							<input type="radio" name="papers" value=<?php echo $row['paperid']; ?>><br>							
						</td>
					  </tr>
					<?php } ?>
				
			</table>
				<input type="submit" value="Download">
				<input type="submit" value="Review">
			</form>	
			<form action="" method="post">			
			<table class="tablesmall" style="position:relative; width:100%; bottom: -10px">
				<th COLSPAN="4">
					<h3><br>Completed Review</h3>
				</th>
				<tr>
					<td width="60%">Title</td>
					<td width="15%">Date</td>
					<td width="15%">Status</td>
					<td width="10%">Selected</td>
				<?php  
					$result2 = mysqli_query($con,"SELECT * FROM `Reviews`,`Paper` WHERE `Reviews`.`userid` = 12346 and `Reviews`.`paperid` = `Paper`.`paperid` and "								."((`Paper`.`reviewers_assigned1` = 12346) or(`Paper`.`reviewers_assigned2` = 12346))");//this also needs the usersession id

					while($row = mysqli_fetch_array($result2)){ ?>
					  <tr>
					    <td><?php echo $row['title'];?></td>
					    <td><?php echo $row['date_reviewed'];?></td>
					    <td><?php switch ($row['status']){
								case 1:
								  echo "approved";
								  break;
								case 2:
								  echo "rejected";
								  break;
								default:
								  echo "pending";
								} ?> </td>
					    <td>						
						<input type="radio" name="papers" value=<?php echo $row['paperid']; ?>><br>							
					    </td>
					  </tr>
					<?php } ?>			
			</table>
			<input type="submit" value="View Comment" name='comments'>
			</form>
		</div>
		<?php  
			
			$result2 = mysqli_query($con,"SELECT * FROM `Reviews` WHERE `Reviews`.`userid` = 12346 and `Reviews`.`paperid` = " . $paper_selected_comments);//this also needs the usersession id
			$review_row = mysqli_fetch_array($result2); ?>
		<form name="input" action="" method="get"><!-- Dis where for sends to php file-->
			<div class="AuthorDiv2" style="float: left; left:2px; bottom: 10px">			
				Rating: 1 <input type="radio"<?php if($review_row['rating'] == 1){echo "checked";}?> name="rating"> 2<input type="radio"<?php if($review_row['rating'] == 2){echo "checked";}?>  name="rating"> 3<input type="radio"<?php if($review_row['rating'] == 3){echo "checked";}?>  name="rating"> 4<input type="radio"<?php if($review_row['rating'] == 4){echo "checked";}?>  name="rating"> 5<input type="radio"<?php if($review_row['rating'] == 5){echo "checked";}?>  name="rating">			
				Review to Author: </br>
				<textarea rows="15" cols="72"><?php echo $review_row['review'];?></textarea></br>
				Comment to Editor: </br>
				<textarea rows="15" cols="72"><?php echo $review_row['comment'];?></textarea></br>			
				<input type="submit" value="Submit Review">			
			</div>
		</form>
		
	</div>
</body>
