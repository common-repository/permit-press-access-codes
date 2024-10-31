<div class="wrap">
	
	<div id="icon-options-general" class="icon32"></div>
	<h2>Press Permit: Group Access Codes</h2>
	
	<div id="poststuff">
	
		<div id="post-body" class="metabox-holder columns-2">
		
			<!-- main content -->
			<div id="post-body-content">
				
				<div class="meta-box-sortables ui-sortable">
					
					<div class="postbox">
					
						<h3><span>Add new access code</span></h3>
						<div class="inside">
							
							
							<form name="pp_access_codes_form" method="post" action="">
								<input type="hidden" name="pp_access_codes_form_submitted" value="Y"/>
								<table class="form-table">
									<tr>
										<td><label for="pp_access_codes_group"> Permissions Group</label></td>
										<td><?php echo pp_access_codes_groups_drop_down();?></td>
										
									</tr>
									<tr>
										<td><label for="pp_access_code">Access Code </label></td>
										<td><input type="text" name="pp_access_code" value="" class="regular-text"></td>
									</tr>
								</table>
								<input class="button-primary" type="submit" name="pp_access_codes_combinination_submit" value="Add/Update Combination" /> 
							</form>

						</div> <!-- .inside -->
					
					</div> <!-- .postbox -->
					
				</div> <!-- .meta-box-sortables .ui-sortable -->
				
			</div> <!-- post-body-content -->
			
			<!-- sidebar -->
			<div id="postbox-container-1" class="postbox-container">
				
				<div class="meta-box-sortables">
					
					<div class="postbox">
					
						<h3><span>Groups with Access Codes</span></h3>
						<div class="inside">
							<?php echo pp_access_codes_list_active_combinations(); ?>
						</div> <!-- .inside -->
						
					</div> <!-- .postbox -->
					
				</div> <!-- .meta-box-sortables -->
				
			</div> <!-- #postbox-container-1 .postbox-container -->
			
		</div> <!-- #post-body .metabox-holder .columns-2 -->
		
		<br class="clear">
	</div> <!-- #poststuff -->
	
</div> <!-- .wrap -->
