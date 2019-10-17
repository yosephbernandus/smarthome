<div class="container-fluid">
	<div class="block-header">
		<h2>Form Username & Password</h2>
	</div>
	<div class="row clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="card">
				<div class="header">
					<h2>Form Add</h2>
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
					<form id="form_validation" method="POST" action="<?php echo site_url('admin/proses');?>">
						<div class="form-group form-float">
							<div class="form-line">
								<input type="text" name="username" class="form-control" required>
								<label class="form-label">Username</label>
							</div>
						</div>
						<div class="form-group form-float">
							<div class="form-line">
								<input type="password" id="form-password" name="password" class="form-control" required>
								<label class="form-label">Password</label>
							</div>
						</div>
						<div class="form-group">
							<input type="checkbox" id="checkbox">
							<label for="checkbox">Show Password</label>
						</div>
						<div class="form-group form-float">
							<div class="form-line">
								<input type="email" name="email" class="form-control" required>
								<label class="form-label">Email</label>
							</div>
						</div>
						<div class="form-group">
							<input type="radio" name="level" id="admin" value="admin" class="with-gap">
							<label for="admin">Admin</label>

							<input type="radio" name="level" id="user" value="user" class="with-gap">
							<label for="user" class="m-l-20">User</label>
						</div>
						<button class="btn btn-primary waves-effect" type="submit">SUBMIT</button>
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="row clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="card">
				<div class="header">
					<h2>List Username</h2>
					<ul class="header-dropdown m-r--5">
						<li class="dropdown">
							<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
								<i class="material-icons">more_vert</i>
							</a>
						</li>
					</ul>
				</div>
				<div class="body">
					<div class="table-responsive">
						<table class="table table-hover">
							<thead>
								<tr>
									<th>No.</th>
									<th>Username</th>
									<th>Password</th>
									<th>Email</th>
									<th>Level</th>
									<th>Edit</th>
									<th>Delete</th>
								</tr>
							</thead>
							<tbody>
								<?php $no=0; foreach($admin as $row): $no++;?>
								<tr>
									<td scope="row"><?php echo $no;?></td>
									<td><?php echo $row->user;?></td>
									<td><?php echo $row->password;?></td>
									<td><?php echo $row->email;?></td>
									<td><?php echo $row->level;?></td>
									<td><a href="<?php echo site_url('admin/edit/'.$row->id_admin);?>"><i style="color: gray;" class="material-icons">edit</i></a></td>
									<td><a href="#" class="hapus" kode="<?php echo $row->id_admin;?>"><i style="color: gray;" class="material-icons">delete</i></a></td>
								</tr>
								<?php endforeach;?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
    $(function(){
        $(".hapus").click(function(e){
        	e.preventDefault();
            var kode=$(this).attr("kode");
            swal({
            	title: 'Are you sure?',
            	text: 'Are you sure to delete this user?',
            	type: 'warning',
            	showCancelButton : true,
            	confirmButtonColor : '#3085d6',
            	cancelButtonColor : '#d33',
            	confirmButtonText : 'Yes, delete it!'
            }). then(function(){
            	$.ajax({
            		url:"<?php echo site_url('admin/delete');?>",
            		type:"POST",
            		data:"kode="+kode,
            		cache: false,
            		success:function(html){
            			swal({
            				title: "Deleted",
            				text: "Username Deleted",
            				type: "success"
            			}). then(function(){
            				location.reload();
            			});
            		},
            		error: function(xhr, ajaxOptions, thrownError){
            			swal({
            				title: "Error",
            				text: "Cek Your Connection",
            				type: "error"
            			}).then(function(){
            				location.reload();
            			})
            		}
            	})
            })
        });

        $('#checkbox').click(function(){
        	if ($(this).is(':checked')) {
        		$('#form-password').attr('type','text');
        	} else {
        		$('#form-password').attr('type','password');
        	}
        })
    });
</script>
