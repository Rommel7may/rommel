<?php include 'db_connect.php'; ?>
<?php
if (isset($_GET['id'])) {
    $qry = $conn->query("SELECT * FROM events WHERE id = " . $_GET['id']);
    foreach ($qry->fetch_array() as $k => $val) {
        $$k = $val;
    }
}
?>

<style>
    body {
        background: #f5f7fb;
        font-family: 'Segoe UI', sans-serif;
    }

    .card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.05);
        margin-top: 40px;
        transition: all 0.3s ease-in-out;
    }

    .card:hover {
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.08);
    }

    .card-body {
        background: linear-gradient(to right, #ffffff, #f8f9fa);
        border-radius: 16px;
    }

    .form-control {
        border-radius: 10px;
        border: 1px solid #ced4da;
        padding: 12px;
        font-size: 15px;
        background-color: #fff;
        transition: 0.3s;
    }

    .form-control:focus {
        border-color: #2c82e0;
        box-shadow: 0 0 5px rgba(44, 130, 224, 0.2);
    }

    .form-group label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 5px;
    }

    .btn-primary {
        background: linear-gradient(to right, #2c82e0, #1b5db5);
        border: none;
        padding: 12px 30px;
        border-radius: 10px;
        font-size: 16px;
        transition: 0.3s;
    }

    .btn-primary:hover {
        background: linear-gradient(to right, #1b5db5, #13478a);
    }

    #banner-field {
        height: 140px;
        width: auto;
        border-radius: 8px;
        margin-top: 10px;
        object-fit: cover;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    .jqte_editor {
        min-height: 220px !important;
        border-radius: 10px;
        padding: 10px;
        border: 1px solid #ccc;
    }

    .form-section {
        margin-bottom: 25px;
    }

    .text-primary {
        color: #2c82e0 !important;
    }

    .imgF {
        position: relative;
        margin: 1em;
        border: 1px dashed #007bff66;
        padding: 6px;
        border-radius: 8px;
        background: #f8f9fa;
    }

    .imgF img {
        height: 90px;
        width: auto;
        border-radius: 4px;
    }

    .imgF .rem {
        position: absolute;
        top: -10px;
        left: -10px;
        background: #dc3545;
        color: white;
        padding: 5px;
        border-radius: 50%;
        font-size: 12px;
        cursor: pointer;
    }
</style>

<div class="container">
    <div class="col-lg-10 offset-lg-1">
        <div class="card">
            <div class="card-body p-4">
                <h4 class="mb-4 font-weight-bold text-primary">Manage Event</h4>
                <form id="manage-event">
                    <input type="hidden" name="id" value="<?= isset($id) ? $id : '' ?>">

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Event Title</label>
                            <input type="text" class="form-control" name="title" value="<?= isset($title) ? $title : '' ?>" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Schedule</label>
                            <input type="text" class="form-control datetimepicker" name="schedule" value="<?= isset($schedule) ? date("Y-m-d H:i", strtotime($schedule)) : '' ?>" required autocomplete="off">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Location</label>
                            <input type="text" class="form-control" name="location" value="<?= isset($location) ? $location : '' ?>" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Department</label>
                            <input type="text" class="form-control" name="department" value="<?= isset($department) ? $department : '' ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="content" id="content" class="form-control jqte" required><?= isset($content) ? html_entity_decode($content) : '' ?></textarea>
                    </div>

                    <div class="form-row align-items-center">
                        <div class="form-group col-md-6">
                            <label>Banner Image</label>
                            <input type="file" class="form-control" name="banner" onchange="displayImg2(this, $(this))">
                        </div>
                        <div class="form-group col-md-6">
                            <?php if (isset($banner) && $banner): ?>
                                <img src="assets/uploads/<?= $banner ?>" alt="Banner Image" id="banner-field">
                            <?php else: ?>
                                <img src="" id="banner-field" style="display: none;">
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="text-right">
                        <button class="btn btn-primary btn-lg mt-3">Save Event</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="img-clone" class="imgF" style="display: none;">
    <span class="rem badge badge-primary" onclick="rem_func($(this))"><i class="fa fa-times"></i></span>
</div>

<script>
    $('.jqte').jqte();

    $('#manage-event').submit(function(e) {
        e.preventDefault();
        start_load();
        $.ajax({
            url: 'ajax.php?action=save_event',
            data: new FormData(this),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            success: function(resp) {
                if (resp == 1) {
                    alert_toast("Event successfully saved", 'success');
                    setTimeout(() => location.href = "index.php?page=events", 1500);
                }
            }
        });
    });

    function displayImg2(input, _this) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = e => {
                $('#banner-field').attr('src', e.target.result).show();
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function rem_func(_this) {
        _this.closest('.imgF').remove();
        if ($('#drop .imgF').length <= 0) {
            $('#drop').append('<span id="dname" class="text-center">Drop Files Here</span>');
        }
    }
</script>