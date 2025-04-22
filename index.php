<!DOCTYPE html>
<html lang="en">
    <?php
    session_start();
    include('admin/db_connect.php');
    ob_start();
        $query = $conn->query("SELECT * FROM system_settings limit 1")->fetch_array();
         foreach ($query as $key => $value) {
          if(!is_numeric($key))
            $_SESSION['system'][$key] = $value;
        }
    ob_end_flush();
    include('header.php');

	
    ?>

    <style>
    	header.masthead {
		  background: url(admin/assets/uploads/<?php echo $_SESSION['system']['cover_img'] ?>);
		  background-repeat: no-repeat;
		  background-size: cover;
		}
    
  #viewer_modal .btn-close {
    position: absolute;
    z-index: 999999;
    /*right: -4.5em;*/
    background: unset;
    color: white;
    border: unset;
    font-size: 27px;
    top: 0;
}
#viewer_modal .modal-dialog {
        width: 80%;
    max-width: unset;
    height: calc(90%);
    max-height: unset;
}
  #viewer_modal .modal-content {
       background: black;
    border: unset;
    height: calc(100%);
    display: flex;
    align-items: center;
    justify-content: center;
  }
  #viewer_modal img,#viewer_modal video{
    max-height: calc(100%);
    max-width: calc(100%);
  }
  
    body {
  background: url('assets/img/bg.jpg') no-repeat center center fixed;
  background-size: cover;
}


html, body {
  height: 100%;
  margin: 0;
  padding: 0;
}


 

a.jqte_tool_label.unselectable {
    height: auto !important;
    min-width: 4rem !important;
    padding:5px
}/*
a.jqte_tool_label.unselectable {
    height: 22px !important;
}*/

.back-to-top {
  position: fixed;
  bottom: 40px;
  right: 30px;
  background-color: #800000; /* Outer circle */
  width: 60px;
  height: 60px;
  border-radius: 50%;
  text-align: center;
  line-height: 60px;
  z-index: 9999;
  transition: background-color 0.3s ease;
  text-decoration: none;
  display: flex;
  align-items: center;
  justify-content: center;
}

.back-to-top .inner-circle {
  display: inline-block;
  width: 40px;
  height: 40px;
  background-color:rgb(255, 180, 0); /* Inner circle */
  color: #800000;            /* Arrow color */
  font-size: 24px;
  line-height: 40px;
  border-radius: 50%;
  transition: transform 0.3s ease;
  text-align: center;
}

.back-to-top:hover .inner-circle {
  transform: scale(1.1);
 
}

    </style>
    <body id="page-top">
    <a href="#" class="back-to-top" title="Back to Top" style="display: none;text-decoration:none">
  <span class="inner-circle">&#8679;</span>
</a>


        <!-- Navigation-->
        <div class="toast" id="alert_toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-body text-white">
        </div>
      </div>
      <nav class="navbar navbar-expand-lg navbar-light fixed-top py-3" id="mainNav">
    <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="./"><?php echo $_SESSION['system']['name'] ?></a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive"
            aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto my-2 my-lg-0">
                <!-- Visible to everyone -->
                <li class="nav-item"><a class="nav-link js-scroll-trigger" href="index.php?page=home">Home</a></li>
                <li class="nav-item"><a class="nav-link js-scroll-trigger" href="index.php?page=alumni_list">Alumni</a></li>
                <li class="nav-item"><a class="nav-link js-scroll-trigger" href="index.php?page=about">About</a></li>

                <?php if(isset($_SESSION['login_id'])): ?>
                    <!-- Only visible when logged in -->
                    <!-- <li class="nav-item"><a class="nav-link js-scroll-trigger" href="index.php?page=gallery">Gallery</a></li> -->
                    <li class="nav-item"><a class="nav-link js-scroll-trigger" href="index.php?page=careers">Jobs</a></li>
                    <li class="nav-item"><a class="nav-link js-scroll-trigger" href="..\..\tracking">Tracer</a></li>
                    <!-- <li class="nav-item"><a class="nav-link js-scroll-trigger" href="index.php?page=forum">Forums</a></li> -->

                    <!-- User dropdown -->
                    <li class="nav-item">
                        <div class="dropdown mr-4">
                            <a href="#" class="nav-link js-scroll-trigger" id="account_settings" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?php echo $_SESSION['login_name'] ?> <i class="fa fa-angle-down"></i>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="account_settings" style="left: -2.5em;">
                                <a class="dropdown-item" href="index.php?page=my_account" id="manage_my_account"><i class="fa fa-cog"></i> Manage Account</a>
                                <a class="dropdown-item" href="admin/ajax.php?action=logout2"><i class="fa fa-power-off"></i> Logout</a>
                            </div>
                        </div>
                    </li>
                <?php else: ?>
                    <!-- Only visible when NOT logged in -->
                    <li class="nav-item"><a class="nav-link js-scroll-trigger" href="#" id="login">Login</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

       
        <?php 
        $page = isset($_GET['page']) ?$_GET['page'] : "home";
        include $page.'.php';
        ?>
       

<div class="modal fade" id="confirm_modal" role='dialog'>
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Confirmation</h5>
      </div>
      <div class="modal-body">
        <div id="delete_content"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id='confirm' onclick="">Continue</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="uni_modal" role='dialog'>
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title"></h5>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id='submit' onclick="$('#uni_modal form').submit()">Save</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
      </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="uni_modal_right" role='dialog'>
    <div class="modal-dialog modal-full-height  modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="fa fa-arrow-righ t"></span>
        </button>
      </div>
      <div class="modal-body">
      </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="viewer_modal" role='dialog'>
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
              <button type="button" class="btn-close" data-dismiss="modal"><span class="fa fa-times"></span></button>
              <img src="" alt="">
      </div>
    </div>
  </div>
  <div id="preloader"></div>







  <footer style="background: linear-gradient(to top, maroon, rgb(23, 23, 23));" class="py-5 text-white position-relative overflow-hidden">
  <div class="container text-center">
    <div class="row justify-content-center mb-4">
      <div class="col-lg-8">
        <h2 style="color:rgb(255, 180, 0)" class="mb-3">Contact Details</h2>
        <hr class="divider my-3" style="border-top: 2px solid rgb(255, 180, 0); width: 60px; margin: 0 auto;" />
      </div>
    </div>

    <!-- First Row: Contact and Email -->
    <div class="row justify-content-start">
      <div class="col-md-6 mb-4">
        <i class="fas fa-phone fa-lg text-warning mb-2"></i>
        <div style="color: white"><?php echo $_SESSION['system']['contact'] ?></div>
      </div>
      <div class="col-md-6 mb-4">
        <i class="fas fa-envelope fa-lg text-warning mb-2"></i>
        <div>
          <a class="text-white text-decoration-none" href="mailto:<?php echo $_SESSION['system']['email'] ?>">
            <?php echo $_SESSION['system']['email'] ?>
          </a>
        </div>
      </div>
    </div>

    <!-- Second Row: Location and Facebook -->
    <div class="row justify-content-start" style="color: white;">
      <div class="col-md-6 mb-4">
        <i class="fas fa-map-marker-alt fa-lg text-warning mb-2"></i>
        <div style="color: white;">
          <?php echo $_SESSION['system']['location'] ?? ' Don Honorio Ventura State University, Sta Catalina, Lubao, Pampanga' ?>
        </div>
      </div>
      <div class="col-md-6 mb-4">
        <i class="fab fa-facebook fa-lg text-warning mb-2"></i>
        <div>
          <a class="text-white text-decoration-none" href="<?php echo $_SESSION['system']['facebook'] ?>" target="_blank">
            Visit our Dhvsu Page
          </a>
        </div>
      </div>
    </div>

    <!-- Footer Note -->
    <div class="mt-4 small text-muted text-center">
      &copy; 2025 - <?php echo $_SESSION['system']['name'] ?> |
      <a href="#" class="text-warning text-decoration-none">Dhvsu Alumni</a>
    </div>
  </div>

  <!-- Bottom-right Image -->
  <img src="assets/img/cover_img.png" alt="Footer Decoration" style="position: absolute; bottom: 100px; right: 20px; height: 150px; max-width: 200px; opacity: 0.4; pointer-events: none;">
</footer>



        







       <?php include('footer.php') ?>
    </body>
    <script type="text/javascript">
      $('#login').click(function(){
        uni_modal("Login",'login.php')
      })
      $(window).scroll(function () {
    if ($(this).scrollTop() > 300) {
      $('.back-to-top').fadeIn();
    } else {
      $('.back-to-top').fadeOut();
    }
  });

  // Scroll to top smoothly on click
  $('.back-to-top').click(function (e) {
    e.preventDefault();
    $('html, body').animate({ scrollTop: 0 }, 2000);
    return false;
  });
    </script>
    <?php $conn->close() ?>

</html>
