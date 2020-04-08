<?php
/**
 * Template for shortcode add-realty
 *
 */
?>
<?php 
$atts = get_query_var('atts');
// fppr($atts, __FILE__.' $atts');
?>

<div class="add-realty-wrapper container mt-3">
	<h2 class="text-center text-uppercase"><?php _e('Add Realty', 'ra-realty'); ?></h2>
	<?php if($atts['errors']) : ?>
		<?php echo implode('<br>', $atts['errors']) ?>
	<?php else: ?>
		<form action="" method="post" class="add-realty-form" id="add-realty-form">
			<?php wp_nonce_field(); ?>
			<?php foreach ($atts['fields'] as $field) :?>
				<?php if($field['name']) : ?>
					<?php switch ($field['type']) {

						case 'relationship': ?>
							<?php if($atts['cities']) : ?>
								<div class="form-group">
									<label for="field-<?php echo $field['ID']; ?>"><?php echo $field['label']; ?><?php echo $field['required'] ? "*" : ""; ?></label>
									<select name="<?php echo $field['name']; ?>" class="form-control" id="field-<?php echo $field['ID']; ?>">
										<option value="" selected><?php _e('Select City', 'add-realty'); ?></option>
										<?php foreach ($atts['cities'] as $city) : ?>
											<option value="<?php echo $city->ID; ?>"><?php echo $city->post_title; ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							<?php endif; ?>
							<?php break;

						case 'textarea': ?>
							<div class="form-group">
								<label for="field-<?php echo $field['ID']; ?>"><?php echo $field['label']; ?><?php echo $field['required'] ? "*" : ""; ?></label>
								<textarea name="<?php echo $field['name']; ?>" class="form-control" id="field-<?php echo $field['ID']; ?>" rows="3"></textarea>
								<small id="help-field-<?php echo $field['ID']; ?>" class="form-text text-muted"></small>
							</div>
							<?php break;

						case 'text':
						case 'number':
						case 'email':
						?>
							<div class="form-group">
								<label for="field-<?php echo $field['ID']; ?>"><?php echo $field['label']; ?><?php echo $field['required'] ? "*" : ""; ?></label>
								<input name="<?php echo $field['name']; ?>" type="<?php echo $field['type']; ?>" class="form-control" id="field-<?php echo $field['ID']; ?>">
								<small id="help-field-<?php echo $field['ID']; ?>" class="form-text text-muted"></small>
							</div>
							<?php break;
						
						default:
						break;
					} ?>
				<?php endif; ?>
			<?php endforeach; ?>
			<div class="form-footer text-center">
				<button type="submit" class="btn btn-primary "><?php _e('Submit', 'default'); ?></button>
			</div>
		</form>
	<?php endif; ?>
</div>
