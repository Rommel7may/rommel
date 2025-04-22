<style>
	.collapse a {
		text-indent: 10px;
	}
	nav#sidebar {
		background: url(assets/uploads/<?php echo $_SESSION['system']['cover_img'] ?>) !important;
	}
</style>

<nav id="sidebar" class='mx-lt-5 bg-dark'>
	<div class="sidebar-list">
		<a href="index.php?page=home" class="nav-item nav-home">
			<span class='icon-field'><i class="fas fa-home"></i></span> Home
		</a>
		<a href="index.php?page=courses" class="nav-item nav-courses">
			<span class='icon-field'><i class="fas fa-book-open"></i></span> Course List
		</a>
		<a href="index.php?page=alumni" class="nav-item nav-alumni">
			<span class='icon-field'><i class="fas fa-graduation-cap"></i></span> Alumni List
		</a>
		<a href="index.php?page=jobs" class="nav-item nav-jobs">
			<span class='icon-field'><i class="fas fa-briefcase"></i></span> Jobs
		</a>
		<a href="index.php?page=events" class="nav-item nav-events">
			<span class='icon-field'><i class="fas fa-calendar-alt"></i></span> Events
		</a>

		<?php if ($_SESSION['login_type'] == 1): ?>
			<a href="index.php?page=users" class="nav-item nav-users">
				<span class='icon-field'><i class="fas fa-user-cog"></i></span> Users
			</a>
			<a href="../../../tracking/admin/home_it.php" class="nav-item nav-user">
				<span class='icon-field'><i class="fas fa-map-marked-alt"></i></span> Tracking
			</a>
			<a href="index.php?page=site_settings" class="nav-item nav-site_settings">
				<span class='icon-field'><i class="fas fa-tools"></i></span> System Settings
			</a>
		<?php endif; ?>
	</div>
</nav>

<script>
	$('.nav_collapse').click(function () {
		console.log($(this).attr('href'));
		$($(this).attr('href')).collapse();
	});
	$('.nav-<?php echo isset($_GET['page']) ? $_GET['page'] : '' ?>').addClass('active');
</script>
