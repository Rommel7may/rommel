<?php 
include 'admin/db_connect.php'; 
?>

<style>
    .masthead {
        min-height: 23vh !important;
        height: 23vh !important;
    }
    .masthead:before {
        min-height: 23vh !important;
        height: 23vh !important;
    }
    img#cimg {
        max-height: 10vh;
        max-width: 6vw;
    }
</style>

<header class="masthead">
    <div class="container-fluid h-100">
        <div class="row h-100 align-items-center justify-content-center text-center">
            <div class="col-lg-8 align-self-end mb-4 page-title">
                <h3 class="text-white">Manage Account</h3>
                <hr class="divider my-4" />
            </div>
        </div>
    </div>
</header>

<div class="container mt-3 pt-2">
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-body">
                <div class="container-fluid">
                    <form action="" id="update_account">
                        <div class="row form-group">
                            <div class="col-md-4">
                                <label class="control-label">Last Name</label>
                                <input type="text" class="form-control" name="lastname"
                                    value="<?= $_SESSION['bio']['lastname'] ?? '' ?>" required>
                            </div>
                            <div class="col-md-4">
                                <label class="control-label">First Name</label>
                                <input type="text" class="form-control" name="firstname"
                                    value="<?= $_SESSION['bio']['firstname'] ?? '' ?>" required>
                            </div>
                            <div class="col-md-4">
                                <label class="control-label">Middle Name</label>
                                <input type="text" class="form-control" name="middlename"
                                    value="<?= $_SESSION['bio']['middlename'] ?? '' ?>">
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-4">
                                <label class="control-label">Gender</label>
                                <select class="custom-select" name="gender" required>
                                    <option value="Male" <?= (($_SESSION['bio']['gender'] ?? '') == 'Male') ? 'selected' : '' ?>>Male</option>
                                    <option value="Female" <?= (($_SESSION['bio']['gender'] ?? '') == 'Female') ? 'selected' : '' ?>>Female</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="control-label">Batch</label>
                                <input type="text" class="form-control datepickerY" name="batch"
                                    value="<?= $_SESSION['bio']['batch'] ?? '' ?>" required>
                            </div>
                            <div class="col-md-4">
                                <label class="control-label">Course Graduated</label>
                                <select class="custom-select select2" name="course_id" required>
                                    <option disabled selected>Please Select</option>
                                    <?php 
                                    $course = $conn->query("SELECT * FROM courses ORDER BY course ASC");
                                    while($row = $course->fetch_assoc()):
                                    ?>
                                        <option value="<?= $row['id'] ?>"
                                            <?= ($_SESSION['bio']['course_id'] ?? '') == $row['id'] ? 'selected' : '' ?>>
                                            <?= $row['course'] ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-5">
                                <label class="control-label">Currently Connected To</label>
                                <textarea name="connected_to" cols="30" rows="3" class="form-control"><?= $_SESSION['bio']['connected_to'] ?? '' ?></textarea>
                            </div>
                            <div class="col-md-5">
                                <label class="control-label">Image</label>
                                <input type="file" class="form-control" name="img" onchange="displayImg(this, $(this))">
                                <img src="admin/assets/uploads/<?= $_SESSION['bio']['avatar'] ?? 'default.png' ?>" alt="" id="cimg">
                            </div>  
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <label class="control-label">Email</label>
                                <input type="email" class="form-control" name="email"
                                    value="<?= $_SESSION['bio']['email'] ?? '' ?>" required>
                            </div>
                            <div class="col-md-4">
                                <label class="control-label">Password</label>
                                <input type="password" class="form-control" name="password">
                                <small><i>Leave this blank if you don't want to change your password</i></small>
                            </div>
                        </div>

                        <div id="msg"></div>
                        <hr class="divider">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button class="btn btn-primary">Update Account</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JS -->
<script>
$('.datepickerY').datepicker({
    format: " yyyy", 
    viewMode: "years", 
    minViewMode: "years"
});

$('.select2').select2({
    placeholder: "Please Select Here",
    width: "100%"
});

function displayImg(input, _this) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#cimg').attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
}

$('#update_account').submit(function(e){
    e.preventDefault();
    start_load();
    $.ajax({
        url: 'admin/ajax.php?action=update_account',
        data: new FormData($(this)[0]),
        cache: false,
        contentType: false,
        processData: false,
        method: 'POST',
        success: function(resp){
            if(resp == 1){
                alert_toast("Account successfully updated.", 'success');
                setTimeout(function(){
                    location.reload();
                }, 700);
            } else {
                $('#msg').html('<div class="alert alert-danger">Email already exists.</div>');
                end_load();
            }
        }
    });
});
</script>