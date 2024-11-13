<!DOCTYPE html>
<html>

<head>
  <!-- Basic -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Site Metas -->
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <link rel="shortcut icon" href="images/logo.png" type="">

  <title> Dairy Direct </title>

  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />

  <!-- fonts style -->
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">

  <!--owl slider stylesheet -->
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />

  <!-- font awesome style -->
  <link href="css/font-awesome.min.css" rel="stylesheet" />

  <!-- Custom styles for this template -->
  <link href="css/style.css" rel="stylesheet" />
  <!-- responsive style -->
  <link href="css/responsive.css" rel="stylesheet" />

</head>
<body>

  <div class="hero_area" style="background-color: #2f3d4e;">

    <div class="hero_bg_box">
      <!-- <div class="bg_img_box">
        <img src="images/hero-bg.png" alt="">
      </div> -->
    </div>

    <!-- header section strats -->
    <header class="header_section">
      <div class="container-fluid">
        <nav class="navbar navbar-expand-lg custom_nav-container ">
          <a class="navbar-brand" href="index.html">
            <img src="images/logo2.png" style="margin-left: 100px;" height="70px" width="70px">

            <span>
              &nbsp; Dairy Direct
            </span>
          </a>
          <?php

// Assuming $con is your database connection
$se = $_SESSION['f_Id']; // Get the farmer's ID from the session
include("databases/connection.php");
// Prepare and bind the SQL statement
if ($stmt = $con->prepare("
    SELECT f_name, gender 
    FROM tbl_dairyf 
    WHERE f_Id = ?
")) {
    // Bind the parameter
    $stmt->bind_param("s", $se);

    // Execute the statement
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Check if there are results
    if ($result->num_rows > 0) {
        // Fetch the data
        while ($row = $result->fetch_assoc()) {
            // Escape output to prevent XSS
            $name = htmlspecialchars($row['f_name']);
            $gender = htmlspecialchars($row['gender']);


        }
    } else {
        echo "No results found.";
    }

    // Close the statement
    $stmt->close();
} else {
    echo "Failed to prepare the SQL statement.";
}

// Close the connection
$con->close();
?>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class=""> </span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav  ">
              <li class="nav-item active">
                <a class="nav-link" href="fhome.php">Home <span class="sr-only">(current)</span></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="fpayment.php">My Pays</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="freport.php">My Reports</a>
              </li>
              <li class="nav-item">
                <a class="btn1" href="fedit.php">Edit My details</a>
              </li>
              <li class="nav-item">
                <?php
                if ($gender === 'Female') {
                  echo '<img src="images/fg.png" height="50px" width="50px" style="border-radius: 50px;">';
                } else {
                  echo '<img src="images/fm.png" height="50px" width="50px" style="border-radius: 50px;">';
                }
                echo"</li><li class='nav-item'><a class='nav-link' href='./fedit.php'>$name</a><li>
                </li><li class='nav-item'><a class='nav-link' href='./logout.php'>Logout</a><li>";


                
              ?>  
             

            </li>
             
              </form>
            </ul>
          </div>
        </nav>
      </div>
    </header>
    <!-- end header section --></body>
</html>