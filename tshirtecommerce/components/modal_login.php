<div class="modal fade" id="f-login" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div id="f-login-content" class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title" id="myModalLabel"><?php echo lang('designer_user_login_now_or_sign_up'); ?></h4>
		  </div>
		  <div class="modal-body">
			
			<div class="row">
				<!-- login form -->
				<div class="col-md-8">					
					<form id="fr-login" role="form" style="margin-bottom: 5px;">						  						 
					  <div class="form-group">
						<label><?php echo lang('designer_user_your_email'); ?>:</label>
						<input type="text" id="login-email" class="form-control" placeholder="<?php echo lang('designer_user_your_email'); ?>">
					  </div>
					  <div class="form-group">
						<label><?php echo lang('designer_user_your_password'); ?>:</label>
						<input type="text" id="login-password" class="form-control">
					  </div>
					</form>					
				</div>			
			</div>
			
			<div class="row">
				<div class="col-md-12">
					<p class="text-muted"><strong><?php echo lang('designer_note'); ?>: </strong><?php echo lang('designer_user_note'); ?></p>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-8">
					<button type="button" onclick="design.saveInfo(this)" autocomplete="off" class="btn btn-default btn-primary" data-loading-text="Loading"><?php echo lang('designer_user_login_btn'); ?></button>
				</div>
			</div>
		  </div>			 
		</div>
	  </div>	  
	</div>
	<!-- End Login -->