<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - Society</title>
    <link rel="shortcut icon" type="image/png" href="../assets/images/logos/favicon.png" />
    <link rel="stylesheet" href="../assets/css/styles.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
</head>
<style>

.modal::after{
    display: flex;
    position: relative; /* Stay in place */
    z-index: 1; /* Sit on top */
    left: 0;
    top: 0;

    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgba(0, 0, 0, 0.4); /* Black w/ opacity */
    
    /* Flexbox to center the modal content */
    display: none;
    align-items: center; /* Center vertically */
    justify-content: center; /* Center horizontally */
}

.modal-content {
    background-color: white; /* White background for the modal content */
    margin: 20px; /* Margin around the modal content */
    padding: 20px; /* Padding inside the modal */
    border: 1px solid #888; /* Optional border */
    border-radius: 5px; /* Rounded corners */
    width: 80%; /* Width of the modal content */
    max-width: 600px; /* Maximum width */
}

.close {
    color: #aaa; /* Close button color */
    float: right; /* Align to the right */
    font-size: 28px; /* Font size */
    font-weight: bold; /* Bold font */
}

.close:hover,
.close:focus {
    color: black; /* Change color on hover or focus */
    text-decoration: none; /* Remove underline */
    cursor: pointer; /* Pointer cursor on hover */
}
button {
    margin: 5px;
}

.input-group-container {
    display: flex; /* Use flexbox for the container */
    justify-content: space-between; /* Space the items evenly */
    gap: 10px; /* Optional: Adds space between the input groups */
}

.input-group {
    font-size: 15px;
    padding:20px;
    flex: 1; /* Make each input group take equal space */
    display: flex;
    flex-direction: column; /* Stack label and input vertically */
}

.small-input {
    width: 100%; /* Make the input take full width */
    padding: 5px; /* Add some padding */
}
.btn-small {
    width: auto; /* Adjusts the width to fit the content */
    padding: 5px 10px; /* Adjusts the padding for a smaller button */
    min-width: 100px;
}

</style>
<body>
    <!-- Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
        <!-- Sidebar Start -->
        <?php
        session_start();
        if (!isset($_SESSION['s_Id'])) {
            header('Location: authentication-login.php');
            exit;
        }
        include('../databases/connection.php');
        include("sidebar.php");
        $loca=$_SESSION['loc'];
        ?>
        <!-- Main wrapper -->
        <div class="body-wrapper">
            <!-- Header Start -->
            <?php include('header.php');

// Check if the form is submitted
if (isset($_POST["sub"])) {
    // Retrieve form data
    $f_id = htmlspecialchars($_POST['fid']);; // Farmer ID (assuming this is static, you might want to change it based on your logic)
    $milk_type = htmlspecialchars($_POST['milk_type']); // Milk Type
    $fat = (float)$_POST['fat']; // Fat content
    $snf = (float)$_POST['snf']; // Solid-not-fat content
    $reading = (float)$_POST['reading']; // Reading value
    $c_ltr = (float)$_POST['c_ltr']; // Collected Litres
    $a_ltr = (float)$_POST['a_ltr']; // Reported Litres
    $amount = (float)$_POST['amount']; // Amount
    $message = htmlspecialchars($_POST['feedback']); // Feedback message
    // Prepare the SQL INSERT statement
    $sql = "INSERT INTO tbl_milk_records (f_id, milk_type, fat, snf, reading, t_date, c_ltr, a_ltr, amount, message, val_status) 
    VALUES (?, ?, ?, ?, ?, CURDATE(), ?, ?, ?, ?, 1)";

// Prepare and bind
$stmt = $con->prepare($sql);

// Check if the statement was prepared successfully
if ($stmt === false) {
die('Prepare failed: ' . htmlspecialchars($con->error));
}

// Bind parameters
$stmt->bind_param("isdddsdss", $f_id, $milk_type, $fat, $snf, $reading, $c_ltr, $a_ltr, $amount, $message);

// If you want to bind NULL for val_status
$val_status = null; // Set to null if you want to store NULL in the database
$stmt->bind_param("isdddsdss", $f_id, $milk_type, $fat, $snf, $reading, $c_ltr, $a_ltr, $amount, $message);

// Execute the statement
if ($stmt->execute()) {
    echo "<script>alert('New record created successfully');window.location.href='./milk_edit.php'</script>";

} else {
    echo "<script>alert('.$stmt->error.');</script>";
}

// Close the statement and connection
$stmt->close();
}
?>
            
     
            <div class="container-fluid" >
                <div class="row">
                    <div class="col-lg-12"> <!-- Updated to lg-12 -->
                    <div class="card" style="background-image: url('../assets/images/backgrounds/3p.jpg'); background-size: cover; background-position: center; width: 100%; height: 100%;">
                  <div class="card-body">
                                
                                <h5 class="card-title fw-semibold mb-5 text-center text-light mt-5"  style="font-size: 35px;">Add Milk Details</h5>

                              
                               
                          <form action="" method="post" class="form-inline">  
                          <div class="row mt-5">
                                <label class="text-light" style="font-size: 20px;">Farmer Details</label>
                                <div class="input-group-container">
                                    <div class="input-group">
                                    <label for="f_name" id="f_name" class="text-light"  style="font-size: 20px;"> &nbsp;</label>
    
                                     <span id="farmerNameDisplay"></span>                                     </div>

                                    <div class="input-group">
                                        <label for="f_address" class="text-light">Farmer Address:</label>
                                        <?php
                                            if (isset($_SESSION['loc'])) {
                                            $loc_id = $_SESSION['loc'];

                                            // Prepare the SQL statement
                                            $sql = "SELECT f_Id, f_name, f_homeaddress FROM tbl_dairyf WHERE location_society=? AND f_status=1 ORDER BY f_homeaddress ASC";    
                                            $stmt = $con->prepare($sql);
                                            $stmt->bind_param("i", $loc_id); // Assuming loc_id is an integer

                                            // Execute the statement
                                            $stmt->execute();
                                            $result = $stmt->get_result();

                                            // Start the dropdown
                                            echo '<select name="fid" id="farmerSelect" style="height: 35px;" required>';
                                            echo '<option disabled selected value>---Select Address---</option>'; // Default option

                                            // Fetch and display the options
                                            while ($row = $result->fetch_assoc()) {
                                                // Use f_Id as the value and f_name and f_homeaddress as the display text
                                                echo '<option value="' . htmlspecialchars($row['f_Id']) . '" data-name="' . htmlspecialchars($row['f_name']) . '">' . htmlspecialchars($row['f_homeaddress']) . '</option>';
                                            }

                                            // Close the dropdown
                                            echo '</select>';

                                            // Close the statement
                                            $stmt->close();
                                            } else {
                                            echo "Location ID not set in session.";
                                            }

                                            // Close the database connection
                                            ?></div> 
                                            

                                    <div class="input-group">
                                        <label for="milk_type" class="text-light">Milk Type:</label>
                                          
  
                                      <?php
                                            // Assuming you have already started the session and connected to the database

                                            if (isset($_SESSION['loc'])) {
                                                $loc_id = $_SESSION['loc'];

                                                // Prepare the SQL statement
                                                $sql = "SELECT type_name FROM tbl_milk_type WHERE loc_id = ?";
                                                $stn = $con->prepare($sql);
                                                $stn->bind_param("i", $loc_id); // Assuming loc_id is an integer

                                                // Execute the statement
                                                $stn->execute();
                                                $result = $stn->get_result();

                                                // Start the dropdown
                                                echo '<select name="milk_type" id="milkTypeDropdown" required onchange="storeMilkType()" style="height: 35px;">';
                                                echo '<option disabled selected value>---Select Milk Type---</option>'; // Default option

                                                // Fetch and display the options
                                                while ($row = $result->fetch_assoc()) {
                                                    echo '<option value="' . htmlspecialchars($row['type_name']) . '">' . htmlspecialchars($row['type_name']) . '</option>';
                                                }

                                                // Close the dropdown
                                                echo '</select>';

                                                // Close the statement
                                                $stn->close();
                                            } else {
                                                echo "Location ID not set in session.";
                                            }

                                            // Close the database connection
                                            $con->close();
                                            ?>

                                    </div>
                                </div>
                            </div>                                     
                                 <div class="row mt-5">
                                        <label class="text-light" style="font-size: 20px;">As Per the reading of Analyzer</label>
                                        <div class="input-group-container">

                                            <div class="input-group">
                                                <label for="fat" class="text-light">Fat:</label>
                                                <input type="number" step="0.01" id="fat" name="fat" class="small-input" placeholder="Enter fat percentage"  required>
                                            </div>

                                            <div class="input-group">
                                                <label for="snf" class="text-light">SNF:</label>
                                                <input type="number" step="0.01" id="snf" name="snf" class="small-input" placeholder="Enter SNF value" required>
                                            </div>

                                            <div class="input-group">
                                                <label for="reading" class="text-light">Reading:</label>
                                                <input type="number" step="0.01" id="reading" name="reading" class="small-input" placeholder="Enter reading value"  required>
                                            </div>
                                        </div>
                                    </div>
                                 
                                    <div class="row mb-5">

                                    <div class="input-group-container" style="align-items:center;">

                                         <div class="input-group">
                                            <label for="c_ltr" class="text-light">Collected Litres:</label>
                                            <input type="number"step="0.01" id="c_ltr" name="c_ltr" class="small-input" placeholder="Enter collected litres"  required oninput="checkLitres()">
                                        </div>

                                        <div class="input-group">
                                            <label for="a_ltr" class="text-light">Reported Litres:</label>
                                            <input type="number" step="0.01" id="a_ltr" name="a_ltr" class="small-input" placeholder="Enter reported litres"  required oninput="checkLitres()">
                                        </div>

                                        <div id="feedback-form">
                                            <label for="feedback" class="text-light">There Seems to have a diffrernce in collected and  reported litres:</label>

                                            <textarea id="feedback" name="feedback" class="small-input" placeholder="Enter that feedback to supplier!"> </textarea>
                                        </div>


                                        </div>
                                    </div>
                                    <label class="text-light" style="font-size: 30px; margin-left: 300px;">As Per Computer Readings</label>

                                    <div class="input-group" style="width: 500px; align-items: center; margin-left: 250px;">
                                        <label for="amount" class="text-light">Amount ₹:</label>
                                        <div class="input-group-prepend mt-4">
                                        
                                        <input type="number" step="0.01" id="amount" class="small-input" name="amount" placeholder="₹ Enter amount" required>
                                            </div>
                                    </div>
                                    <div class="input-group-container" style="align-items:center;">
                                    <div class="input-group">
                                        <input type="submit" name="sub" class="btn btn-primary btn-small" value="Submit">
                                    </div>
                                   
                                   
                                </form>
                 
                    <div class="input-group">
                                    <input type="button" class="btn btn-danger btn-small" value="Delete or Reset status" onclick="confirmDelete(<?php echo $m_id; ?>)">
                                </div>
                                   
                                    
                            </div></div></div></div></div></div></div></body>
           
<div id="confirmModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <p>Are you sure you want to delete this entry? This action cannot be undone.</p>
        <button id="confirmYes" class="btn btn-danger">Yes</button>
        <button id="confirmNo" class="btn btn-success">No</button>
    </div>
</div>

<script>

window.onload = checkLitres;

// Your JavaScript code as previously discussed
var currentId = null; // Global variable to hold the current ID

function confirmDelete(id) {
    currentId = id; // Store the ID in the global variable

    // Show the modal
    document.getElementById("confirmModal").style.display = "block";

    // Get the Yes button
    var yesButton = document.getElementById("confirmYes");
    var noButton = document.getElementById("confirmNo");

    // Set the Yes button action
    yesButton.onclick = function() {
        window.location.href = "../databases/delete_entry.php?id=" + encodeURIComponent(currentId);
    };

    // Set the No button action
    noButton.onclick = function() {
        window.location.href = "../databases/restentry.php?id=" + encodeURIComponent(currentId);
    };
}

// Close modal function
function closeModal() {
    document.getElementById("confirmModal").style.display = "none"; // Hide the modal
}


// Close modal when clicking outside
window.onclick = function(event) {
    var modal = document.getElementById("confirmModal");
    if (event.target == modal) {
        closeModal(); // Hide the modal
    }
}


function checkLitres() {
    const collectedLitres = parseFloat(document.getElementById('c_ltr').value) || 0;
    const reportedLitres = parseFloat(document.getElementById('a_ltr').value) || 0;
    
    const feedbackForm = document.getElementById('feedback-form');
    const feedbackTextarea = document.getElementById('feedback');
    
    if (collectedLitres !== reportedLitres) {
        feedbackForm.style.display = 'block'; // Show feedback form
        feedbackTextarea.setAttribute('required', 'required'); // Make textarea required
    } else {
        feedbackForm.style.display = 'none'; // Hide feedback form
        feedbackTextarea.removeAttribute('required'); // Remove required attribute
        feedbackTextarea.value = ''; // Clear the textarea content

    }
}

window.onload = checkLitres;



        document.getElementById('farmerSelect').addEventListener('change', function() {
            // Get the selected option
            var selectedOption = this.options[this.selectedIndex];
            
            // Get the data-name attribute
            var farmerName = selectedOption.getAttribute('data-name');
            
            // Set the text of the existing label
            document.getElementById('f_name').textContent = 'Name :'+farmerName; // Update the label text
        });
    </script>

</html>