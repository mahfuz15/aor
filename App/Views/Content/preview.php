<?php
if ($this->request->getUrlData("format") != 'raw') {
    ?>
<section>
	<div class="container">
		<div class="row">
			  <?php } ?>
			<div class="col">
				<div class="preview-email">
					
				</div>
				<div class="test-mail">
					<form action="" class="form" >
						<input type="text" class="form-control" >
						<button class="btn btn-sm btn-warning" >Submit</button>
					</form>
				</div>
			</div>

			<?php
			if ($this->request->getUrlData("format") != 'raw') {
			    ?>
		</div>
	</div>
</section>

<?php } ?>
