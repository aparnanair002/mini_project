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
.tm-site-nav {
  padding: 20px 0; /* Add padding to the top and bottom */
}

.tm-site-nav-ul {
  list-style-type: none; /* Remove default list styling */
  padding: 0;           /* Remove padding */
  margin-bottom: 20px;  /* Add space between lists */
}

.tm-site-nav-ul li {
  margin-bottom: 10px;  /* Add space between list items */
  display: inline-block; /* Display list items on the same line */
}

.tm-site-nav-ul li button {
  margin-right: 20px; /* Add space between buttons */
  max-width:max-content;
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
  <ul class="tm-site-nav-ul">
    <li>
     
      <button>
        <a href="../milk_collector/src/html/index.php" style="color: white;">
          <i class="fas fa-ship tm-page-link-icon"> Worker Login / Sign Up &nbsp;</i>
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
            <img src="images/logo.png"  height="150px" width="150px">
         
            <h1 class="tm-site-name">Dairy Direct</h1>
          </div><form action="post" class="form-inline">
          <div class="search-container">
          
            <input type="text" id="search-bar" placeholder="Search for your location"><button onclick="searchFunction()" class="fas fa-search"> </button>
          </form>
        </div>
    
        <script src="script.js"></script>
    
    </div>
    
    
  <!-- Background video -->
  <div class="tm-video-wrapper">
      <i id="tm-video-control-button" class="fas fa-pause"></i>
      <video autoplay muted loop id="tm-video">
          <source src="video/wave-cafe.mp4" type="video/mp4">
      </video>
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

    $(document).ready(function(){

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
      window.onresize = function(){
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