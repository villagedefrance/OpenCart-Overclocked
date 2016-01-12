<?php echo $header; ?>
<h1>3<span style="font-size:16px;">/4</span> - <?php echo $heading_step_3; ?></h1>
<div id="column-right">
  <ul>
    <li><?php echo $text_license; ?></li>
    <li><?php echo $text_installation; ?></li>
    <li><b><?php echo $text_configuration; ?></b></li>
    <li><?php echo $text_finished; ?></li>
  </ul>
</div>
<div id="content">
  <?php if ($error_warning) { ?>
     <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
    <p><?php echo $text_db_connection; ?></p>
    <fieldset>
    <table class="form">
      <tr>
        <td><?php echo $entry_db_driver; ?></td>
        <td><select name="db_driver">
        <?php if ($mysqli) { ?>
          <?php if ($db_driver == 'mysqli') { ?>
            <option value="mysqli" selected="selected"><?php echo $text_mysqli; ?></option>
          <?php } else { ?>
            <option value="mysqli"><?php echo $text_mysqli; ?></option>
          <?php } ?>
        <?php } ?>
        <?php if ($mysql) { ?>
          <?php if ($db_driver == 'mysql') { ?>
            <option value="mysql" selected="selected"><?php echo $text_mysql; ?></option>
          <?php } else { ?>
            <option value="mysql"><?php echo $text_mysql; ?></option>
          <?php } ?>
        <?php } ?>
        <?php if ($pdo) { ?>
          <?php if ($db_driver == 'mpdo') { ?>
            <option value="mpdo" selected="selected"><?php echo $text_mpdo; ?></option>
          <?php } else { ?>
            <option value="mpdo"><?php echo $text_mpdo; ?></option>
          <?php } ?>
        <?php } ?>
        <?php if ($pgsql) { ?>
          <?php if ($db_driver == 'pgsql') { ?>
            <option value="pgsql" selected="selected"><?php echo $text_pgsql; ?></option>
          <?php } else { ?>
            <option value="pgsql"><?php echo $text_pgsql; ?></option>
          <?php } ?>
        <?php } ?>
        </select>
        <br />
        <?php if ($error_db_driver) { ?>
          <span class="required"><?php echo $error_db_driver; ?></span>
        <?php } ?></td>
      </tr>
      <tr>
        <td><span class="required">* </span><?php echo $entry_db_hostname; ?></td>
        <td><input type="text" name="db_hostname" value="<?php echo $db_hostname; ?>" size="30" />
        <br />
        <?php if ($error_db_hostname) { ?>
          <span class="required"><?php echo $error_db_hostname; ?></span>
        <?php } ?></td>
      </tr>
      <tr>
        <td><span class="required">* </span><?php echo $entry_db_username; ?></td>
        <td><input type="text" name="db_username" value="<?php echo $db_username; ?>" size="30" />
        <br />
        <?php if ($error_db_username) { ?>
          <span class="required"><?php echo $error_db_username; ?></span>
        <?php } ?></td>
      </tr>
      <tr>
        <td><?php echo $entry_db_password; ?></td>
        <td><input type="text" name="db_password" value="<?php echo $db_password; ?>" size="30" /></td>
      </tr>
      <tr>
        <td><span class="required">* </span><?php echo $entry_db_database; ?></td>
        <td><input type="text" name="db_database" value="<?php echo $db_database; ?>" size="30" />
        <br />
        <?php if ($error_db_database) { ?>
          <span class="required"><?php echo $error_db_database; ?></span>
        <?php } ?></td>
      </tr>
      <tr>
        <td><span class="required">* </span><?php echo $entry_db_port; ?></td>
        <td><input type="text" name="db_port" value="<?php echo $db_port; ?>" size="10" />
        <br />
        <?php if ($error_db_port) { ?>
          <span class="required"><?php echo $error_db_port; ?></span>
        <?php } ?></td>
      </tr>
      <tr>
        <td><?php echo $entry_db_prefix; ?></td>
        <td><input type="text" name="db_prefix" value="<?php echo $db_prefix; ?>" size="10" />
        <br />
        <?php if ($error_db_prefix) { ?>
          <span class="required"><?php echo $error_db_prefix; ?></span>
        <?php } ?></td>
      </tr>
    </table>
    </fieldset>
    <p><?php echo $text_db_administration; ?></p>
    <fieldset>
    <table class="form">
      <tr>
        <td><span class="required">* </span><?php echo $entry_username; ?></td>
        <td><input type="text" name="username" value="<?php echo $username; ?>" size="30" />
        <br />
        <?php if ($error_username) { ?>
          <span class="required"><?php echo $error_username; ?></span>
        <?php } ?></td>
      </tr>
      <tr>
        <td><span class="required">* </span><?php echo $entry_password; ?></td>
        <td><input type="text" name="password" value="<?php echo $password; ?>" size="30" />
        <br />
        <?php if ($error_password) { ?>
          <span class="required"><?php echo $error_password; ?></span>
        <?php } ?></td>
      </tr>
      <tr>
        <td><span class="required">* </span><?php echo $entry_email; ?></td>
        <td><input type="text" name="email" value="<?php echo $email; ?>" size="30" />
        <br />
        <?php if ($error_email) { ?>
          <span class="required"><?php echo $error_email; ?></span>
        <?php } ?></td>
      </tr>
    </table>
    </fieldset>
    <p><?php echo $text_db_option; ?></p>
    <fieldset>
    <table class="form">
    <?php if ($htaccess) { ?>
      <tr>
        <td><?php echo $entry_rewrite; ?></td>
        <td><input type="checkbox" name="rewrite" value="1" /> <?php echo $text_activate; ?></td>
      </tr>
    <?php } ?>
      <tr>
        <td><?php echo $entry_maintenance; ?></td>
        <td><input type="checkbox" name="maintenance" value="1" /> <?php echo $text_activate; ?></td>
      </tr>
      <tr>
        <td><?php echo $entry_demo_data; ?></td>
        <td><input type="checkbox" name="demo_data" value="1" /> <?php echo $text_remove; ?></td>
      </tr>
    </table>
    <br />
    <br />
    <p id="progress" style="display:none;"></p>
    </fieldset>
    <div id="start" class="buttons">
      <div class="left"><a href="<?php echo $back; ?>" class="button"><?php echo $button_back; ?></a></div>
      <div class="right"><input type="submit" value="<?php echo $button_install; ?>" class="button" onclick="return progress()" /></div>
    </div>
  </form>
</div>

<script type="text/javascript"><!--
function progress() {
	document.getElementById('start').style.display='none';
	document.getElementById('progress').style.display='block';
	return true;
}
//--></script>

<?php echo $footer; ?>