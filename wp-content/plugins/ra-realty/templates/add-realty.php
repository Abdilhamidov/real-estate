<?php
/**
 * Template for shortcode add-realty
 *
 */
?>
<?php 
$atts = get_query_var('atts');
fppr($atts, __FILE__.' $atts');
?>

<div class="add-realty-wrapper container mt-3">
	<h2 class="text-center text-uppercase"><?php _e('Add Realty', 'ra-realty'); ?></h2>
	<?php if($atts['errors']) : ?>
		<?php echo implode('<br>', $atts['errors']) ?>
	<?php else: ?>
		<form method="post" action="<?php echo RARLT_PLUGIN_URL; ?>/ajax/" class="add-realty-form needs-validation" id="add-realty-form" novalidate>
			<?php wp_nonce_field('addpost', 'addpost_wpnonce'); ?>

			<div class="form-group">
				<label for="field-post_title"><?php _e('Title', 'ra-realty'); ?>*</label>
				<input name="post_title" type="text" class="form-control" id="field-post_title" required>
				<div class="invalid-feedback"><?php _e('Fill the field', 'ra-realty'); ?></div>
			</div>

			<div class="form-group">
				<label for="field-post_content"><?php _e('Description', 'ra-realty'); ?></label>
				<textarea name="post_content" class="form-control" id="field-post_content" rows="3"></textarea>
			</div>

			<?php if($atts['terms']) : ?>
				<div class="form-group">
					<label for="field-post_category"><?php _e('Realty Type', 'ra-realty'); ?>*</label>
					<select name="post_category" class="form-control" id="field-post_category" required>
						<option value="" selected><?php _e('Select Realty Type', 'add-realty'); ?></option>
						<?php foreach ($atts['terms'] as $term) : ?>
							<option value="<?php echo $term->term_id; ?>"><?php echo $term->name; ?></option>
						<?php endforeach; ?>
					</select>
					<div class="invalid-feedback"><?php _e('Select the item', 'ra-realty'); ?></div>
				</div>
			<?php endif; ?>

			<?php foreach ($atts['fields'] as $field) :?>
				<?php if($field['name']) : ?>
					<?php switch ($field['type']) {

						case 'relationship': ?>
							<?php if($atts['cities']) : ?>
								<div class="form-group">
									<label for="field-<?php echo $field['ID']; ?>"><?php echo $field['label']; ?><?php echo $field['required'] ? "*" : ""; ?></label>
									<select name="fields[<?php echo $field['name']; ?>]" class="form-control" id="field-<?php echo $field['ID']; ?>"<?php echo $field['required'] ? " required" : ""; ?>>
										<option value="" selected><?php _e('Select City', 'add-realty'); ?></option>
										<?php foreach ($atts['cities'] as $city) : ?>
											<option value="<?php echo $city->ID; ?>"><?php echo $city->post_title; ?></option>
										<?php endforeach; ?>
									</select>
									<div class="invalid-feedback"><?php _e('Select the item', 'ra-realty'); ?></div>
								</div>
							<?php endif; ?>
							<?php break;

						case 'textarea': ?>
							<div class="form-group">
								<label for="field-<?php echo $field['ID']; ?>"><?php echo $field['label']; ?><?php echo $field['required'] ? "*" : ""; ?></label>
								<textarea name="fields[<?php echo $field['name']; ?>]" class="form-control" id="field-<?php echo $field['ID']; ?>" rows="3"<?php echo $field['required'] ? " required" : ""; ?>></textarea>
							</div>
							<?php break;

						case 'text':
						case 'number':
						case 'email':
						?>
							<div class="form-group">
								<label for="field-<?php echo $field['ID']; ?>"><?php echo $field['label']; ?><?php echo $field['required'] ? "*" : ""; ?></label>
								<input name="fields[<?php echo $field['name']; ?>]" type="<?php echo $field['type']; ?>" class="form-control" id="field-<?php echo $field['ID']; ?>"<?php echo $field['required'] ? " required" : ""; ?>>
								<!-- <div class="valid-feedback">Looks good!</div> -->
								<div class="invalid-feedback"><?php _e('Fill the field', 'ra-realty'); ?></div>
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
