<?php include 'db_connect.php'; ?>
<?php
if (isset($_GET['id'])) {
	$qry = $conn->query("SELECT * FROM careers WHERE id = " . $_GET['id'])->fetch_array();
	foreach ($qry as $k => $v) {
		$$k = $v;
	}
}
?>

<style>
	.card-header.bg-gradient {
		background: linear-gradient(to right, #007bff, #00c6ff);
		box-shadow: inset 0 -1px 0 rgba(255, 255, 255, 0.1);
	}
	.form-control {
		border-radius: 0.5rem;
		padding: 0.75rem 1rem;
		transition: border-color 0.3s, box-shadow 0.3s;
	}
	.form-control:focus {
		border-color: #80bdff;
		box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
	}
	.card {
		border-radius: 1rem;
		overflow: hidden;
	}
	label {
		font-weight: 500;
	}
	.btn-success {
		border-radius: 50px;
		padding: 0.5rem 2rem;
		font-weight: 500;
		transition: 0.3s all ease-in-out;
	}
	.btn-success:hover {
		transform: scale(1.03);
	}
</style>

<div class="container py-4 px-3">
	<div class="card shadow-lg">
		<div class="card-header bg-gradient text-white">
			<h5 class="mb-0">
				<i class="fa fa-briefcase me-2"></i>
				<?php echo isset($id) ? "Edit Career Opportunity" : "Add New Career Opportunity"; ?>
			</h5>
		</div>
		<div class="card-body bg-light">
			<form action="" id="manage-career" class="row g-3">
				<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">

				<div class="col-md-6">
					<label for="company" class="form-label">Company <span class="text-danger">*</span></label>
					<input type="text" id="company" name="company" class="form-control" placeholder="Enter company name" value="<?php echo isset($company) ? $company : '' ?>" required>
				</div>

				<div class="col-md-6">
					<label for="title" class="form-label">Job Title <span class="text-danger">*</span></label>
					<input type="text" id="title" name="title" class="form-control" placeholder="Enter job title" value="<?php echo isset($job_title) ? $job_title : '' ?>" required>
				</div>

				<div class="col-md-6">
					<label for="location" class="form-label">Location</label>
					<input type="text" id="location" name="location" class="form-control" placeholder="Enter job location" value="<?php echo isset($location) ? $location : '' ?>">
				</div>

				<div class="col-md-6">
					<label for="schedule" class="form-label">Schedule</label>
					<input type="datetime-local" id="schedule" name="schedule" class="form-control"
						value="<?php echo isset($schedule) && !empty($schedule) ? date('Y-m-d\TH:i', strtotime($schedule)) : date('Y-m-d\TH:i'); ?>">
				</div>

				<div class="col-md-6">
					<label for="department" class="form-label">Department</label>
					<input type="text" id="department" name="department" class="form-control" placeholder="Enter department name" value="<?php echo isset($department) ? $department : '' ?>">
				</div>

				<div class="col-md-12">
					<label for="description" class="form-label">Job Description</label>
					<textarea name="description" id="description" class="form-control text-jqte" rows="6"><?php echo isset($description) ? $description : '' ?></textarea>
				</div>

				<div class="col-12 text-end mt-3">
					<button type="submit" class="btn btn-success shadow">
						<i class="fa fa-save me-2"></i>Save Job
					</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script>
	$('.text-jqte').jqte();

	$('#manage-career').submit(function (e) {
		e.preventDefault();
		start_load();

		$.ajax({
			url: 'ajax.php?action=save_career',
			method: 'POST',
			data: $(this).serialize(),
			success: function (resp) {
				if (resp == 1) {
					alert_toast("Career opportunity successfully saved.", 'success');
					setTimeout(() => location.reload(), 1000);
				} else {
					alert_toast("An error occurred. Please try again.", 'danger');
				}
			}
		});
	});
</script>