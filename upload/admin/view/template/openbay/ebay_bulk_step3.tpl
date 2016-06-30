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
      <h1><img src="view/image/order.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">
        <a href="<?php echo $url_return; ?>" class="button"><?php echo $button_cancel; ?></a>
        <a href="<?php echo $url_back; ?>" class="button"><?php echo $button_back; ?></a>
        <a onclick="$('#ebay-form').submit();" class="button"><?php echo $button_submit; ?></a>
      </div>
    </div>
    <div class="content">
      <form action="<?php echo $form_action; ?>" method="post" enctype="multipart/form-data" id="ebay-form">
        <table class="form">
          <tr>
            <td><?php echo $entry_profile_shipping; ?></td>
            <td>
              <select name="profile_shipping">
                <?php foreach ($profiles['shipping'] as $profile) { ?>
                <option value="<?php echo $profile['ebay_profile_id']; ?>" <?php echo ($profiles['shipping_default'] == $profile['ebay_profile_id'] ? 'selected' : ''); ?>><?php echo $profile['name']; ?></option>
                <?php } ?>
              </select>
            </td>
          </tr>
          <tr>
            <td><?php echo $entry_profile_returns; ?></td>
            <td>
              <select name="profile_returns">
                <?php foreach ($profiles['returns'] as $profile) { ?>
                <option value="<?php echo $profile['ebay_profile_id']; ?>" <?php echo ($profiles['returns_default'] == $profile['ebay_profile_id'] ? 'selected' : ''); ?>><?php echo $profile['name']; ?></option>
                <?php } ?>
              </select>
            </td>
          </tr>
          <tr>
            <td><?php echo $entry_profile_theme; ?></td>
            <td>
              <select name="profile_theme">
                <?php foreach ($profiles['theme'] as $profile) { ?>
                <option value="<?php echo $profile['ebay_profile_id']; ?>" <?php echo ($profiles['theme_default'] == $profile['ebay_profile_id'] ? 'selected' : ''); ?>><?php echo $profile['name']; ?></option>
                <?php } ?>
              </select>
            </td>
          </tr>
          <tr>
            <td><?php echo $entry_profile_generic; ?></td>
            <td>
              <select name="profile_generic">
                <?php foreach ($profiles['generic'] as $profile) { ?>
                <option value="<?php echo $profile['ebay_profile_id']; ?>" <?php echo ($profiles['generic_default'] == $profile['ebay_profile_id'] ? 'selected' : ''); ?>><?php echo $profile['name']; ?></option>
                <?php } ?>
              </select>
            </td>
          </tr>
          <?php if (!empty($popular_categories)) { ?>
          <tr id="category-popular-row">
            <td><?php echo $entry_category_popular; ?><span class="help"><?php echo $help_category_popular; ?></span></td>
            <td>
              <p><input type="radio" name="popular" value="" id="popular-default" checked /> <strong><?php echo $text_none; ?></strong></p>

              <?php foreach ($popular_categories as $cat) { ?>
              <p><input type="radio" name="popular" value="<?php echo $cat['CategoryID']; ?>" class="popular-category" /> <?php echo $cat['breadcrumb']; ?></p>
              <?php } ?>
            </td>
          </tr>
          <?php }else{ ?>
          <input type="hidden" name="popular" value="" />
          <?php } ?>
          <tr id="category-selections-row">
            <td><?php echo $entry_category; ?></td>
            <td>
              <div id="category-selections">
                <select id="category-select1" onchange="loadCategories(2);"></select>
                <select id="category-select2" class="displayNone m10" onchange="loadCategories(3);"></select>
                <select id="category-select3" class="displayNone m10" onchange="loadCategories(4);"></select>
                <select id="category-select4" class="displayNone m10" onchange="loadCategories(5);"></select>
                <select id="category-select5" class="displayNone m10" onchange="loadCategories(6);"></select>
                <select id="category-select6" class="displayNone m10" onchange="loadCategories(7);"></select>
                <img src="view/image/loading.gif" id="image-loading" class="displayNone" />
              </div>
              <input type="hidden" name="category_id" id="final-category" />
            </td>
          </tr>
          <tr id="condition-container" class="displayNone">
            <td><?php echo $entry_listing_condition; ?></td>
            <td>
              <select name="condition" id="condition-row" class="displayNone width200"></select>
              <img id="condition-loading" src="view/image/loading.gif" />
            </td>
          </tr>
          <tr id="duration-container" class="displayNone">
            <td><?php echo $entry_listing_duration; ?></td>
            <td>
              <select name="auction_duration" id="duration-row" class="displayNone width200"></select>
              <img id="duration-loading" src="view/image/loading.gif" />
            </td>
          </tr>
          <tr class="displayNone feature-mapping-container">
            <td style="vertical-align:top; padding-top:15px;"><?php echo $entry_mapping_choose; ?></td>
            <td>
              <select name="auto_mapping" id="auto-mapping" class="width200">
                <option value="1" selected><?php echo $text_yes; ?></option>
                <option value="0"><?php echo $text_no; ?></option>
              </select>
            </td>
          </tr>
          <tr class="displayNone feature-container">
            <td style="vertical-align:top; padding-top:15px;"><?php echo $entry_category_features; ?></td>
            <td>
              <table class="form" id="feature-row" style="display:none;"></table>
              <img id="feature-loading" src="view/image/loading.gif" />
            </td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</div>
<?php echo $footer; ?>
<script type="text/javascript"><!--
function loadCategories(level, skip) {
  $('#condition-container').hide();
  $('#duration-container').hide();
  $('#feature-row').empty();
  $('#feature-container').hide();

  if (level == 1) {
    var parent = '';
  }else{
    var previous_level = level - 1;
    var parent = $('#category-select'+previous_level).val();
  }

  var count_i = level;

  while(count_i <= 6) {
    $('#category-select'+count_i).hide().empty();
    count_i++;
  }

  $.ajax({
    url: 'index.php?route=openbay/openbay/getCategories&token=<?php echo $token; ?>&parent='+parent,
    type: 'POST',
    dataType: 'json',
    beforeSend: function() {
      $('#category-selections').removeClass('success').addClass('attention');
      $('#image-loading').show();
    },
    success: function(data) {
      if (data.items != null) {
        $('#category-select'+level).empty();
        $('#category-select'+level).append('<option value=""><?php echo $text_select; ?></option>');

        data.cats = $.makeArray(data.cats);

        $.each(data.cats, function(key, val) {
          if (val.CategoryID != parent) {
            $('#category-select'+level).append('<option value="'+val.CategoryID+'">'+val.CategoryName+'</option>');
          }
        });

        if (skip != true) {
          $('#final-category').val('');
        }

        $('#category-select'+level).show();
      }else{
        if (data.error) {
          $('#category-selections-row').hide();
          $('.content').prepend('<div class="warning">' + data.error + '</div>');
        }else{
          $('#final-category').val($('#category-select'+previous_level).val());
          $('#category-selections').removeClass('attention').addClass('success');
          getCategoryFeatures($('#category-select'+previous_level).val());
        }
      }

      $('#image-loading').hide();
    },
    error: function (xhr, ajaxOptions, thrownError) {
      if (xhr.status != 0) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
      }
    }
  });
}

function getCategoryFeatures(cat) {
  itemFeatures(cat);

  $('#duration-row').hide();
  $('#duration-loading').show();
  $('#duration-container').show();
  $('#condition-row').hide();
  $('#condition-loading').show();
  $('#condition-container').show();

  $.ajax({
    url: 'index.php?route=openbay/openbay/getCategoryFeatures&token=<?php echo $token; ?>&category='+cat,
    type: 'GET',
    dataType: 'json',
    success: function(data) {
      if (data.error == false) {
        var htmlInj = '';
        listingDuration(data.data.durations);

        if (data.data.conditions) {
          if (data.data.conditions.length == 0) {
            $('#condition-container').hide();
          } else {
            data.data.conditions = $.makeArray(data.data.conditions);

            $.each(data.data.conditions, function(key, val) {
              htmlInj += '<option value='+val.id+'>'+val.name+'</option>';
            });

            $('#condition-row').empty().html(htmlInj);
            $('#condition-row').show();
            $('#condition-loading').hide();
          }
        }
      }else{
        if (data.msg == null) {
          alert('<?php echo $error_ajax_noload; ?>');
        }else{
          alert(data.msg);
        }
      }
    },
    error: function (xhr, ajaxOptions, thrownError) {
      if (xhr.status != 0) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
      }
    }
  });
}

function itemFeatures(category_id) {
  $('#feature-row').hide();
  $('#feature-loading').show();
  $('.feature-mapping-container').show();

  $.ajax({
    url: 'index.php?route=openbay/openbay/getEbayCategorySpecifics&token=<?php echo $token; ?>&category_id=' + category_id,
    type: 'GET',
    dataType: 'json',
    beforeSend: function() {
      $('#feature-row').empty();
      $('.optSpecifics').empty().hide();
      $('#feature-loading').show();
    },
    success: function(data) {
      if (data.error == false) {

        var html_inj = '';
        var html_inj2 = '';
        var specific_count = 0;

        if (data.data) {
          $.each(data.data, function(option_specific_key, option_specific_value) {
            html_inj2 = '';

            html_inj += '<tr>';
            html_inj += '<td class="ebaySpecificTitle">' + option_specific_value.name + '</td>';
            html_inj += '<td>';

            if (("options" in option_specific_value) && (option_specific_value.validation.max_values == 1)) {
              html_inj2 += '<option disabled selected></option>';

              $.each(option_specific_value.options, function(option_key, option) {
                html_inj2 += '<option value="' + option + '">' + option + '</option>';
              });

              if (option_specific_value.validation.selection_mode == 'FreeText') {
                html_inj2 += '<option value="Other">Other</option>';
              }

              html_inj += '<select style="min-with:200px; padding:2px;" name="feat[' + option_specific_value.name + ']" id="spec_sel_' + specific_count + '" onchange="toggleSpecOther(' + specific_count + ');">' + html_inj2 + '</select>';
              html_inj += '<span id="spec_' + specific_count + '_other" style="display:none;">';
              html_inj += '<input style="margin-left:20px;" type="text" name="featother[' + option_specific_value.name + ']"/>';
              html_inj += '</span>';

            } else if (("options" in option_specific_value) && (option_specific_value.validation.max_values > 1)) {
              $.each(option_specific_value.options, function(option_key, option) {
                html_inj += '<p>';
                html_inj += '<input type="checkbox" name="feat[' + option_specific_value.name + '][]" value="' + option + '" /> ' + option;
                html_inj += '</p>';
              });
            } else {
              html_inj += '<input type="text" name="feat[' + option_specific_value.name + ']" class="ebaySpecificInput" /></td>';
            }
            html_inj += '</td>';
            html_inj += '</tr>';

            specific_count++;
          });

          $('#feature-row').append(html_inj).show();
        } else {
          $('#feature-row').text('None').show();
        }
      }else{
        if (data.msg == null) {
          alert('<?php echo $error_ajax_noload; ?>');
        }else{
          alert(data.msg);
        }
      }

      $('#feature-loading').hide();
    },
    error: function (xhr, ajaxOptions, thrownError) {
      if (xhr.status != 0) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
      }
    }
  });
}

function listingDuration(data) {
  var lang            = new Array();
  var listing_default = '<?php echo $defaults["listing_duration"]; ?>';

  lang["Days_1"]      = '<?php echo $text_listing_1day; ?>';
  lang["Days_3"]      = '<?php echo $text_listing_3day; ?>';
  lang["Days_5"]      = '<?php echo $text_listing_5day; ?>';
  lang["Days_7"]      = '<?php echo $text_listing_7day; ?>';
  lang["Days_10"]     = '<?php echo $text_listing_10day; ?>';
  lang["Days_30"]     = '<?php echo $text_listing_30day; ?>';
  lang["GTC"]         = '<?php echo $text_listing_gtc; ?>';

  htmlInj        = '';

  data = $.makeArray(data);

  $.each(data, function(key, val) {
    htmlInj += '<option value="'+val+'"';
    if (val == listing_default) { htmlInj += ' selected="selected"';}
    htmlInj += '>'+lang[val]+'</option>';
  });

  $('#duration-row').empty().html(htmlInj).show();
  $('#duration-loading').hide();
}

$('#auto-mapping').bind('change', function() {
  if($(this).val() == 0) {
    $('.feature-container').show();
  } else {
    $('.feature-container').hide();
  }
});

$('input[name=popular]').bind('change', function() {
  if ($(this).val() != '') {
    $('#category-selections-row').hide();
    categoryPopularChange($(this).val());
  } else {
    $('#category-selections-row').show();
    $('#condition-container').hide();
    $('#duration-container').hide();
    $('#feature-row').empty();
    $('#feature-container').hide();
  }
});

function categoryPopularChange(id) {
  loadCategories(1, true);
  $('input[name=category_id]').attr('value', id);
  getCategoryFeatures(id);
}

$(document).ready(function() {
  loadCategories(1);
});
//--></script>