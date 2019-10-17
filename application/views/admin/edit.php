<div class="container-fluid">
	<div class="block-header">
		<h2>Form Username & Password</h2>
	</div>
	<div class="row clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="card">
				<div class="header">
					<h2>Edit Form</h2>
					<ul class="header-dropdown m-r--5">
						<li class="dropdown">
							<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
								<i class="material-icons">more_vert</i>
							</a>
						</li>
					</ul>
				</div>
				<div class="body">
				<?php echo $message;?>
					<form id="form_validation" method="POST" action="<?php echo site_url('admin/e_proses');?>">
						<div class="form-group form-float">
							<div class="form-line">
								<input type="hidden" name="id" value="<?php echo $admin['id_admin'];?>" class="form-control">
								<input type="text" name="username" value="<?php echo $admin['user'];?>" class="form-control" required>
								<label class="form-label">Username</label>
							</div>
						</div>
						<div class="form-group form-float">
							<div class="form-line">
								<input type="password" value="" id="form-password" name="password" class="form-control" required>
								<label class="form-label">Password</label>
							</div>
						</div>
						<div class="form-group">
							<input type="checkbox" id="checkbox">
							<label for="checkbox">Show Password</label>
						</div>
						<div class="form-group form-float">
							<div class="form-line">
								<input type="email" name="email" value="<?php echo $admin['email'];?>" class="form-control" required>
								<label class="form-label">Email</label>
							</div>
						</div>
						<div class="form-group">
							<input type="radio" name="level" id="admin" value="admin" <?php echo($admin['level']=='admin')?'checked':'' ?>class="with-gap">
							<label for="admin">Admin</label>

							<input type="radio" name="level" id="user" value="user" <?php echo($admin['level']=='user')?'checked':'' ?> class="with-gap">
							<label for="user" class="m-l-20">User</label>
						</div>
						<button class="btn btn-primary waves-effect" type="submit">SUBMIT</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
    $(function(){
        $('#checkbox').click(function(){
        	if ($(this).is(':checked')) {
        		$('#form-password').attr('type','text');
        	} else {
        		$('#form-password').attr('type','password');
        	}
        })
    });
</script>
