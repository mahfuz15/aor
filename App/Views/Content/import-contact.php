<?php

if (empty($_GET['format'])) {

?>
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

				<?php include  'content-topbar.php'; 
						}
                ?>

				<div class="create-maillist px-5">
					
					<form action="" class="needs-validation" novalidate >
					
						<div class="form-group">
							<label for="conname">List Name</label>
							<input type="text" name="conname" id="conname" value="" placeholder="" class="form-control" >
						</div>

						<div class="form-group">
							<label for="conemail">Contact Email</label>
							<textarea name="conemail" id="conemail" class="form-control"></textarea>
						</div>

						<div class="form-groups">
							<button class="btn btn-compose-outline" type="submit">Save</button>
						</div>

					</form>

				</div>
				<?php
                if (empty($_GET['format'])) {
                    ?>
			</div>


		</div>
	</div>
</section>

<?php } ?>