<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>

  <div class="box mBottom130">
    <div class="left"></div>
    <div class="right"></div>
    <div class="heading">
      <h1><?php echo $lang_text_manager; ?></h1>
      <div class="buttons"><a onclick="validateForm(); return false;" class="button"><span><?php echo $lang_btn_save; ?></span></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $lang_btn_cancel; ?></span></a></div>
    </div>
    <div class="content">
      <div id="tabs" class="htabs">
        <a href="#tab-updates"><?php echo $tab_update; ?></a>
        <a href="#tab-settings"><?php echo $lang_btn_settings; ?></a>
        <a href="#tab-patch"><?php echo $lang_btn_patch; ?></a>
        <a href="#tab-help"><?php echo $lang_tab_help; ?></a>
      </div>

      <div id="tab-updates">
        <p><?php echo $lang_patch_notes1; ?> <a href="http://shop.openbaypro.com/index.php?route=information/information/changelog" title="OpenBay Pro change log" target="_BLANK"><?php echo $lang_patch_notes2; ?></a></p>
        <div id="update-types" class="htabs">
          <a href="#v2-update-tab"><?php echo $tab_update_v2; ?></a>
          <a href="#v1-update-tab"><?php echo $tab_update_v1; ?></a>
        </div>
        <div id="v2-update-tab">
          <div class="warning" id="update-error" style="display:none;"></div>
          <table class="form">
            <tr class="update-v2-box">
              <td valign="middle"><label for="update-v2-beta"><?php echo $lang_use_beta; ?><span class="help"><?php echo $lang_use_beta_2; ?></span></label></td>
              <td>
                <select id="update-v2-beta" class="form-control">
                  <option value="1"><?php echo $text_yes; ?></option>
                  <option value="0" selected="selected"><?php echo $text_no; ?></option>
                </select>
              </td>
            </tr>
            <tr class="update-v2-box">
              <td valign="middle"><label for="openbay_ftp_beta"><?php echo $lang_btn_update; ?><span class="help"><?php echo $help_easy_update; ?></span></label></td>
              <td>
                <a class="button" id="update-v2"><?php echo $lang_btn_update; ?></a>
              </td>
            </tr>
            <tr id="update-v2-progress" style="display:none;">
              <td valign="middle"><?php echo $text_progress; ?></td>
              <td>
                <span id="v2-update-percent"></span> / <span id="v2-update-text"></span>
              </td>
            </tr>
          </table>
        </div>

        <div id="v1-update-tab">
          <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
            <p><?php echo $lang_patch_notes3; ?></p>
            <table class="form">
              <tr>
                <td><?php echo $lang_installed_version; ?>:</td>
                <td id="openBayVersionText">
                  <?php echo $txt_obp_version; ?>
                </td>
                <input type="hidden" name="openbay_version" value="<?php echo $openbay_version;?>" id="openbay_version" />
                <input type="hidden" name="openbaymanager_show_menu" value="<?php echo $openbaymanager_show_menu;?>" />
              </tr>
              <tr>
                <td><label for="openbay_ftp_username"><?php echo $field_ftp_user; ?></label></td>
                <td><input class="ftpsetting width250" type="text" name="openbay_ftp_username" id="openbay_ftp_username" maxlength="" value="<?php echo $openbay_ftp_username;?>" /></td>
              </tr>
              <tr>
                <td><label for="openbay_ftp_pw"><?php echo $field_ftp_pw; ?></label></td>
                <td><input class="ftpsetting width250" type="text" name="openbay_ftp_pw" id="openbay_ftp_pw" maxlength="" value="<?php echo $openbay_ftp_pw;?>" /></td>
              </tr>
              <tr>
                <td><label for="openbay_ftp_server"><?php echo $field_ftp_server_address; ?></label></td>
                <td><input class="ftpsetting width250" type="text" name="openbay_ftp_server" id="openbay_ftp_server" maxlength="" value="<?php echo $openbay_ftp_server;?>" /></td>
              </tr>
              <tr>
                <td><label for="openbay_ftp_rootpath"><?php echo $field_ftp_root_path; ?><span class="help"><?php echo $field_ftp_root_path_info; ?></span></label></td>
                <td><input class="ftpsetting width250" type="text" name="openbay_ftp_rootpath" id="openbay_ftp_rootpath" maxlength="" value="<?php echo $openbay_ftp_rootpath;?>" /></td>
              </tr>
              </tr>
              <tr>
                <td><label for="openbay_admin_directory"><?php echo $lang_admin_dir; ?><span class="help"><?php echo $lang_admin_dir_desc; ?></span></label></td>
                <td><input class="ftpsetting width250" type="text" name="openbay_admin_directory" id="openbay_admin_directory" maxlength="" value="<?php echo $openbay_admin_directory;?>" /></td>
              </tr>
              <tr>
                <td><label for="openbay_ftp_pasv"><?php echo $lang_use_pasv; ?></label></td>
                <td>
                  <input class="ftpsetting" type="hidden" name="openbay_ftp_pasv" value="0" />
                  <input class="ftpsetting" type="checkbox" name="openbay_ftp_pasv" id="openbay_ftp_pasv" value="1" <?php if(isset($openbay_ftp_pasv) && $openbay_ftp_pasv == 1){ echo 'checked="checked"'; } ?> />
                </td>
              </tr>
              <tr>
                <td><label for="openbay_ftp_beta"><?php echo $lang_use_beta; ?><span class="help"><?php echo $lang_use_beta_2; ?></span></label></td>
                <td>
                  <input class="ftpsetting" type="hidden" name="openbay_ftp_beta" value="0" />
                  <input class="ftpsetting" type="checkbox" name="openbay_ftp_beta" id="openbay_ftp_beta" value="1" <?php if(isset($openbay_ftp_beta) && $openbay_ftp_beta == 1){ echo 'checked="checked"'; } ?> />
                </td>
              </tr>
              <tr id="ftpTestRow">
                <td height="50" valign="middle"><?php echo $lang_test_conn; ?></td>
                <td>
                  <a onclick="ftpTest();" class="button" id="ftpTest"><span><?php echo $lang_btn_test; ?></span></a>
                  <img src="view/image/loading.gif" id="imageFtpTest" class="displayNone" alt="Loading" />
                </td>
              </tr>
              <tr id="ftpUpdateRow" class="displayNone">
                <td height="50" valign="middle"><?php echo $lang_text_run_1; ?></td>
                <td><span id="preFtpTestText"><?php echo $lang_text_run_2; ?></span>
                  <a onclick="updateModule();" class="button displayNone" id="moduleUpdate"><span><?php echo $lang_btn_update; ?></span></a>
                  <img src="view/image/loading.gif" id="imageModuleUpdate" class="displayNone" alt="Loading" />
                </td>
              </tr>
              <tr>
                <td colspan="2" id="updateBox"></td>
              </tr>
            </table>
          </form>
        </div>
      </div>

      <div id="tab-settings">
          <table class="form">
              <tr>
                  <td ><?php echo $lang_language; ?></td>
                  <td>
                      <select name="openbay_language">
                          <?php foreach($languages as $key => $language){ ?>
                              <option value="<?php echo $key; ?>" <?php if($key == $openbay_language){ echo'selected="selected"'; } ?>><?php echo $language; ?></option>
                          <?php } ?>
                      </select>
                  </td>
              </tr>
              <tr>
                  <td valign="middle"><label for=""><?php echo $lang_clearfaq; ?></td>
                  <td><a onclick="clearFaq();" class="button" id="clearFaq"><span><?php echo $lang_clearfaqbtn; ?></span></a><img src="view/image/loading.gif" id="imageClearFaq" class="displayNone" alt="Loading" /></td>
              </tr>
          </table>
      </div>

      <div id="tab-patch">
          <table class="form">
              <tr>
                  <td ><?php echo $lang_run_patch_desc; ?></td>
                  <td><a onclick="runPatch();" class="button" id="runPatch"><span><?php echo $lang_run_patch; ?></span></a><img src="view/image/loading.gif" id="imageRunPatch" class="displayNone" alt="Loading" /></td>
              </tr>
          </table>
      </div>

      <div id="tab-help">
          <h2><?php echo $lang_help_title; ?></h2>
          <table class="form">
              <tr>
                  <td class="p10"><?php echo $lang_help_support_title; ?></td>
                  <td class="p10"><?php echo $lang_help_support_description; ?></td>
              </tr>
              <tr>
                  <td class="p10"><?php echo $lang_help_template_title; ?></td>
                  <td class="p10"><?php echo $lang_help_template_description; ?></td>
              </tr>
              <tr>
                  <td class="p10"><?php echo $lang_help_guide; ?></td>
                  <td class="p10"><?php echo $lang_help_guide_description; ?></td>
              </tr>
          </table>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript"><!--
  $('.ftpsetting').keypress(function(){
      $('#preFtpTestText').show();
      $('#moduleUpdate').hide();
      $('#ftpTestRow').show();
      $('#ftpUpdateRow').hide();
  });

  function ftpTest(){
      $.ajax({
          url: 'index.php?route=extension/openbay/ftpTestConnection&token=<?php echo $token; ?>',
          type: 'post',
          data: $('.ftpsetting').serialize(),
          dataType: 'json',
          beforeSend: function(){
              $('#ftpTest').hide();
              $('#imageFtpTest').show();
          },
          success: function(json) {
              alert(json.msg);

              if(json.connection == true){
                  $('#preFtpTestText').hide();
                  $('#moduleUpdate').show();
                  $('#ftpTestRow').hide();
                  $('#ftpUpdateRow').show();
              }

              $('#ftpTest').show();
              $('#imageFtpTest').hide();
          },
          error: function (xhr, ajaxOptions, thrownError) {
            if (xhr.status != 0) {
              alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
          }
      });
  }

  function runPatch(){
      $.ajax({
          url: 'index.php?route=extension/openbay/runPatch&token=<?php echo $token; ?>',
          type: 'post',
          dataType: 'json',
          beforeSend: function(){
              $('#runPatch').hide();
              $('#imageRunPatch').show();
          },
          success: function() {
              alert('<?php echo $lang_patch_applied; ?>');
              $('#runPatch').show();
              $('#imageRunPatch').hide();
          },
          error: function (xhr, ajaxOptions, thrownError) {
            if (xhr.status != 0) {
              alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
          }
      });
  }

  function updateModule(){
      $.ajax({
          url: 'index.php?route=extension/openbay/ftpUpdateModule&token=<?php echo $token; ?>',
          type: 'post',
          data: $('.ftpsetting').serialize(),
          dataType: 'json',
          beforeSend: function(){
              $('#moduleUpdate').hide();
              $('#imageModuleUpdate').show();
          },
          success: function(json) {
              alert(json.msg);
              $('#openBayVersionText').text(json.version);
              $('#openbay_version').val(json.version);
              $('#moduleUpdate').show();
              $('#imageModuleUpdate').hide();
          },
          error: function (xhr, ajaxOptions, thrownError) {
            if (xhr.status != 0) {
              alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
          }
      });
  }

  function validateForm(){
      $('#form').submit();
  }

  function clearFaq(){
      $.ajax({
          url: 'index.php?route=extension/openbay/faqClear&token=<?php echo $token; ?>',
          beforeSend: function(){
              $('#clearFaq').hide();
              $('#imageClearFaq').show();
          },
          type: 'post',
          dataType: 'json',
          success: function(json) {
              $('#clearFaq').show(); $('#imageClearFaq').hide();
          },
          failure: function(){
              $('#imageClearFaq').hide();
              $('#clearFaq').show();
          },
          error: function(){
              $('#imageClearFaq').hide();
              $('#clearFaq').show();
          }
      });
  }

  $('#tabs a').tabs();
  $('#update-types a').tabs();

  $('#update-v2').bind('click', function(e) {
    e.preventDefault();

    var text_confirm = confirm('<?php echo $text_confirm_backup; ?>');

    if (text_confirm == true) {
      $('#update-error').hide();
      $('.update-v2-box').hide();
      $('#update-v2-progress').fadeIn();
      $('#v2-update-text').text('<?php echo $text_check_server; ?>');
      $('#v2-update-percent').text('5%');

      var beta = $('#update-v2-beta :selected').val();

      updateCheckServer(beta);
    }
  });

  function updateCheckServer(beta) {
    $.ajax({
      url: 'index.php?route=extension/openbay/updatev2&stage=check_server&token=<?php echo $token; ?>&beta=' + beta,
      type: 'post',
      dataType: 'json',
      beforeSend: function() { },
      success: function(json) {
        if (json.error == 1) {
          updateError(json.response);
        } else {
          $('#v2-update-text').text(json.status_message);
          $('#v2-update-percent').text(json.percent_complete + '%');
          updateCheckVersion(beta);
        }
      },
      error: function (xhr, ajaxOptions, thrownError) {
        if (xhr.status != 0) {
          alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
      }
    });
  }

  function updateCheckVersion(beta) {
    $.ajax({
      url: 'index.php?route=extension/openbay/updatev2&stage=check_version&token=<?php echo $token; ?>&beta=' + beta,
      type: 'post',
      dataType: 'json',
      beforeSend: function() { },
      success: function(json) {
        if (json.error == 1) {
          $('#update-error').removeClass('warning').addClass('attention').html(json.response).show();
          $('#update-v2-progress').hide();
          $('.update-v2-box').fadeIn();
        } else {
          $('#v2-update-text').text(json.status_message);
          $('#v2-update-percent').text(json.percent_complete + '%');
          updateDownload(beta);
        }
      },
      error: function (xhr, ajaxOptions, thrownError) {
        if (xhr.status != 0) {
          alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
      }
    });
  }

  function updateDownload(beta) {
    $.ajax({
      url: 'index.php?route=extension/openbay/updatev2&stage=download&token=<?php echo $token; ?>&beta=' + beta,
      type: 'post',
      dataType: 'json',
      beforeSend: function() { },
      success: function(json) {
        if (json.error == 1) {
          updateError(json.response);
        } else {
          $('#v2-update-text').text(json.status_message);
          $('#v2-update-percent').text(json.percent_complete + '%');
          updateExtract(beta);
        }
      },
      error: function (xhr, ajaxOptions, thrownError) {
        if (xhr.status != 0) {
          alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
      }
    });
  }

  function updateExtract(beta) {
    $.ajax({
      url: 'index.php?route=extension/openbay/updatev2&stage=extract&token=<?php echo $token; ?>&beta=' + beta,
      type: 'post',
      dataType: 'json',
      beforeSend: function() { },
      success: function(json) {
        if (json.error == 1) {
          updateError(json.response);
        } else {
          $('#v2-update-text').text(json.status_message);
          $('#v2-update-percent').text(json.percent_complete + '%');
          updateRemove(beta);
        }
      },
      error: function (xhr, ajaxOptions, thrownError) {
        if (xhr.status != 0) {
          alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
      }
    });
  }

  function updateRemove(beta) {
    $.ajax({
      url: 'index.php?route=extension/openbay/updatev2&stage=remove&token=<?php echo $token; ?>&beta=' + beta,
      type: 'post',
      dataType: 'json',
      beforeSend: function() { },
      success: function(json) {
        if (json.error == 1) {
          $('#update-v2-progress').prepend('<div class="alert alert-warning">' + json.response + '</div>');
        }

        $('#v2-update-text').text(json.status_message);
        $('#v2-update-percent').text(json.percent_complete + '%');
        updatePatch(beta);
      },
      error: function (xhr, ajaxOptions, thrownError) {
        if (xhr.status != 0) {
          alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
      }
    });
  }

  function updatePatch(beta) {
    $.ajax({
      url: 'index.php?route=extension/openbay/updatev2&stage=run_patch&token=<?php echo $token; ?>&beta=' + beta,
      type: 'post',
      dataType: 'json',
      beforeSend: function() { },
      success: function(json) {
        if (json.error == 1) {
          updateError(json.response);
        } else {
          $('#v2-update-text').text(json.status_message);
          $('#v2-update-percent').text(json.percent_complete + '%');
          updateVersion(beta);
        }
      },
      error: function (xhr, ajaxOptions, thrownError) {
        if (xhr.status != 0) {
          alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
      }
    });
  }

  function updateVersion(beta) {
    $.ajax({
      url: 'index.php?route=extension/openbay/updatev2&stage=update_version&token=<?php echo $token; ?>&beta=' + beta,
      type: 'post',
      dataType: 'json',
      beforeSend: function() { },
      success: function(json) {
        if (json.error == 1) {
          updateError(json.response);
        } else {
          $('#v2-update-text').text(json.status_message);
          $('#text-version').text(json.response);
          $('#v2-update-percent').text(json.percent_complete + '%');
        }
      },
      error: function (xhr, ajaxOptions, thrownError) {
        if (xhr.status != 0) {
          alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
      }
    });
  }

  function updateError(errors) {
    $('#update-error').text(errors).show();
    $('#update-v2-progress').hide();
    $('.update-v2-box').fadeIn();
  }
//--></script>

<?php echo $footer; ?>
