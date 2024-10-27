<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar Example</title>
    <style>  
/* .sidebar-sublist ::before{
  display: none;
}
.sidebar-sublist ::after {
    display: block; /* Ensure the sublist is always visible 
    list-style: none;
    padding-left: 15px; /* Indent sublist
    margin: 0; /* Remove default margin 
}    */

        .sidebar-item {
            position: relative;
        }

        /* Sidebar link */
        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 10px 15px;
            text-decoration: none;
            color: #333; /* Change this to your desired text color */
            transition: background-color 0.3s;
        }

 
        /* Hover effect for sidebar link */
        .sidebar-link:hover {
            background-color: #f0f0f0; /* Change to desired hover color */
        }

        /* Subitem link */
        .sidebar-sublink {
            display: block;
          
            padding: 8px 10px;
            text-decoration: none;
            color: #333; /* Change this to your desired sub-item text color */
            transition: background-color 0.3s;
        }

        /* Hover effect for sub-item link */
        .sidebar-sublink:hover {
            background-color: #e0e0e0; /* Change to desired hover color for sub-items */
        }
    </style>

      
</head>
<body>
    <!-- Sidebar Start -->
    <aside class="left-sidebar">
        <!-- Sidebar scroll-->
        <div>
            <div class="brand-logo d-flex align-items-center justify-content-between">
                <a href="./index.php" class="text-nowrap logo-img">
                    <img src="../assets/images/logos/dark-logo.svg" width="250" alt="" />
                </a>
                <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                    <i class="ti ti-x fs-8"></i>
                </div>
            </div>
            <!-- Sidebar navigation-->
            <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
                <ul id="sidebarnav">
                    <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">Home</span>
                    </li>
                    <li class="sidebar-item active">
                  <a class="sidebar-sublink" href="./index.php" aria-expanded="false">
                      <span>
                          <i class="ti ti-layout-dashboard"></i>
                      </span>
                      
                      <span class="hide-menu" style="margin-left:20px">Dashboard</span>
                  </a>
                  </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" aria-expanded="false">
                            <span>
                                <i class="ti ti-list"></i>
                            </span>
                            <span class="hide-menu">Dairy Farmer</span>
                            <span>
                                <i class="ti ti-arrow-down"></i>
                            </span>
                        </a>
                        <ul class="sidebar-sublist">
                            <li class="sidebar-item">
                                <a class="sidebar-sublink" href="./vuser.php">
                                    <i class="ti ti-pin"></i><span class="hide-menu" style="margin-left: 20px; margin-bottom: 20px;">View Farmer</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-sublink" href="./validate.php">
                                    <i class="ti ti-pin"></i><span class="hide-menu" style="margin-left: 20px; margin-bottom: 20px;">Validate Farmer</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-sublink" href="./report.php">
                                    <i class="ti ti-pin"></i><span class="hide-menu" style="margin-left: 20px; margin-bottom: 20px;">Report</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="sidebar-item">
                    <a class="sidebar-link" aria-expanded="false">
                            <span>
                                <i class="ti ti-list"></i>
                            </span>
                            <span class="hide-menu">Milk Collector</span>
                            <span>
                                <i class="ti ti-arrow-down"></i>
                            </span>
                        </a>
                      
                        <ul class="sidebar-sublist">
                            <li class="sidebar-item">
                                <a class="sidebar-sublink" href="./v_all_collector.php">
                                    <i class="ti ti-pin"></i><span class="hide-menu" style=" margin-bottom: 20px;margin-left: 20px;">View</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-sublink" href="./Mcollector_validate.php">
                                    <i class="ti ti-pin"></i><span class="hide-menu" style=" margin-bottom: 20px;margin-left: 20px;">Validate Milk Collector</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                       
                    <li class="sidebar-item">
                        <a class="sidebar-link" aria-expanded="false">
                            <span>
                                <i class="ti ti-list"></i>
                            </span>
                            <span class="hide-menu">Milk</span>
                            <span>
                                <i class="ti ti-arrow-down"></i>
                            </span>
                        </a>
                        <ul class="sidebar-sublist">
                            <li class="sidebar-item">
                                <a class="sidebar-sublink" href="./milk_edit.php">
                                    <i class="ti ti-pin"></i><span class="hide-menu" style=" margin-bottom: 20px;margin-left: 20px;">Milk Edit</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-sublink" href="./vmilk.php">
                                    <i class="ti ti-pin"></i><span class="hide-menu" style=" margin-bottom: 20px;margin-left: 20px;">Validate Milk Collected</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-sublink" href="./milk_report.php">
                                    <i class="ti ti-pin"></i><span class="hide-menu" style=" margin-bottom: 20px;margin-left: 20px;">Report of Milk</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link" href="./logout.php" aria-expanded="false">
                            <span>
                                <i class="ti ti-logout"></i>
                            </span>
                            <span class="hide-menu">Logout</span>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- End Sidebar navigation -->
        </div>
        <!-- End Sidebar scroll-->
    </aside>
    <!-- Sidebar End -->
    <script>
    // Hide all sublists on page load
    document.querySelectorAll('.sidebar-sublist').forEach(sublist => {
        sublist.style.display = 'none';
    });

    document.querySelectorAll('.sidebar-link').forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent default anchor click behavior

            // Get the parent item
            const parentItem = this.parentElement;
            const submenu = parentItem.querySelector('.sidebar-sublist');

            // Toggle the display of the submenu
            if (submenu) {
                // Check if the submenu is currently displayed
                const isDisplayed = submenu.style.display === 'block';
                
                // Hide all other sublists
                document.querySelectorAll('.sidebar-sublist').forEach(sub => {
                    sub.style.display = 'none';
                });

                // If it was not displayed, show it
                submenu.style.display = isDisplayed ? 'none' : 'block';
            }
        });
    });
</script>

</body>
</html>