<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "techgyanathon";


$link=mysqli_connect($servername,$username,$password,$dbname);
$addedSuccessful=0;
$errorString="Error In :";
$error=0;
$deletedAllEntries=0;


if(isset($_POST['uploadCsv'])){

	if(file_exists($_FILES['csv']['tmp_name']) || is_uploaded_file($_FILES['csv']['tmp_name'])){

		$fileName=basename($_FILES["csv"]["name"]);
		$tmpName = $_FILES['csv']['tmp_name'];
		$csvAsArray = array_map('str_getcsv', file($tmpName));

		foreach ($csvAsArray as $participant) {

			if($participant[0]!="Timestamp"){//TO SKIP FIRST ROW

				// echo $participant[1]."-----".$participant[6]."<br>";
				$allEventsSplitted=explode(',', $participant[6]);
				// print_r($allEventsSplitted);
				//echo $allEventsSplitted[1]."<br>";
				//echo "<br>";
				$coding=0;
				$webinar=0;
				$tpp=0;
				$project=0;

				foreach ($allEventsSplitted as $singleEvent) {
					if($singleEvent=='Technical Paper Presentation - "IT Solutions for Covid-19"' or $singleEvent==' Technical Paper Presentation - "IT Solutions for Covid-19"'){
						$tpp=1;
					}
					if($singleEvent=="Coding Competition Using C/Java" or $singleEvent=="Coding Competition Using C/Java/Python" or $singleEvent==" Coding Competition Using C/Java" or $singleEvent==" Coding Competition Using C/Java/Python"){
						$coding=1;
					}
					if($singleEvent=="Webinar" or $singleEvent==" Webinar"){
						$webinar=1;
					}
					if($singleEvent=="Project Competition" or $singleEvent==" Project Competition"){
						$project=1;
					}
				}

				$query="INSERT INTO `participants`(`timestamp`, `name`, `email`,`phone`,`college`, `branch`,`coding`,`webinar`,`tpp`,`project`) VALUES ('".$participant[0]."','".$participant[1]."','".$participant[2]."','".$participant[3]."','".$participant[4]."','".$participant[5]."',".$coding.",".$webinar.",".$tpp.",".$project.")";

		        if(mysqli_query($link,$query)){
		          //SUCCESSFULLY ADDED AFFILIATE URL
		        }else{
		        	$error=1;
		        	$errorString=$errorString."<br>".$participant[0].",".$participant[1].",".$participant[2].",".$participant[3].",".$participant[4].",".$participant[5].",".$participant[6]."<br>";
		        }

			}		
		}

		$addedSuccessful=1;

	}

}

?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Admin Panel</title>

    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="../assets/css/userpanel.css">
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">

    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>

</head>
<body>


<form method="POST" enctype="multipart/form-data">
    <div class="container" style="text-align: center; border: 5px solid black; padding: 20px; border-radius: 10px; margin: 10px auto; max-width: 700px;">

      <h3><u>Add PARTICIPANTS Details</u></h3>


      <?php

      	if($error==1){
          echo '
          <div class="alert alert-danger" role="alert">
            <b>'.$errorString.'</b>
          </div>
          ';
        }

        if($deletedAllEntries==1){
          echo '
          <div class="alert alert-success" role="alert">
            <b>All Entries Deleted Successfully!</b>
          </div>
          ';
        }

        if($addedSuccessful==1){
        	if($error==1){
        		echo '
		          <div class="alert alert-success" role="alert">
		            <b>Remaining Entries Added Successfully!</b>
		          </div>
		        ';
        	}else{
        		echo '
		          <div class="alert alert-success" role="alert">
		            <b>Added Successfully!</b>
		          </div>
		        ';
        	}
          
        }

      ?>


    <input type="file" name="csv" id="csv" required="true">
    <input type="submit" class="btn btn-outline-primary" style="margin-top:5px;" name="uploadCsv" value="UPLOAD CSV">
   </div>
</form>


 <!-- jQuery CDN - Slim version (=without AJAX) -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
    <!-- jQuery Custom Scroller CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>

</body>
</html>

