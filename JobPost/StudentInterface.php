<html>
<style type="text/css">
.page1 {
	background-color: #FC0;
	border: thick solid #F00;
}
</style>
<body>

<head>
  <title>JobPost</title>
  <link rel="stylesheet" href="tester.css">
    <script type="text/javascript">
    
      function activateTab(pageId) {
          var tabCtrl = document.getElementById('tabCtrl');
          var pageToActivate = document.getElementById(pageId);
          for (var i = 0; i < tabCtrl.childNodes.length; i++) {
              var node = tabCtrl.childNodes[i];
              if (node.nodeType == 1) { /* Element */
                  node.style.display = (node == pageToActivate) ? 'block' : 'none';
              }
          }
      }
      
      function showPort(x) {
	   		document.getElementById(x).style.display = "block";
	   		if (x != 'profileDiv') {
	   			document.getElementById('profileDiv').style.display = "none";
	   		}
	   		if (x != 'postingsDiv') {
	   			document.getElementById('postingsDiv').style.display = "none";
	   		}
	  }

    </script>
  </head>
  


    <?php
	// These variables are extracted from the text boxes each time this page is called 
       $username = $_POST["username"];
	   global $con, $sid;
	   $con=mysqli_connect('localhost','root','', 'jobpost');
	   if(!$con){ 
		echo "Connection failed"; 
	}
	// Check connection
	   if (mysqli_connect_errno()) {
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

        $username = "admin";
        $sidresult = mysqli_query($con,"SELECT s_id FROM STUDENT_STUDIES  WHERE username = '$username' ");
		while($row = mysqli_fetch_array($sidresult))
		$sid = $row['s_id'];
	//delete it after finished    
		echo $username;
		echo $sid;

  function sendApplication($sid,$jid,$coid,$apliN){//to apply a posted job
        $query = "INSERT INTO APPLIES VALUES ('$sid','$jid','$coid','$apliN')";
		mysql_query($query);
        }
		
		  function CancelApplication($sid,$jid){//to apply a posted job
        $query = "DELETE * FROM ALLIES WHERE $sid = s_id AND '$jid' = j_id";
		mysql_query($query);
        }
		
  function getDetails($coid,$con){//get detail information of a company
	  $result = mysqli_query($con,"SELECT * FROM COMPANY WHERE co_id = '$coid'");

				echo "<table border='1'>
				<tr>	
				<th>Name</th>
				<th>StreetNumber</th>
				<th>StreetName ID</th>
				<th>City</th>
				<th>Province</th>
				<th>PostalCode</th>
				</tr>";

				while($row = mysqli_fetch_array($result)) {
			  		echo "<tr>";	
			  		echo "<td>" . $row['Name'] . "</td>";
					echo "<td>" . $row['StreetNumber'] . "</td>";
  					echo "<td>" . $row['StreetName'] . "</td>";
  					echo "<td>" . $row['City'] . "</td>";
  					echo "<td>" . $row['Province'] . "</td>";
  					echo "<td>" . $row['PostalCode'] . "</td>";
					echo "</tr>";
				}

				echo "</table>";
  }
  
  function ApplyOrCancel($jid,$con,$sid){
	  $result = mysqli_query($con, "SELECT * FROM APPLIES WHERE j_id = '$jid' AND s_id = '$sid'");
	  while($row = mysqli_fetch_array($result)){
		  if ($row['s_id'] = NULL){  
		    echo '<TD><form method="POST" action="StudentInterface.php">
					          <input type="submit" value="Value" name="Value" >
					          </form></TD>';
		  }
		  else{
			echo '<TD><form method="POST" action="StudentInterface.php">
					          <input type="submit" value="Cancel" name="Cancel" >
					          </form></TD>';
			  }
			 
		     
	  }
  }


?>



    <ul>
      <li>
        <input type="button" name="portfolio" value="Profile" onClick="showPort('profileDiv')" />
      </li>
      <li>
         <input type="button" name="posts" value="Job Postings" onClick="showPort('postingsDiv')" />
      </li>
      <li>
        <a href="javascript:activateTab('page4')">Offers Pedning</a>
      </li>
      <li>
        <a href="javascript:activateTab('page5')">Offers Accepted</a>
      </li>
    </ul>
    <div id="tabCtrl">
      <div id="page1" style="display: block;">Job Postings</div>
      <div id="page2" style="display: none;">Your Postings</div>
      <div id="page3" style="display: none;">Posting Candidates</div>
      <div id="page4" style="display: none;">Offers Pedning</div>
      <div id="page5" style="display: none;">Offers Accepted</div>
    </div>
    
    	<div id="profileDiv"
    		style="display:none;"
    		class="answer_list">
    			<?php
				$result = mysqli_query($con,"SELECT * FROM PROFILE_CREATES WHERE s_id = '$sid'");

				echo "<table border='1'>
				<tr>	
				<th>Student ID</th>
				<th>Profile ID</th>
				<th>Profile Date</th>
				<th>Experience</th>
				<th>Education</th>
				</tr>";

				while($row = mysqli_fetch_array($result)) {
			  		echo "<tr>";	
			  		echo "<td>" . $row['s_id'] . "</td>";
  					echo "<td>" . $row['p_id'] . "</td>";
  					echo "<td>" . $row['p_date'] . "</td>";
  					echo "<td>" . $row['Experience'] . "</td>";
  					echo "<td>" . $row['Education'] . "</td>";
					echo "</tr>";
				}

				echo "</table>";
			?>
		</div>
		
 
		
 	<div id="postingsDiv"
    		style="display:none;"
    		class="answer_list">
    			<?php
				$result = mysqli_query($con,"SELECT * FROM JOB_POSTING");

				echo "<table border='1'>
				<tr>	
				<th>Job ID</th>
				<th>Contract ID</th>
				<th>Company ID</th>
				<th>Position</th>
				<th>Date Posted</th>
				<th>Apply</th>
				<th>Detail</th>
				</tr>";

				while($row = mysqli_fetch_array($result)) {
			  		echo "<tr>";	
			  		echo "<td>" . $row['j_id'] . "</td>";
  					echo "<td>" . $row['c_id'] . "</td>";
  					echo "<td>" . $row['co_id'] . "</td>";
  					echo "<td>" . $row['Position'] . "</td>";
  					echo "<td>" . $row['DatePosted'] . "</td>";
					'<td>'. ApplyOrCancel($row['j_id'],$con,$sid). '</td>';
					echo '<TD><form method="POST" action="StudentInterface.php">
					           <input type="submit" value="Detail" name="Detail" >
					          </form></TD>';
					echo "</tr>";
					$jid = $row['j_id'];
					$coid = $row['co_id'];
					$maxAliNum = mysqli_query($con, "SELECT DISTINCT MAX(ApplicationN) AS AppliN FROM APPLIES");
					$row = mysqli_fetch_array($maxAliNum);
					$apliN = (int)$row['AppliN'] + 1 ;
					
					 if(isset($_POST['Apply']))
                                             {
                                 sendApplication($sid,$jid,$coid,$apliN);
                                             }
                                 else if(isset($_POST['Detail']))
                                             {
                                 getDetails($coid,$con);
                                              }
								 else if (isset($_POST['Cancel']))
								 {
									 CancelApplication($sid,$jid);
								 }

            
				}

				echo "</table>";
			?>
		</div>
        
        <div id="Offers Pedning"
    		style="display:none;"
    		class="answer_list">
         
    			<?php
				//may need to add a field in APPLIES to show this part
				$result = mysqli_query($con,"SELECT * FROM APPLIES WHERE s_id = '$sid'");

				echo "<table border='1'>
				<tr>	
				<th>Student ID</th>
				<th>Company ID</th>
				<th>Job ID</th>
				<th>Application Number</th>
				</tr>";

				while($row = mysqli_fetch_array($result)) {
			  		echo "<tr>";	
			  		echo "<td>" . $row['s_id'] . "</td>";
  					echo "<td>" . $row['co_id'] . "</td>";
  					echo "<td>" . $row['j_id'] . "</td>";
  					echo "<td>" . $row['ApplicationN'] . "</td>";
					echo "</tr>";
				}

				echo "</table>";
			?>
		</div>
        
        <div id="Offers Accepted"
    		style="display:none;"
    		class="answer_list">
    			<?php
				$result = mysqli_query($con,"SELECT * FROM STUDENT_SIGNS WHERE s_id = '$sid'");
				//change this to a view that also show content of contract later

				echo "<table border='1'>
				<tr>	
				<th>Student ID</th>
				<th>Contract ID</th>
				<th>Sign Date</th>
				</tr>";

				while($row = mysqli_fetch_array($result)) {
			  		echo "<tr>";	
			  		echo "<td>" . $row['s_id'] . "</td>";
  					echo "<td>" . $row['c_id'] . "</td>";
  					echo "<td>" . $row['s_date'] . "</td>";
					echo "</tr>";
				}

				echo "</table>";
			?>
		</div>
        
      
        
	
	

	
	
  </body>
</html>