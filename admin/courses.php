<?php include('db_connect.php');?>

<div class="container-fluid">
	<div class="col-lg-12">
		<div class="row">
			<!-- FORM Panel -->
			<div class="col-md-4">
				<form action="" id="manage-course">
					<div class="card shadow-sm">
						<div class="card-header bg-primary text-white">
							<h5 class="mb-0">Course Form</h5>
						</div>
						<div class="card-body">
							<input type="hidden" name="id">
							<div class="form-group">
								<label class="control-label">Course</label>
								<input type="text" class="form-control" name="course" required>
							</div>
						</div>
						<div class="card-footer text-end">
							<button class="btn btn-success btn-sm me-2">Save</button>
							<button class="btn btn-secondary btn-sm" type="button" onclick="$('#manage-course').get(0).reset()">Cancel</button>
						</div>
					</div>
				</form>
			</div>
			<!-- FORM Panel -->

			<!-- Table Panel -->
			<div class="col-md-8">
				<div class="card shadow-sm">
					<div class="card-header bg-dark text-white">
						<h5 class="mb-0">Course List</h5>
					</div>
					<div class="card-body">
						<table class="table table-bordered table-hover table-striped" id="course-table">
							<thead class="table-dark">
								<tr>
									<th class="text-center">#</th>
									<th class="text-center">Course</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$i = 1;
								$course = $conn->query("SELECT * FROM courses order by id asc");
								while($row=$course->fetch_assoc()):
								?>
								<tr>
									<td class="text-center align-middle"><?php echo $i++ ?></td>
									<td class="align-middle"><?php echo $row['course'] ?></td>
									<td class="text-center align-middle">
										<button class="btn btn-sm btn-outline-primary edit_course me-1" type="button" data-id="<?php echo $row['id'] ?>" data-course="<?php echo $row['course'] ?>">Edit</button>
										<button class="btn btn-sm btn-outline-danger delete_course" type="button" data-id="<?php echo $row['id'] ?>">Delete</button>
									</td>
								</tr>
								<?php endwhile; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<!-- Table Panel -->
		</div>
	</div>
</div>

<style>
	td {
		vertical-align: middle !important;
	}
</style>

<script>
	$('#manage-course').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'ajax.php?action=save_course',
			data: new FormData($(this)[0]),
			cache: false,
			contentType: false,
			processData: false,
			method: 'POST',
			success:function(resp){
				if(resp==1){
					alert_toast("Course successfully added",'success')
				}else if(resp==2){
					alert_toast("Course successfully updated",'success')
				}
				setTimeout(function(){
					location.reload()
				},1500)
			}
		})
	})

	$('.edit_course').click(function(){
		start_load()
		var form = $('#manage-course')
		form.get(0).reset()
		form.find("[name='id']").val($(this).attr('data-id'))
		form.find("[name='course']").val($(this).attr('data-course'))
		end_load()
	})

	$('.delete_course').click(function(){
		_conf("Are you sure to delete this course?","delete_course",[$(this).attr('data-id')])
	})

	function delete_course(id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_course',
			method:'POST',
			data:{id:id},
			success:function(resp){
				if(resp==1){
					alert_toast("Course successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)
				}
			}
		})
	}

	$('#course-table').DataTable();
</script>