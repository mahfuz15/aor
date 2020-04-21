<section class="hotemailer mailist">
	<div class="container-fluid">
		<div class="row">
			<div class="menu-panel col-md-4 col-lg-3 col-xl-2 p-0 border-right ">
				<div class="top-bar logo icon-lg align-self-center">
					<div class="float-left icon-lg">
						<i class="fas fa-envelope"></i>
					</div>
					<span><b>mail</b>box</span>
				</div>
				
				<div class="left-panel p-20">
					<a  href="<?php echo BASE_URL;?>compose" class="btn btn-lg btn-compose"> <i class="far fa-edit"></i> compose </a>

					<div class="widget menu">
						<ul class="list-unstyled" >
							<li><a href="#"><div> <i class="fas fa-inbox"></i> Inbox <span class="count">10</span> </div></a></li>
							<li><a href="#"><div> <i class="fas fa-folder"></i> Draft <span class="count">30</span></div></a></li>
							<li><a href="#"><div> <i class="glyphicon glyphicon-send"></i> Sent <span class="count">0</span></div></a></li>
							<li><a href="#"><div> <i class="fas fa-trash"></i> Trash </div></a></li>
						</ul>
					</div>

					<div class="widget folder">
						<a href="#" class="add">+ New Folder</a>
						<h6><b>My Folder</b></h6>

						<ul class="list-unstyled">
							<li><a href="#"> <i class="fas fa-inbox"></i> Social <span class="count">0</span></a></li>
							<li><a href="#"> <i class="fas fa-folder"></i> Coding <span class="count">0</span></a></li>
						</ul>
					</div>

					<div class="widget folder">
						<a href="#" class="add">+ New Folder</a>
						<h6><b>Contacts</b></h6>

						<ul class="list-unstyled user">
							<li><a href="#"><i class="fas fa-circle active"></i> Louise Kate Lumaad</a></li>
							<li><a href="#"><i class="fas fa-circle busy"></i> Socrates Itumay</a></li>
							<li><a href="#"><i class="fas fa-circle offline"></i> Isidore Dilao</a></li>
						</ul>
					</div>


				</div>

			</div>


			<div class="maillist-panel  col p-0">

				<?php include  VIEWS.DS.'MailBox'.DS.'content-topbar.php'; ?>
				
				<div class="mail-list-table px-5">

					<div class="d-flex justify-content-between align-items-center py-3">
						<h2>Email List</h2>

						<ul class="list-inline m-0">
							<li class="list-inline-item" ><a class="btn btn-secondary btn-sm text-white popup" href="create-list">Create List <i class="fas fa-angle-double-right"></i></a></li>
						</ul>
					</div>
					
					<div class="sorting pb-4">

						<form action="" class="form-inline">

							<div class="form-group">
								<label >Sort By</label>
								<select name="" id="" class="form-control mx-sm-3" >
									<option value="custom">Custom Order</option>
									<option value="name">Name</option>
									<option value="date">Date Created</option>
								</select>
							</div>
							
								

						</form>

					</div>
					<table class="table mailer-table">
					 
					    <tr>
					      <td>
					      	<h4>Sceience , arts and comerce</h4>
					      	<p>Created <span class="time">Mar 19,2018 2:17 am</span></p>
					      </td>
					      <td class="text-center" >
					      	<h4 class="subs-count">2</h4>
					      	<span>subscriber</span>
					      </td>
					      <td class="text-center" >
					      	<h4>0.00%</h4>
					      	<span class="">Opens</span>
					      </td>
					      <td class="text-center" >
					      	<h4>0.00%</h4>
					      	<span>Clicks</span>
					      </td>
					      <td>
					      	<a class="btn btn-outline-secondary btn-sm popup" href="import-contact">
					      		<i class="fas fa-user-plus"></i>
					      	</a>
					      </td>

					      <td>
					      		
					      </td>

					    </tr>
					   
					  

					</table>
				</div>



			</div>

		</div>
	</div>
</section>
