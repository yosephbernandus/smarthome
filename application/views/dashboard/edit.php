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
					<form method="POST" action="" name="change-password">
						<div class="form-group form-float">
							<div class="form-line">
								<input type="hidden" name="id" value="<?php echo $admin['id_admin'];?>" class="form-control">
								<input type="text" name="username" value="<?php echo $admin['user'];?>" class="form-control" required readonly>
								<label class="form-label">Username</label>
							</div>
						</div>
						<div class="form-group form-float">
							<div class="form-line">
								<input type="password" id="form-password" name="password" class="form-control">
								<label class="form-label">Password</label>
							</div>
						</div>
						<div class="form-group">
							<input type="checkbox" id="checkbox">
							<label for="checkbox">Show Password</label>
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
    	$("form[name='change-password']").submit(function(e){
    		var id = $('input[name="id"]').val();
  			var username = $('input[name="username"]').val();
  			var password = $('input[name="password"]').val();

  			if (password == "") {
  				swal(
  					'Warning',
  					'Password field required',
  					'warning'
  				);
  				e.preventDefault();
  			} else {
  				e.preventDefault();
  				swal({
  					title: 'Are you sure?',
  					text: 'Are you sure to change password?',
  					type: 'warning',
  					showCancelButton : true,
  					confirmButtonColor : "#3085d6",
  					cancelButtonColor : '#d33',
  					confirmButtonText : 'Yes, save it',
  				}). then(function(){
  					$.ajax({
  						url:"<?php echo site_url('dashboard/proses');?>",
  						type:"POST",
  						data:"id="+id+"&username="+username+"&password="+password,
  						cache:false,
  						success:function(html){
  							swal({
  								title: "Success",
  								text: "Your account changed",
  								type:"success"
  							}). then(function(){
  								window.location = "http://yosephbernandus.com/dashboard/";
  							});
  						},
  						error: function(xhr, ajaxOptions, thrownError){
  							swal({
  								title: "Error",
  								text: "Cek Your Connection",
  								type: "error"
  							}).then(function(){
  								window.location = "http://yosephbernandus.com/dashboard/";
  							})
  						}
  					})
  				})
  			}
  		})

        $('#checkbox').click(function(){
        	if ($(this).is(':checked')) {
        		$('#form-password').attr('type','text');
        	} else {
        		$('#form-password').attr('type','password');
        	}
        })
    });
</script>
