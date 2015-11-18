<?php
/**
 * @author tshirtecommerce - www.tshirtecommerce.com
 * @date: 2015-01-10
 * 
 * @copyright  Copyright (C) 2015 tshirtecommerce.com. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 *
 */
?>
<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title"><?php lang('languages_edit'); ?></h4>
		</div>

		<!--add-->
		<form id="fr-language" class="form-horizontal" name="form_edit" id="form-edit" method="POST" action="<?php echo site_url_ci('index.php/settings/editlanguage/'.$id);?>">
		<div class="modal-body">
			<div id="row">
				<div class="form-group">
					<label for="inputlang" class="col-sm-4 control-label"><?php lang('languages_name'); ?> *</label>
					<div class="col-md-5">
						<input type="text" name="data[title]" data-minlength="2" data-maxlength="100" data-msg="<?php lang('languages_validate_length_name'); ?>" class="form-control validate" value="<?php if(!empty($language['title'])) echo $language['title']; ?>" placeholder="<?php lang('languages_name'); ?>">
					</div>
				</div>
				<div class="form-group">
					<label for="inputlang" class="col-sm-4 control-label"><?php lang('languages_code'); ?> *</label>
					<div class="col-md-5">
						<input type="text" name="data[code]" data-minlength="2" data-maxlength="6" data-msg="<?php lang('languages_validate_length_code'); ?>" class="languages_code form-control validate" value="<?php if(!empty($language['code'])) echo $language['code']; ?>" placeholder="<?php lang('languages_code'); ?>">
					</div>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" data-dismiss="modal" class="btn modal-close"><?php lang('close');?></button>
			<button type="button" class="btn btn-primary" onclick="editlanguage('edit', '')"><?php lang('save');?></button>
		</div>
	</div>
</div>
</form>