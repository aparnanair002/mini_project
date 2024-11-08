<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Milk Collector</title>
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
        ?>
        <!-- Main wrapper -->
        <div class="body-wrapper">
            <!-- Header Start -->
            <?php include('header.php'); ?>
            <?php
                $reported_litres = '';

                // Check if 'id' is set in the URL
                if (isset($_GET['id'])) {
                    // Sanitize and retrieve m_id from the URL
                    $m_id = intval($_GET['id']); // Convert to integer for safety
                    
                    // Fetch the details from the database
                    $stmt = $con->prepare("
                        SELECT f.fat, f.snf, f.reading, 
                        f.c_ltr, f.a_ltr, f.amount, 
                        f.message, f.f_id, 
                        m.f_Id, m.f_name, m.f_homeaddress
                        FROM tbl_milk_records f 
                        JOIN tbl_dairyf m ON f.f_id = m.f_Id 
                        WHERE f.m_id = ?
                    ");
                    $stmt->bind_param("i", $m_id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                
                    // Check if a record was found
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $reported_litres = htmlspecialchars($row['c_ltr']); // Sanitize output
                        $f_name = htmlspecialchars($row['f_name']);
                        $fat = htmlspecialchars($row['fat']);
                        $snf = htmlspecialchars($row['snf']);
                        $reading = htmlspecialchars($row['reading']);
                        $a_ltr = htmlspecialchars($row['a_ltr']);
                        $amount = htmlspecialchars($row['amount']);
                        $home_address = htmlspecialchars($row['f_homeaddress']);
                        $feedback = htmlspecialchars($row['message']); // Fetch feedback
                    
                        
                    } else {
                        echo "<script>alert('No record found for the given m_id.');</script>";
                    }
                
                    // Close the statement
                    $stmt->close();
                }       
                
        
?>
            
     
            <div class="container-fluid" >
                <div class="row">
                    <div class="col-lg-12"> <!-- Updated to lg-12 -->
                    <div class="card" style="background-image: url('../assets/images/backgrounds/3p.jpg'); background-size: cover; background-position: center; width: 100%; height: 100%;">
                  <div class="card-body">
                                <div class="input-group-container">

                                    <div class="input-group" style="background-color:white;">
                                    <label for="name" class="text-light" style="font-size:18px;font-weight:500;color:brown !important;text-align:justify;"><p>Name:</p>
                                        <?php echo htmlspecialchars($f_name); ?> </label>
                                    </div>
                                    <div class="input-group" style="background-color:white;">
                                        <label for="address" class="text-light" style="font-size:18px;font-weight:500;color:brown !important;text-align:justify;"><p>Address:</p><?php echo htmlspecialchars($home_address); ?></label>
                                    </div>
                                    <div class="input-group" style="background-color:white;align-items:center;">
                                    <i class="ti ti-alert-circle fs-8 text-dark mb-2"></i>
                                    <label  class="text-light" style="font-size:18px;font-weight:500;color:brown !important;text-align:justify;"><I>Collected Litres - what your milkman has taken from respective homes.<br><br>Reported Litres - what's reported at centres. </I></label>
                                             </div>                                                

                                </div>
                                <h5 class="card-title fw-semibold mb-5 text-center text-light mt-5">Add Milk Details</h5>

                                <form action="../databases/edit_add_milk.php?id=<?php echo htmlspecialchars($m_id); ?>" method="post" class="form-inline">                                       
                                     <div class="row mt-5">
                                            <label class="text-light" style="font-size: 20px;">As Per the reading of Analyzer</label>
                                            <div class="input-group-container">

                                                <div class="input-group">
                                                    <label for="fat" class="text-light">Fat:</label>
                                                    <input type="number" step="0.01" id="fat" name="fat" class="small-input" placeholder="Enter fat percentage" value="<?php echo htmlspecialchars($fat); ?>" required>
                                                </div>

                                                <div class="input-group">
                                                    <label for="snf" class="text-light">SNF:</label>
                                                    <input type="number" step="0.01" id="snf" name="snf" class="small-input" placeholder="Enter SNF value" value="<?php echo htmlspecialchars($snf); ?>" required>
                                                </div>

                                                <div class="input-group">
                                                    <label for="reading" class="text-light">Reading:</label>
                                                    <input type="number" step="0.01" id="reading" name="reading" class="small-input" placeholder="Enter reading value" value="<?php echo htmlspecialchars($reading); ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                     
                                        <div class="row mb-5">

                                        <div class="input-group-container" style="align-items:center;">

                                             <div class="input-group">
                                                <label for="c_ltr" class="text-light">Collected Litres:</label>
                                                <input type="number"step="0.01" id="c_ltr" name="c_ltr" class="small-input" placeholder="Enter collected litres" value="<?php echo htmlspecialchars($reported_litres); ?>" required oninput="checkLitres()">
                                            </div>

                                            <div class="input-group">
                                                <label for="a_ltr" class="text-light">Reported Litres:</label>
                                                <input type="number" step="0.01" id="a_ltr" name="a_ltr" class="small-input" placeholder="Enter reported litres" value="<?php echo htmlspecialchars($a_ltr); ?>" required oninput="checkLitres()">
                                            </div>

                                            <div id="feedback-form">
                                                <label for="feedback" class="text-light">There Seems to have a diffrernce in collected and  reported litres:</label>

                                                <textarea id="feedback" name="feedback" class="small-input" placeholder="Enter that feedback to supplier!"> <?php echo htmlspecialchars($feedback);?></textarea>
                                            </div>


                                            </div>
                                        </div>
                                        <label class="text-light" style="font-size: 30px; margin-left: 300px;">As Per Computer Readings</label>

                                        <div class="input-group" style="width: 500px; align-items: center; margin-left: 250px;">
                                            <label for="amount" class="text-light">Amount ₹:</label>
                                            <div class="input-group-prepend mt-4">
                                            
                                            <input type="number" step="0.01" id="amount" class="small-input" name="amount" placeholder="₹ Enter amount" value="<?php echo htmlspecialchars($amount); ?>" required>
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
                                   
                                    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
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

</script>

</html>