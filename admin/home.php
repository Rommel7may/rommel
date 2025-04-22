<?php include 'db_connect.php' ?>
<style>
  body {
    background: #f4f6fa;
    font-family: 'Segoe UI', sans-serif;
  }

  .dashboard-welcome {
    font-size: 1.5rem;
    font-weight: 600;
    color: #2c3e50;
  }

  .summary_icon {
    font-size: 2.7rem;
    color: rgba(255, 255, 255, 0.8);
    position: absolute;
    top: 20px;
    right: 25px;
  }

  .card.stats-card {
    border: none;
    border-radius: 1rem;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.06);
    overflow: hidden;
    transition: all 0.3s ease;
    position: relative;
    cursor: pointer;
  }

  .card.stats-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 25px rgba(0, 0, 0, 0.12);
  }

  .card.stats-card .card-body {
    padding: 2rem;
    color: #fff;
    min-height: 150px;
    position: relative;
  }

  .card.stats-card h4 {
    font-size: 2rem;
    font-weight: 700;
  }

  .card.stats-card p {
    font-size: 1.1rem;
    font-weight: 500;
    margin-bottom: 0;
  }

  .bg-gradient-primary {
    background: linear-gradient(135deg, #1d3557, #457b9d);
  }

  .bg-gradient-info {
    background: linear-gradient(135deg, #118ab2, #06d6a0);
  }

  .bg-gradient-warning {
    background: linear-gradient(135deg, #f4a261, #e76f51);
  }

  .bg-gradient-success {
    background: linear-gradient(135deg, #2a9d8f, #264653);
  }

  .imgs {
    margin: 0.5em;
    max-width: 100%;
    max-height: 100%;
  }

  .imgs img {
    max-width: 100%;
    max-height: 100%;
    cursor: pointer;
    transition: 0.3s ease;
    border-radius: 10px;
  }

  .imgs img:hover {
    transform: scale(1.04);
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.25);
  }

  #imagesCarousel,
  #imagesCarousel .carousel-inner,
  #imagesCarousel .carousel-item {
    height: 60vh !important;
    background: #000;
  }

  #imagesCarousel .carousel-item.active,
  #imagesCarousel .carousel-item-next {
    display: flex !important;
  }

  #imagesCarousel img {
    margin: auto;
    width: auto !important;
    height: auto !important;
    max-height: 100% !important;
    max-width: 100% !important;
  }
</style>

<div class="container-fluid px-4 py-3">
  <div class="row mb-4">
    <div class="col-lg-12">
      <div class="card shadow-sm border-0">
        <div class="card-body py-4 px-4">
          <div class="dashboard-welcome">
            Welcome back, <?= $_SESSION['login_name'] ?>!
          </div>
          <hr>
          <div class="row g-4">
            <div class="col-md-3">
              <div class="card stats-card bg-gradient-primary">
                <div class="card-body">
                  <span class="summary_icon"><i class="fa fa-users"></i></span>
                  <h4><?= $conn->query("SELECT * FROM alumnus_bio where status = 1")->num_rows ?></h4>
                  <p>Alumni</p>
                </div>
              </div>
            </div>
            <!-- <div class="col-md-3">
              <div class="card stats-card bg-gradient-info">
                <div class="card-body">
                  <span class="summary_icon"><i class="fa fa-comments"></i></span>
                  <h4><?= $conn->query("SELECT * FROM forum_topics")->num_rows ?></h4>
                  <p>Forum Topics</p>
                </div>
              </div>
            </div> -->
            <div class="col-md-3">
              <div class="card stats-card bg-gradient-warning">
                <div class="card-body">
                  <span class="summary_icon"><i class="fa fa-briefcase"></i></span>
                  <h4><?= $conn->query("SELECT * FROM careers")->num_rows ?></h4>
                  <p>Posted Jobs</p>
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="card stats-card bg-gradient-success">
                <div class="card-body">
                  <span class="summary_icon"><i class="fa fa-calendar-day"></i></span>
                  <h4><?= $conn->query("SELECT * FROM events where date_format(schedule,'%Y-%m-%d') >= '".date('Y-m-d')."' ")->num_rows ?></h4>
                  <p>Upcoming Events</p>
                </div>
              </div>
            </div>
          </div> <!-- row -->
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  // Keep your AJAX tracking code here (unchanged for now)
  $('#manage-records').submit(function (e) {
    e.preventDefault()
    start_load()
    $.ajax({
      url: 'ajax.php?action=save_track',
      data: new FormData($(this)[0]),
      cache: false,
      contentType: false,
      processData: false,
      method: 'POST',
      type: 'POST',
      success: function (resp) {
        resp = JSON.parse(resp)
        if (resp.status == 1) {
          alert_toast("Data successfully saved", 'success')
          setTimeout(function () {
            location.reload()
          }, 800)
        }
      }
    })
  });

  $('#tracking_id').on('keypress', function (e) {
    if (e.which == 13) get_person()
  });

  $('#check').on('click', function (e) {
    get_person()
  });

  function get_person() {
    start_load()
    $.ajax({
      url: 'ajax.php?action=get_pdetails',
      method: "POST",
      data: { tracking_id: $('#tracking_id').val() },
      success: function (resp) {
        if (resp) {
          resp = JSON.parse(resp)
          if (resp.status == 1) {
            $('#name').html(resp.name)
            $('#address').html(resp.address)
            $('[name="person_id"]').val(resp.id)
            $('#details').show()
            end_load()
          } else if (resp.status == 2) {
            alert_toast("Unknown tracking ID.", 'danger')
            end_load()
          }
        }
      }
    })
  }
</script>