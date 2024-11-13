<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin-Diarydiary</title>
  <link rel="shortcut icon" type="image/png" href="../assets/images/logos/favicon.png" />
  <link rel="stylesheet" href="../assets/css/styles.min.css" />
  <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: auto;
        }
        h2 {
            text-align: center;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
        .message {
            margin-top: 20px;
            text-align: center;
            color: green;
        }
        .error {
            color: red;
        }
    </style>
</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <!-- Sidebar Start -->
    <?php
   session_start();
if (!isset($_SESSION['s_Id'])) {
  header('Location: authentication-login.php');
  exit;
}
include('../databases/connection.php');
include("sidebar.php");

$f_id = $_GET['id'];

$update_message = '';

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Get the submitted data
    $f_id = isset($_GET['id']) ? $_GET['id'] : null;
    $pay = isset($_POST['pay']) ? $_POST['pay'] : null;

    // Validate inputs
    if ($f_id === null || !is_numeric($pay)) {
        echo "Invalid input.";
        exit;
    }

    $pay = mysqli_real_escape_string($con, $pay);
    
    // Prepare the select query
    $selectQuery = "SELECT amount,paid FROM tbl_payment WHERE f_id = ?";
    $stmt = $con->prepare($selectQuery);
    $stmt->bind_param("s", $f_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $amount = $row["amount"];
        $paid=$row["paid"];
    } else {
        echo "No payment record found.";
        exit;
    }

    $date = date('Y-m-d'); // Current date
    $paid = $paid + $pay;
    $res=$amount-$paid;

    // Prepare the update query
    $query = "UPDATE tbl_payment SET date = ?, paid = ?, rest = ? WHERE f_id = ?";
    $updateStmt = $con->prepare($query);
    $updateStmt->bind_param("sdss", $date, $paid, $res, $f_id);

    if ($updateStmt->execute()) {
        $update_message = 'Payment record updated successfully.';
    } else {
        $update_message = 'Error updating record: ' . $updateStmt->error;
    }

    $updateStmt->close();
    $stmt->close();
    echo $update_message; // Output the message
}

if (!empty($f_id)) {
    // Query to get payment details along with farmer's name using JOIN
    $query = "
        SELECT p.*, d.f_name 
        FROM tbl_payment p 
        INNER JOIN tbl_dairyf d ON p.f_id = d.f_id 
        WHERE p.f_id = $f_id
    ";
    
    $result = mysqli_query($con, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $f_id = $row['f_id'];
        $amount = $row['amount'];
        $paid=$row['paid'];
        $rest=$row['rest'];
        $f_name = $row['f_name']; // Fetching farmer's name
    } else {
        $update_message = 'No record found for this f_id.';
    }
}
?>

<div class="container">
    <h2>Update Payment Record</h2>

    <?php if ($update_message): ?>
        <div class="message <?php echo strpos($update_message, 'Error') !== false ? 'error' : ''; ?>">
            <?php echo $update_message; ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
       
        <div class="form-group">
            <label for="f_name">Farmer Name:</label>
            <span id="f_name"><?php echo isset($f_name) ? $f_name : ''; ?></span>
        </div>
        <div class="form-group">
            <label for="amount">Amount to pay:</label>
            <span id="amount"><?php echo $rest; ?></span>
        </div>
        <div class="form-group">
            <label for="date">Update Date:</label>
            <input type="text" id="date" name="date" value="<?php echo date('Y-m-d'); ?>" readonly>
        </div>
        <div class="form-group">
            <label for="pay">Paid:</label>
            <input type="number" id="pay" name="pay">
        </div>
        <input type="submit" value="Update" name="submit" class="btn btn-success" style="width:450px;">
    </form>
</div>


              <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/sidebarmenu.js"></script>
  <script src="../assets/js/app.min.js"></script>
  <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
</body>

</html>