<?php echo $header; ?>
<div id="content">
	<div class="breadcrumb">
	<?php foreach ($breadcrumbs as $breadcrumb) { ?>
		<?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
	<?php } ?>
	</div>
	<?php if ($error_warning) { ?>
		<div class="warning"><?php echo $error_warning; ?></div>
	<?php } ?>
	<div class="box">
	<div class="heading">
		<h1><img src="view/image/product.png" alt="" /> <?php echo $heading_title; ?></h1>
		<div class="buttons">
			<a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a>
			<a onclick="apply();" class="button"><?php echo $button_apply; ?></a>
			<a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a>
		</div>
	</div>
	<div class="content">
	<form id="form" action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
          <table class="form">
			<tr>
				<td><span class="required">*</span> <?php echo $entry_name ?></td>
				<td>
					<?php foreach ($languages as $language) { ?>
					<input name="profile_description[<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($profile_description[$language['language_id']]) ? $profile_description[$language['language_id']]['name'] : ''; ?>" />
					<img src="view/image/flags/<?php echo $language['image']; ?>" alt="" title="<?php echo $language['name']; ?>" /><br />
					<?php if (isset($error_name[$language['language_id']])) { ?>
						<span class="error"><?php echo $error_name[$language['language_id']]; ?></span><br />
					<?php } ?>
                      <?php } ?>
				</td>
			</tr>
			<tr>
				<td><?php echo $entry_sort_order; ?></td>
				<td><input name="sort_order" value="<?php echo $sort_order; ?>" /></td>
			</tr>
			<tr style="background:#FCFCFC;">
				<td colspan="2"><?php echo $text_recurring_help; ?></td>
			</tr>
			<tr>
				<td><?php echo $entry_status; ?></td>
				<td><select name="status">
					<?php if ($status) { ?>
						<option value="0"><?php echo $text_disabled; ?></option>
                              <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
					<?php } else { ?>
                              <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                              <option value="1"><?php echo $text_enabled; ?></option>
                         <?php } ?>
                    </select></td>
			</tr>
			<tr>
				<td><?php echo $entry_price; ?></td>
				<td><input name="price" value="<?php echo $price; ?>" /></td>
			</tr>
			<tr>
				<td><?php echo $entry_duration; ?></td>
				<td><input name="duration" value="<?php echo $duration; ?>" /></td>
			</tr>
			<tr>
				<td><?php echo $entry_cycle; ?></td>
				<td><input name="cycle" value="<?php echo $cycle; ?>" /></td>
			</tr>
			<tr>
				<td><?php echo $entry_frequency; ?></td>
				<td><select name="frequency">
					<?php foreach ($frequencies as $key => $title) { ?>
                              <?php if ($frequency == $key) { ?>    
							<option value="<?php echo $key; ?>" selected="selected"><?php echo $title; ?></option>
                              <?php } else { ?>
							<option value="<?php echo $key; ?>"><?php echo $title; ?></option>
                              <?php } ?>
					<?php } ?>
				</select></td>
			</tr>
			<tr style="background:#FCFCFC;">
				<td><?php echo $entry_trial_status; ?></td>
				<td><select name="trial_status">
					<?php if ($trial_status) { ?>
                              <option value="0"><?php echo $text_disabled; ?></option>
                              <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
					<?php } else { ?>
                              <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                              <option value="1"><?php echo $text_enabled; ?></option>
					<?php } ?>
                    </select></td>
			</tr>
			<tr style="background:#FCFCFC;">
				<td><?php echo $entry_trial_price; ?></td>
				<td><input name="trial_price" value="<?php echo $trial_price; ?>" /></td>
			</tr>
			<tr style="background:#FCFCFC;">
				<td><?php echo $entry_trial_duration; ?></td>
				<td><input name="trial_duration" value="<?php echo $trial_duration; ?>" /></td>
			</tr>
			<tr style="background:#FCFCFC;">
				<td><?php echo $entry_trial_cycle; ?></td>
				<td><input name="trial_cycle" value="<?php echo $trial_cycle; ?>" /></td>
			</tr>
			<tr style="background:#FCFCFC;">
				<td><?php echo $entry_trial_frequency; ?></td>
				<td><select name="trial_frequency">
					<?php foreach ($frequencies as $key => $title) { ?>
                              <?php if ($trial_frequency == $key) { ?>    
                                  <option value="<?php echo $key; ?>" selected="selected"><?php echo $title; ?></option>
                              <?php } else { ?>
                                  <option value="<?php echo $key; ?>"><?php echo $title; ?></option>
                              <?php } ?>
					<?php } ?>
				</select></td>
			</tr>
		</table>
	</form>
	</div>
	</div>
</div>
<?php echo $footer; ?>