<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dairy Direct</title>
    <link rel="icon" href="images/logo.png" type="images/logo.png">
    <link rel="stylesheet" href="fontawesome/css/all.min.css"> <!-- https://fontawesome.com/ -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400" rel="stylesheet" /> <!-- https://fonts.google.com/ -->
    <link rel="stylesheet" href="css/tooplate-wave-cafe.css">
    <!--
    Tooplate 2121 Wave Cafe
    https://www.tooplate.com/view/2121-wave-cafe
    -->
    <style>
        /* Basic styles for dropdown */
        .dropdown {
            position:fixed;
            display: inline-block;
            margin-top: 500px;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            bottom: 100%;
            
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .dropdown button {
            background-color: #4CAF50; /* Green */
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
        }
        .dropdown-results {
        border: 1px solid #ccc;
        max-height: 150px;
        overflow-y: auto;
        display: none; /* Initially hidden */
    }
    .dropdown-results div {
        padding: 8px;
        cursor: pointer;
    }
    .dropdown-results div:hover {
        background-color: #f0f0f0;
    }
    </style>
</head>
<body>
<nav class="tm-site-nav">
    <ul class="tm-site-nav-ul">
        <li>
            <button>
                <a href="fsignlogin.php" style="color: white;">
                    <i class="fas fa-ship tm-page-link-icon"> Farmer Login / Sign up &nbsp;</i>
                </a>
            </button>
        </li>
    </ul>
</nav>
<div class="tm-container">
    <div class="tm-row">
        <!-- Site Header -->
        <div class="tm-left">
            <div class="tm-left-inner">
                <div class="tm-site-header">
                    <img src="images/logo.png" height="150px" width="150px">
                    <h1 class="tm-site-name">Dairy Direct</h1>
                </div>
                <form action="" method="post" class="form-inline" >
    <div class="search-container">
        <select id="search-bar" name="location" onchange="locationSelected()">
        <option value="" disabled selected>Select your location</option>
        <?php
            // Include the database connection
            include("./databases/connection.php");

            // Check if the form is submitted
           
                $sql = "SELECT loc_id, loc_name FROM tbl_location ORDER BY loc_name ASC";
                $result = $con->query($sql);

                // Check if there are results and output them as options
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . htmlspecialchars($row['loc_id']) . "'>" . htmlspecialchars($row['loc_name']) . "</option>";
                    }
                } else {
                    echo "<option value=''>No locations found</option>";
                }
            
            // Close connection
            ?>  
        </select>
        <input type="submit" value="Go" name="sub" 
        style="background-color: #099;margin-top:20px; color: white; height: 50px; width: 50px; border: none; border-radius: 5px; cursor: pointer;">    </form>

    <?php
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sub'])) {
    $selectedLocationId = intval($_POST['location']); // Get selected location ID

    // Query to fetch milk_sold from tbl_stock based on selected loc_id
    $sql = "SELECT milk_sold, collected_milk FROM tbl_stock WHERE loc_id = ? and stock_date=curdate()";
    
    // Prepare statement to prevent SQL injection
    $stmt = $con->prepare($sql);
    
    // Check if the statement was prepared successfully
    if ($stmt) {
        // Bind the parameter with the appropriate type
        $stmt->bind_param("i", $selectedLocationId);
        $stmt->execute();
        $stmt->bind_result($milkSold, $collectedMilk); // Bind both results
        
        // Start outputting HTML
        echo '</div><div style="text-align:center;margin-top: 20px; padding: 15px;color:white; background-color: white; border: 1px solid #ccc; border-radius: 5px; background-image: url(\'./images/hero-bg.png\');">';
        // Check if there is a result and display it
        if ($stmt->fetch()) {
            $blup = $collectedMilk - $milkSold;

            echo "<p>Milk left: " . $blup . "&nbsp;ltrs</p>";
            // You can also display collected milk if needed
        } else {
            echo "<p>No Records Today.</p>";
        }

        // Close the div
        echo '</div>';

        // Close the statement
        $stmt->close();
    } else {
        echo "<p>Error preparing statement.</p>";
    }
}

    // Close connection
    $con->close();
    ?>
            </div>
        </div>

        <!-- Dropdown for Society and Admin Login -->
        
    </div>

    <!-- Background video -->
    <div class="tm-video-wrapper">
        <i id="tm-video-control-button" class="fas fa-pause"></i>
        <video autoplay muted loop id="tm-video">
            <source src="video/wave-cafe.mp4" type="video/mp4">
        </video>
    </div>
</div>
    <div class="dropdown">
            <button>More Login Options</button>
            <div class="dropdown-content">
                <a href="../adm/src/html/authentication-login.php">Society Login / Sign Up</a>
                <a href="../super_admin/src/html/authentication-login.php">Admin Login / Sign Up</a>
                <a href="../milk_collector/src/html/index.php">
                Worker Login / Sign Up </a>

            </div>
        </div>
  <script src="js/jquery-3.4.1.min.js"></script>    
  <script>

    function setVideoSize() {
      const vidWidth = 1920;
      const vidHeight = 1080;
      const windowWidth = window.innerWidth;
      const windowHeight = window.innerHeight;
      const tempVidWidth = windowHeight * vidWidth / vidHeight;
      const tempVidHeight = windowWidth * vidHeight / vidWidth;
      const newVidWidth = tempVidWidth > windowWidth ? tempVidWidth : windowWidth;
      const newVidHeight = tempVidHeight > windowHeight ? tempVidHeight : windowHeight;
      const tmVideo = $('#tm-video');

      tmVideo.css('width', newVidWidth);
      tmVideo.css('height', newVidHeight);
    }
   

    function openTab(evt, id) {
      $('.tm-tab-content').hide();
      $('#' + id).show();
            $('.tm-tab-link').removeClass('active');
            $(evt.currentTarget).addClass('active');
        }    

        function initPage() {
            let pageId = location.hash;

            if(pageId) {
                highlightMenu($(`.tm-page-link[href^="${pageId}"]`)); 
                showPage($(pageId));
            }
            else {
                pageId = $('.tm-page-link.active').attr('href');
                showPage($(pageId));
            }
        }

        function highlightMenu(menuItem) {
            $('.tm-page-link').removeClass('active');
            menuItem.addClass('active');
        }

        function showPage(page) {
            $('.tm-page-content').hide();
            page.show();
        }

        $(document).ready(function() {
            /***************** Pages *****************/
            initPage();

            $('.tm-page-link').click(function(event) {
                if(window.innerWidth > 991) {
                    event.preventDefault();
                }

                highlightMenu($(event.currentTarget));
                showPage($(event.currentTarget.hash));
            });

            /***************** Tabs *******************/
            $('.tm-tab-link').on('click', e => {
                e.preventDefault(); 
                openTab(e, $(e.target).data('id'));
            });

            $('.tm-tab-link.active').click(); // Open default tab

            /************** Video background *********/
            setVideoSize();

            // Set video background size based on window size
            let timeout;
            window.onresize = function() {
                clearTimeout(timeout);
                timeout = setTimeout(setVideoSize, 100);
            };

            // Play/Pause button for video background      
            const btn = $("#tm-video-control-button");

            btn.on("click", function(e) {
                const video = document.getElementById("tm-video");
                $(this).removeClass();

                if (video.paused) {
                    video.play();
                    $(this).addClass("fas fa-pause");
                } else {
                    video.pause();
                    $(this).addClass("fas fa-play");
                }
            });
        });
    </script>
</body>
</html>