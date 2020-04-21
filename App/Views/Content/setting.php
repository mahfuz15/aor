<section class="hotemailer setting">
	<div class="container-fluid">
		<div class="row">
			<?php include 'sidebar.php'; ?>
			
			<div class="setting col p-0">
				<?php include 'content-topbar.php' ?>
				<div class="setting-content">

					<ul class="nav nav-tabs mySettingTab" id="mySettingTab" role="tablist">
						<li class="nav-item">
							<a class="nav-link " id="general-tab" data-toggle="tab" href="#general" role="tab" aria-controls="general" aria-selected="true">General</a>
						</li>
						<li class="nav-item">
							<a class="nav-link active" id="template-tab" data-toggle="tab" href="#template" role="tab" aria-controls="template" aria-selected="false">Template</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="bounce-tab" data-toggle="tab" href="#bounce" role="tab" aria-controls="bounce" aria-selected="false">Bounce</a>
						</li>
						
					</ul>

					<div class="tab-content">

						<div class="tab-pane " id="general" role="tabpanel" aria-labelledby="home-tab">
							<form action="" class="form-modern" >

								<div class="form-group d-flex">
									<label for="userapi" class="col-sm-2 col-form-label">Api Code</label>
									<div class="col-sm-2">
										<input type="text" name="userapi"  id="userapi" placeholder="userapi" class="form-control pl-1">
									</div>
								</div>

								<div class="form-group d-flex">
									<label for="sendername" class="col-sm-2 col-form-label">Sender name</label>
									<div class="col-sm-2">
										<input type="text" name="sendername"  id="sendername" placeholder="name" class="form-control pl-1">
									</div>
								</div>

								<div class="form-group d-flex">
									<label for="sendermail" class="col-sm-2 col-form-label">Sender Email</label>
									<div class="col-sm-2">
										<input type="email" name="sendermail" id="sendermail" placeholder="Email" class="form-control pl-1">
									</div>
								</div>

								<div class="form-group d-flex">
									<label for="mailsignature" class="col-sm-2 col-form-label" >Email Signature</label>
									<div class="col-sm-8">
										<textarea name="mailsignature" id="mailsignature" placeholder="make/edit mail signature" class="form-control pl-1" ></textarea>
									</div>
								</div>

								<div class="form-group d-flex">
									<label for="campaignheader" class="col-sm-2 col-form-label" >Campaigns Header</label>
									<div class="col-sm-8">
										<textarea name="campaignheader" id="campaignheader" placeholder="Set campaign header" class="form-control pl-1" ></textarea>
									</div>
								</div>

								<div class="form-group d-flex">
									<label for="campaignfooter" class="col-sm-2 col-form-label" >Campaigns Header</label>
									<div class="col-sm-8">
										<textarea name="campaignfooter" id="campaignfooter" placeholder="Set campaign footer" class="form-control pl-1" ></textarea>
									</div>
								</div>

							</form>
						</div>

						<div class="tab-pane active" id="template" role="tabpanel" aria-labelledby="template-tab">
							
							<div class="pb-3">
								<a class="d-inline-block mb-2" href="#"><i class="fas fa-plus"></i> Add new Template</a>

								<div class="tamplate-builder">
									<form action="">
										<div class="form-group ">
											<textarea name="" id="" cols="30" rows="10" class="form-control" ></textarea>
										</div>

										<div class="">
											<button class="btn btn-md btn-outline-dark " >Save</button>
										</div>
									</form>
								</div>	
							</div>

							<div class="template-handaller" id="template-handaller">
								<div class="row">
									<div class="col-6 col-sm-4 col-md-3 col-xl-2">
										<div class="single-templ">
								        	<img class="img-fluid" src="<?php echo BASE_URL;?>images/template/offer.jpg" alt="">
								        </div>
									</div>

									<div class="col-6 col-sm-4 col-md-3 col-xl-2">
										<div class="single-templ">
											<img class="img-fluid" src="<?php echo BASE_URL;?>images/template/see-geek.jpg" alt="">
										</div>
									</div>

									<div class="col-6 col-sm-4 col-md-3 col-xl-2">
								        <div class="single-templ">
								        	<img class="img-fluid" src="<?php echo BASE_URL;?>images/template/spark.jpg" alt="">
										</div>
									</div>

									<div class="col-6 col-sm-4 col-md-3 col-xl-2">
								        <div class="single-templ">
								        	<img class="img-fluid" src="<?php echo BASE_URL;?>images/template/spark.jpg" alt="">
										</div>
									</div>

								</div>
							</div>
						</div>

						<div class="tab-pane" id="bounce" role="tabpanel" aria-labelledby="bounce-tab">
							<table class="table">
							  <thead>
							    <tr>
							      <th scope="col">#</th>
							      <th scope="col">First</th>
							      <th scope="col">Last</th>
							      <th scope="col">Handle</th>
							    </tr>
							  </thead>
							  <tbody>
							    <tr>
							      <th scope="row">1</th>
							      <td>Mark</td>
							      <td>Otto</td>
							      <td>@mdo</td>
							    </tr>
							    <tr>
							      <th scope="row">2</th>
							      <td>Jacob</td>
							      <td>Thornton</td>
							      <td>@fat</td>
							    </tr>
							    <tr>
							      <th scope="row">3</th>
							      <td>Larry</td>
							      <td>the Bird</td>
							      <td>@twitter</td>
							    </tr>
							  </tbody>
							</table>
						</div>
						
					</div>

				</div>
			</div>
			
		</div>
		<!--  end-row -->
	</div>
</section>

<script src="<?php echo ASSETS; ?>vendor/ckeditor/ckeditor.js<?=VERSION?>"></script>


<script>
	// ckeditor
	    window.onload = function () {
	        CKEDITOR.replace('mailsignature',{
	            toolbarGroups: [
	                { name: 'basicstyles', groups: [ 'basicstyles' ] },
            		{ name: 'editing', groups: ['selection', 'spellchecker', 'editing' ] },
            		{ name: 'colors', groups: [ 'colors' ] },
            		{ name: 'styles', groups: [ 'styles', 'undo' ] },
            		{ name: 'paragraph', groups: [ 'indent', 'blocks', 'align' ] },
            		{ name: 'insert', groups: [ 'insert' ] },
            		{ name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
	            ],
	            height: 100,

	        });

	        CKEDITOR.replace('campaignheader',{
	            toolbarGroups: [
	                { name: 'basicstyles', groups: [ 'basicstyles' ] },
            		{ name: 'editing', groups: ['selection', 'spellchecker', 'editing' ] },
            		{ name: 'colors', groups: [ 'colors' ] },
            		{ name: 'styles', groups: [ 'styles', 'undo' ] },
            		{ name: 'paragraph', groups: [ 'indent', 'blocks', 'align' ] },
            		{ name: 'insert', groups: [ 'insert' ] },
            		{ name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
	            ],
	            height: 100,
	        });
	        CKEDITOR.replace('campaignfooter',{
	            toolbarGroups: [
	                { name: 'basicstyles', groups: [ 'basicstyles' ] },
            		{ name: 'editing', groups: ['selection', 'spellchecker', 'editing' ] },
            		{ name: 'colors', groups: [ 'colors' ] },
            		{ name: 'styles', groups: [ 'styles', 'undo' ] },
            		{ name: 'paragraph', groups: [ 'indent', 'blocks', 'align' ] },
            		{ name: 'insert', groups: [ 'insert' ] },
            		{ name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
	            ],
	            height: 100,
	        });
	    };


</script>
