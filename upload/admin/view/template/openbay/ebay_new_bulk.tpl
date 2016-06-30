<?php echo $header; ?>

<div id="content">
    <?php if(!isset($error_fail)){ ?>

    <?php foreach($error_warning as $warning) { ?>
        <div class="warning mBottom10"><?php echo $warning; ?></div>
    <?php } ?>

    <div class="box">
        <div class="heading">
            <h1><?php echo $lang_page_title; ?></h1>
            <div class="buttons">
                <a class="button" onclick="previewAll()" id="previewBtn"><span><?php echo $lang_preview_all; ?></span></a>
                <a class="button" style="display:none" onclick="editAll();" id="previewEditBtn"><span><?php echo $lang_edit; ?></span></a>
                <a class="button" style="display:none" onclick="submitAll();" id="submitBtn"><span><?php echo $lang_submit; ?></span></a>
            </div>
        </div>
        <form id="form">
            <table class="list">
                <tbody>
                    <tr>
                        <td>
                            <?php if ($products) { ?>
                            <?php $i = 0; ?>
                            <?php foreach ($products as $product) { ?>

                            <div class="box mTop15 listingBox" id="p_row_<?php echo $i; ?>">
                                <input type="hidden" class="pId openbayData_<?php echo $i; ?>" name="pId" value="<?php echo $i; ?>" />
                                <input type="hidden" class="openbayData_<?php echo $i; ?>" name="product_id" value="<?php echo $product['product_id']; ?>" id="product-id-<?php echo $i; ?>" />
                                <div class="heading">
                                    <div id="p_row_title_<?php echo $i; ?>" style="float:left;" class="displayNone bold m0 p10"></div>
                                    <div id="p_row_buttons_<?php echo $i; ?>" class="buttons right">
                                        <a class="button" onclick="removeBox('<?php echo $i; ?>')"><span><?php echo $lang_remove; ?></span></a>
                                    </div>
                                </div>
                                <table class="m0 border borderNoBottom" style="width:100%;" cellpadding="0" cellspacing="0">
                                    <tr id="p_row_msg_<?php echo $i; ?>" class="displayNone">
                                        <td colspan="3" id="p_msg_<?php echo $i; ?>">
                                            <img src="view/image/loading.gif" style="margin:10px;" alt="Loading" />
                                        </td>
                                    </tr>

                                    <tr class="p_row_content_<?php echo $i; ?>">
                                        <td class="center width100"><img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" /></td>
                                        <td class="left width390" valign="top">
                                            <p><label style="display:inline-block;" class="width100 mRight10 bold"><?php echo $lang_title; ?>:</label><input type="text" name="title" class="openbayData_<?php echo $i; ?> width250" value="<?php echo $product['name']; ?>" id="title_<?php echo $i; ?>" /></p>
                                            <input type="hidden" name="price_original" id="price_original_<?php echo $i; ?>" value="<?php echo number_format($product['price']*(($default['defaults']['tax']/100) + 1), 2, '.', ''); ?>" />
                                            <p><label style="display:inline-block;" class="width100 mRight10 bold"><?php echo $lang_price; ?>:</label><input id="price_<?php echo $i; ?>" type="text" name="price" class="openbayData_<?php echo $i; ?> width50" value="<?php echo number_format($product['price']*(($default['defaults']['tax']/100) + 1), 2, '.', ''); ?>" /></p>
                                            <p><label style="display:inline-block;" class="width100 mRight10 bold"><?php echo $lang_stock; ?>:</label><?php echo $product['quantity']; ?></p>
                                            <input type="hidden" name="qty" value="<?php echo $product['quantity']; ?>" class="openbayData_<?php echo $i; ?>" />

                                            <div class="buttons right">
                                                <a class="button" onclick="showFeatures('<?php echo $i; ?>');" id="editFeature_<?php echo $i; ?>" style="display:none;"><span><?php echo $lang_features; ?></span></a>
                                                <a class="button" onclick="showCatalog('<?php echo $i; ?>');" id="editCatalog_<?php echo $i; ?>" style="display:none;"><span><?php echo $lang_catalog; ?></span></a>
                                            </div>

                                            <div id="featurePage_<?php echo $i; ?>" class="greyScreenBox featurePage">
                                                <div class="bold border p5 previewClose">X</div>
                                                <div class="previewContentScroll">
                                                  <table class="form" id="product_identifier_container_<?php echo $i; ?>" style="display: none;">
                                                    <tr id="product_identifier_ean_container_<?php echo $i; ?>" style="display:none;">
                                                      <td class="ebaySpecificTitle left"><?php echo $text_ean; ?></td>
                                                      <td>
                                                        <p class="left">
                                                          <input type="hidden" id="identifier_ean_required_<?php echo $i; ?>" class="product_identifier_required_<?php echo $i; ?>" value="0" />
                                                          <input type="hidden" id="identifier_ean_original_<?php echo $i; ?>" value="<?php echo $product['ean']; ?>" />
                                                          <input type="text" name="identifier_ean" value="<?php echo $product['ean']; ?>" id="identifier_ean_<?php echo $i; ?>" class="ebaySpecificInput openbayData_<?php echo $i; ?>" />
                                                        </p>
                                                      </td>
                                                    </tr>
                                                    <tr id="product_identifier_isbn_container_<?php echo $i; ?>" style="display:none;">
                                                      <td class="ebaySpecificTitle left"><?php echo $text_isbn; ?></td>
                                                      <td>
                                                        <p class="left">
                                                          <input type="hidden" id="identifier_isbn_required_<?php echo $i; ?>" class="product_identifier_required_<?php echo $i; ?>" value="0" />
                                                          <input type="hidden" id="identifier_isbn_original_<?php echo $i; ?>" value="<?php echo $product['isbn']; ?>" />
                                                          <input type="text" name="identifier_isbn" value="<?php echo $product['isbn']; ?>" id="identifier_isbn_<?php echo $i; ?>" class="ebaySpecificInput openbayData_<?php echo $i; ?>" />
                                                        </p>
                                                      </td>
                                                    </tr>
                                                    <tr id="product_identifier_upc_container_<?php echo $i; ?>" style="display:none;">
                                                      <td class="ebaySpecificTitle left"><?php echo $text_upc; ?></td>
                                                      <td>
                                                        <p class="left">
                                                          <input type="hidden" id="identifier_upc_required_<?php echo $i; ?>" class="product_identifier_required" value="0" />
                                                          <input type="hidden" id="identifier_upc_original_<?php echo $i; ?>" value="<?php echo $product['upc']; ?>" />
                                                          <input type="text" name="identifier_upc" value="<?php echo $product['upc']; ?>" id="identifier_upc_<?php echo $i; ?>" class="ebaySpecificInput openbayData_<?php echo $i; ?>" />
                                                        </p>
                                                      </td>
                                                    </tr>
                                                    <tr>
                                                      <td class="ebaySpecificTitle left"><?php echo $text_identifier_not_required; ?></td>
                                                      <td>
                                                        <p class="left"><input type="checkbox" name="identifier_not_required" value="1" id="identifier_not_required_<?php echo $i; ?>" onclick="identifierNotRequired(<?php echo $i; ?>);" /></p>
                                                      </td>
                                                    </tr>
                                                  </table>
                                                  <table class="form" id="featureRow_<?php echo $i; ?>"></table>
                                                </div>
                                            </div>

                                            <!-- main product catalog popup box -->
                                            <div id="catalogPage_<?php echo $i; ?>" class="greyScreenBox featurePage">
                                                <div class="bold border p5 previewClose">X</div>
                                                <div class="previewContentScroll">

                                                    <!-- catalog search area -->
                                                    <table class="form">
                                                        <tr>
                                                            <td><?php echo $lang_catalog_search; ?>:</td>
                                                            <td>
                                                                <div class="buttons">
                                                                    <input type="text" name="catalog_search" id="catalog_search_<?php echo $i; ?>" value="" />
                                                                    <a onclick="searchEbayCatalog('<?php echo $i; ?>');" class="button" id="catalog_search_btn_<?php echo $i; ?>"><span><?php echo $lang_search; ?></span></a>
                                                                    <img src="view/image/loading.gif" id="catalog_search_img_<?php echo $i; ?>" class="displayNone" alt="Loading" />
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </table>

                                                    <!-- container for the product catalog information -->
                                                    <div id="catalogDiv_<?php echo $i; ?>"></div>

                                                    <input type="hidden" class="openbayData_<?php echo $i; ?>" name="catalog_epid" id="catalog_epid_<?php echo $i; ?>" value="0" />

                                                </div>
                                            </div>
                                        </td>
                                        <td class="p10">
                                            <p>
                                                <label style="display:inline-block;" class="mRight10 bold width100"><?php echo $lang_profile_theme; ?></label>
                                                <select name="theme_profile" class="width250 openbayData_<?php echo $i; ?>">
                                                    <?php foreach($default['profiles_theme'] as $s){ echo '<option value="'.$s['ebay_profile_id'].'"'.($default['profiles_theme_def'] == $s['ebay_profile_id'] ? ' selected' : '').'>'.$s['name'].'</option>'; } ?>
                                                </select>
                                            </p>
                                            <p>
                                                <label style="display:inline-block;" class="mRight10 bold width100"><?php echo $lang_profile_shipping; ?></label>
                                                <select name="shipping_profile" class="width250 openbayData_<?php echo $i; ?>">
                                                    <?php foreach($default['profiles_shipping'] as $s){ echo '<option value="'.$s['ebay_profile_id'].'"'.($default['profiles_shipping_def'] == $s['ebay_profile_id'] ? ' selected' : '').'>'.$s['name'].'</option>'; } ?>
                                                </select>
                                            </p>
                                            <p>
                                                <label style="display:inline-block;" class="mRight10 bold width100"><?php echo $lang_profile_generic; ?></label>
                                                <select name="generic_profile" id="generic_profile_<?php echo $i; ?>" class="width250 openbayData_<?php echo $i; ?>" onchange="genericProfileChange(<?php echo $i; ?>);">
                                                    <?php foreach($default['profiles_generic'] as $s){ echo '<option value="'.$s['ebay_profile_id'].'"'.($default['profiles_generic_def'] == $s['ebay_profile_id'] ? ' selected' : '').'>'.$s['name'].'</option>'; } ?>
                                                </select>
                                            </p>
                                            <p>
                                                <label style="display:inline-block;" class="mRight10 bold width100"><?php echo $lang_profile_returns; ?></label>
                                                <select name="return_profile" class="width250 openbayData_<?php echo $i; ?>">
                                                    <?php foreach($default['profiles_returns'] as $s){ echo '<option value="'.$s['ebay_profile_id'].'"'.($default['profiles_returns_def'] == $s['ebay_profile_id'] ? ' selected' : '').'>'.$s['name'].'</option>'; } ?>
                                                </select>
                                            </p>
                                            <p id="conditionContainer_<?php echo $i; ?>" class="displayNone">
                                                <label style="display:inline-block; width:100px;" class="mRight10 bold"><?php echo $lang_condition; ?> </label>
                                                <select name="condition" id="conditionRow_<?php echo $i; ?>" class="displayNone width250 openbayData_<?php echo $i; ?>"></select>
                                                <img id="conditionLoading_<?php echo $i; ?>" src="view/image/loading.gif" alt="Loading" />
                                            </p>
                                            <p id="durationContainer_<?php echo $i; ?>" class="displayNone">
                                                <label style="display:inline-block; width:100px;" class="mRight10 bold"><?php echo $lang_duration; ?> </label>
                                                <select name="duration" id="durationRow_<?php echo $i; ?>" class="displayNone width250 openbayData_<?php echo $i; ?>"></select>
                                                <img id="durationLoading_<?php echo $i; ?>" src="view/image/loading.gif" alt="Loading" />
                                            </p>
                                        </td>
                                    </tr>
                                    <tr class="p_row_content_<?php echo $i; ?>">
                                        <td colspan="3" style="padding:5px;">
                                            <p class="bold m0"><?php echo $lang_category; ?> <img src="view/image/loading.gif" id="loadingSuggestedCat_<?php echo $i; ?>" alt="Loading" /></p>

                                            <div class="left pLeft10" id="suggestedCat_<?php echo $i; ?>"></div>

                                            <div style="clear:both;"></div>

                                            <div id="cSelections_<?php echo $i; ?>" class="displayNone left mTop10 pLeft30">
                                                <select id="catsSelect1_<?php echo $i; ?>" class="mLeft30" onchange="loadCategories(2, false, <?php echo $i; ?>);"></select>
                                                <select id="catsSelect2_<?php echo $i; ?>" class="displayNone mLeft20" onchange="loadCategories(3, false, <?php echo $i; ?>);"></select>
                                                <select id="catsSelect3_<?php echo $i; ?>" class="displayNone mLeft20" onchange="loadCategories(4, false, <?php echo $i; ?>);"></select>
                                                <select id="catsSelect4_<?php echo $i; ?>" class="displayNone mLeft20" onchange="loadCategories(5, false, <?php echo $i; ?>);"></select>
                                                <select id="catsSelect5_<?php echo $i; ?>" class="displayNone mLeft20" onchange="loadCategories(6, false, <?php echo $i; ?>);"></select>
                                                <select id="catsSelect6_<?php echo $i; ?>" class="displayNone mLeft20" onchange="loadCategories(7, false, <?php echo $i; ?>);"></select>
                                                <img src="view/image/loading.gif" id="imageLoading_<?php echo $i; ?>" class="displayNone" alt="Loading" />
                                            </div>

                                            <input type="hidden" name="finalCat" id="finalCat_<?php echo $i; ?>" class="openbayData_<?php echo $i; ?>" />
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <?php $i++; } ?>
                            <?php } else { ?>
                    <tr>
                        <td class="center" colspan="3"><?php echo $text_no_results; ?></td>
                    </tr>
            </table>
            <?php } ?>
            </td></tr>
            </tbody>
            </table>
        </form>
    </div>
    <div id="greyScreen"></div>
    <div id="loadingPage" class="greyScreenBox">
        <p class="bold"><img src="view/image/loading.gif" alt="Loading" /> <?php echo $lang_loading; ?></p>
        <p><?php echo $lang_preparing0; ?> <span id="ajaxCountDoneDisplay">0</span> <?php echo $lang_preparing1; ?> <span id="ajaxCountTotalDisplay">0</span> <?php echo $lang_preparing2; ?> </p>
        <div class="buttons">
            <a class="button" href="index.php?route=extension/openbay/itemList&token=<?php echo $this->request->get['token']; ?>"><span><?php echo $lang_cancel; ?></span></a>
        </div>
    </div>
    <div id="loadingVerify" class="greyScreenBox">
        <p class="bold"><img src="view/image/loading.gif" alt="Loading" /> <?php echo $lang_verifying; ?></p>
        <p><?php echo $lang_processing; ?></p>
    </div>
    <div id="previewPage" class="greyScreenBox">
        <div class="bold border p5 previewClose">X</div>
        <div class="previewContent">
            <iframe id="previewContentIframe" frameborder="0" height="100%" width="100%" style="margin-left:auto; margin-right:auto;" scrolling="auto"></iframe>
        </div>
    </div>
    <?php }else{ ?>
        <?php foreach($error_fail as $fail) { ?>
        <div class="warning mBottom10"><?php echo $fail; ?></div>
    <?php } ?>
    <?php } ?>
</div>

<input type="hidden" id="totalItems" value="<?php echo $count; ?>" name="totalItems" />
<input type="hidden" id="ajaxCount" value="0" />
<input type="hidden" class="ajaxCountTotal" id="ajaxCountTotal" value="0" />
<input type="hidden" class="ajaxCountDone" id="ajaxCountDone" value="0" />

<script type="text/javascript">
    $(document).ready(function() {
        showGreyScreen('loadingPage');

        <?php $j = 0; while ($j < $i) { ?>
            getSuggestedCategories('<?php echo (int)$j; ?>');
            modifyPrices('<?php echo (int)$j; ?>');
        <?php $j++; } ?>

        $('#activeItems').text($('#totalItems').val());
    });

    $(document).keyup(function(e) {
        if (e.keyCode == 27) {
            alert('<?php echo $lang_esc_key; ?>');
            hideGreyScreen();
        }
    });

    function modifyPrices(id){
        var price_original  = parseFloat($('#price_original_'+id).val());
        var price_modified = '';
        var modify_percent = '';

        $.ajax({
            url: 'index.php?route=openbay/ebay_profile/profileGet&token=<?php echo $token; ?>&ebay_profile_id='+$('#generic_profile_'+id).val(),
            type: 'GET',
            async: true,
            dataType: 'json',
            beforeSend: function(){ addCount(); },
            success: function(data) {

                if(data.data.price_modify !== false && typeof data.data.price_modify !== 'undefined'){
                    modify_percent = 100 + parseFloat(data.data.price_modify);
                    modify_percent = parseFloat(modify_percent / 100);
                    price_modified = price_original * modify_percent;

                    $('#price_'+id).val(parseFloat(price_modified).toFixed(2));
                }

                removeCount();
            },
            failure: function(){
                removeCount();
            },
            error: function(){
                removeCount();
            }
        });
    }

    function addCount(){
        var count = parseInt($('#ajaxCount').val()) + 1;
        $('#ajaxCount').val(count);
        var count1 = parseInt($('#ajaxCountTotal').val())+1;
        $('#ajaxCountTotal').val(count1);
        $('#ajaxCountTotalDisplay').text(count1);
    }

    function removeCount(){
        var count = parseInt($('#ajaxCount').val())-1;
        $('#ajaxCount').val(count);
        var count1 = parseInt($('#ajaxCountDone').val())+1;
        $('#ajaxCountDone').val(count1);
        $('#ajaxCountDoneDisplay').text(count1);

        if(count == 0){
            hideGreyScreen();
        }
    }

    function removeBox(id){
        $('#p_row_'+id).fadeOut('medium');

        setTimeout(function(){
            $('#p_row_'+id).remove();
        }, 1000);

        $('#totalItems').val($('#totalItems').val()-1);

        if ($('.listingBox').length == 1){
            window.location = "index.php?route=extension/openbay/itemList&token=<?php echo $this->request->get['token']; ?>";
        }else{
            $('#activeItems').text($('#totalItems').val());
        }
    }

    function useManualCategory(id){
        loadCategories(1, true, id);
        $('#cSelections_'+id).show();
    }

    function getSuggestedCategories(id){
        var qry = $('#title_'+id).val();

        $.ajax({
            url: 'index.php?route=openbay/openbay/getSuggestedCategories&token=<?php echo $token; ?>&qry='+qry,
            type: 'GET',
            async: true,
            dataType: 'json',
            beforeSend: function(){ $('#loadingSuggestedCat_'+id).show(); addCount(); },
            success: function(data) {
                $('#suggestedCat_'+id).empty();

                var html_inj = '';

                if(data.error == false && data.data){
                    var i = 1;

                        $.each(data.data, function(key,val){
                            if(val.percent != 0) {
                                html_inj += '<p style="margin:0px; padding:0 0 0 10px;"><input type="radio" id="suggested_category_'+id+'" name="suggested_'+id+'" value="'+val.id+'" onchange="categorySuggestedChange('+val.id+','+id+')"';
                                if(i == 1){
                                    html_inj += ' checked="checked"';
                                    categorySuggestedChange(val.id, id);
                                }
                                html_inj += '/> ('+val.percent+'% match) '+val.name+'</p>';
                            }
                            i++;
                        });

                        html_inj += '<p style="margin:0px; padding:0 0 0 10px;"><input type="radio" id="manual_use_category_'+id+'" name="suggested_'+id+'" value="" onchange="useManualCategory('+id+')" /> Choose category</p>';
                        $('#suggestedCat_'+id).html(html_inj);
                }else{
                    html_inj += '<p style="margin:0px; padding:0 0 0 10px;"><input type="radio" id="manual_use_category_'+id+'" name="suggested_'+id+'" value="" onchange="useManualCategory('+id+')" checked="checked" /> Choose category</p>';
                    $('#suggestedCat_'+id).html(html_inj);
                    useManualCategory(id);
                }

                $('#loadingSuggestedCat_'+id).hide();
                removeCount();
            },
            failure: function(){
                $('#loadingSuggestedCat_'+id).hide();
                removeCount();
            },
            error: function(){
                $('#loadingSuggestedCat_'+id).hide();
                removeCount();
            }
        });
    }

    function loadCategories(level, skip, id){
        var parent = '';

        if(level == 1){
            parent = ''
        }else{
            var prevLevel = level - 1;
            parent = $('#catsSelect'+prevLevel+'_'+id).val();
        }

        var countI = level;

        while(countI <= 6){
            $('#catsSelect'+countI+'_'+id).hide().empty();
            countI++;
        }

        $.ajax({
            url: 'index.php?route=openbay/openbay/getCategories&token=<?php echo $token; ?>&parent='+parent,
            type: 'GET',
            dataType: 'json',
            beforeSend: function(){
                $('#cSelections_'+id).removeClass('success').addClass('attention');
                $('#imageLoading_'+id).show();
                addCount();
            },
            success: function(data) {
                if(data.items != null){
                    $('#catsSelect'+level+'_'+id).empty();
                    $('#catsSelect'+level+'_'+id).append('<option value="">-- SELECT --</option>');
                    $.each(data.cats, function(key, val) {
                        if(val.CategoryID != parent){
                            $('#catsSelect'+level+'_'+id).append('<option value="'+val.CategoryID+'">'+val.CategoryName+'</option>');
                        }
                    });

                    if(skip != true){
                        $('#finalCat_'+id).val('');
                    }

                    $('#catsSelect'+level+'_'+id).show();
                }else{
                    if(data.error){

                    }else{
                        $('#finalCat_'+id).val($('#catsSelect'+prevLevel+'_'+id).val());
                        $('#cSelections_'+id).removeClass('attention').addClass('success');
                        getCategoryFeatures($('#catsSelect'+prevLevel+'_'+id).val(), id);
                    }
                }
                $('#imageLoading_'+id).hide();
                removeCount();
            },
            failure: function(){
                removeCount();
            },
            error: function(){
                removeCount();
            }
        });
    }

    function getCategoryFeatures(cat, id){
      itemFeatures(cat, id);
      $('#editCatalog_'+id).show();

      $('#durationRow_'+id).hide();
      $('#durationLoading_'+id).show();
      $('#durationContainer_'+id).show();

      $('#conditionRow_'+id).hide();
      $('#conditionLoading_'+id).show();
      $('#conditionContainer_'+id).show();

      $('#product_identifier_container_'+id).hide();
      $('.product_identifier_required_'+id).val('0');

      $.ajax({
        url: 'index.php?route=openbay/openbay/getCategoryFeatures&token=<?php echo $token; ?>&category=' + cat,
        type: 'GET',
        dataType: 'json',
        beforeSend: function () {
          addCount();
        },
        success: function (data) {
          if (data.error == false) {
            var html_inj = '';

            listingDuration(data.data.durations, id);

            if (data.data.conditions) {
              $.each(data.data.conditions, function (key, val) {
                html_inj += '<option value=' + val.id + '>' + val.name + '</option>';
              });

              if (html_inj == '') {
                $('#conditionRow_' + id).empty();
                $('#conditionContainer_' + id).hide();
                $('#conditionRow_' + id).hide();
                $('#conditionLoading_' + id).hide();
              } else {
                $('#conditionRow_' + id).empty().html(html_inj);
                $('#conditionRow_' + id).show();
                $('#conditionLoading_' + id).hide();
              }
            }

            if (data.data.ean_identifier_requirement != '') {
              $('#product_identifier_container_' + id).show();
              $('#product_identifier_ean_container_' + id).show();

              if (data.data.ean_identifier_requirement == 'Required') {
                $('#identifier_ean_required_' + id).val(1);
              }
            }

            if (data.data.isbn_identifier_requirement != '') {
              $('#product_identifier_container_' + id).show();
              $('#product_identifier_isbn_container_' + id).show();

              if (data.data.isbn_identifier_requirement == 'Required') {
                $('#identifier_isbn_required_' + id).val(1);
              }
            }

            if (data.data.upc_identifier_requirement != '') {
              $('#product_identifier_container_' + id).show();
              $('#product_identifier_upc_container_' + id).show();

              if (data.data.upc_identifier_requirement == 'Required') {
                $('#identifier_upc_required_' + id).val(1);
              }
            }
          } else {
            alert(data.msg);
          }
          removeCount();
        },
        failure: function () {
          removeCount();
        },
        error: function () {
          removeCount();
        }
      });
    }

    function html_encode(s) {
      return $('<div>').text(s).html();
    }

    function itemFeatures(category_id, id){
        $('#editFeature_' + id).hide();

        $.ajax({
            url: 'index.php?route=openbay/openbay/getEbayCategorySpecifics&token=<?php echo $token; ?>&category_id=' + category_id + '&product_id=' + $('#product-id-' + id).val(),
            type: 'GET',
            dataType: 'json',
            beforeSend: function(){ addCount(); },
            success: function(data) {
                if(data.error == false){
                  $('#featureRow_'+id).empty();

                  var html_inj = '';
                  var html_inj2 = '';
                  var specific_count = 0;
                  var field_value = '';
                  var show_other = false;
                  var show_other_value = '';
                  var product_id = $('#product-id-' + id).val();

                  if(data.data){
                    $.each(data.data, function(option_specific_key, option_specific_value) {
                        html_inj2 = '';

                      html_inj += '<tr>';
                      html_inj += '<td class="ebaySpecificTitle left">'+option_specific_value.name+'</td>';
                      html_inj += '<td>';

                        if (("options" in option_specific_value) && (option_specific_value.validation.max_values == 1)) {
                          // matched_value_key in option_specific_value
                          if ("matched_value_key" in option_specific_value) {
                            $.each(option_specific_value.options, function(option_key, option) {
                              if (option_specific_value.matched_value_key == option_key) {
                                html_inj2 += '<option value="' + option + '" selected>' + option + '</option>';
                              } else {
                                html_inj2 += '<option value="' + option + '">' + option + '</option>';
                              }
                            });
                          } else {
                            html_inj2 += '<option disabled selected></option>';

                            $.each(option_specific_value.options, function(option_key, option) {
                              html_inj2 += '<option value="' + option + '">' + option + '</option>';
                            });
                          }

                          show_other = false;
                          show_other_value = '';

                          if (option_specific_value.validation.selection_mode == 'FreeText') {
                            if (option_specific_value.unmatched_value != '') {
                              html_inj2 += '<option value="Other" selected><?php echo $lang_other; ?></option>';
                              show_other = true;
                              show_other_value = option_specific_value.unmatched_value;
                            } else {
                              html_inj2 += '<option value="Other"><?php echo $lang_other; ?></option>';
                            }
                          }

                          html_inj += '<select class="ebaySpecificSelect openbayData_' + id + ' left" style="min-with:200px; padding:5px 2px;" name="feat[' + option_specific_value.name + ']" id="spec_sel_' + specific_count + '" onchange="toggleSpecOther(' + specific_count + ');">' + html_inj2 + '</select>';

                          if (show_other === true) {
                            html_inj += '<p id="spec_' + specific_count + '_other">';
                          } else {
                            html_inj += '<p id="spec_' + specific_count + '_other" style="display:none;">';
                          }
                          html_inj += '<input class="ebaySpecificOther openbayData_' + id + ' left" type="text" name="featother[' + option_specific_value.name + ']" value="' + show_other_value + '"/>';
                          html_inj += '</p>';
                        } else if (("options" in option_specific_value) && (option_specific_value.validation.max_values > 1)) {
                          $.each(option_specific_value.options, function(option_key, option) {
                            html_inj += '<p class="left"><input type="checkbox" name="feat[' + option_specific_value.name + '][]" value="' + option + '" class="openbayData_'+id+'"/>' + option + '</p>';
                          });
                        }else{
                          html_inj += '<input type="text" name="feat[' + option_specific_value.name + ']" class="ebaySpecificInput openbayData_' + id + ' left" value="' + option_specific_value.unmatched_value + '" />';
                        }

                        html_inj += '</td></tr>';

                        specific_count++;
                    });

                    $('#featureRow_'+id).append(html_inj);
                  } else {
                    $('#featureRow_'+id).text('None');
                  }
                } else {
                    alert(data.msg);
                }

                $('#editFeature_'+id).show();

                removeCount();
            },
            failure: function(){
                removeCount();
            },
            error: function(){
                removeCount();
            }
        });
    }

    function toggleSpecOther(id){
        var selectVal = $('#spec_sel_'+id).val();

        if(selectVal == 'Other'){
            $('#spec_'+id+'_other').show();
        }else{
            $('#spec_'+id+'_other').hide();
        }
    }

    function searchEbayCatalog(id){
        var qry = $('#catalog_search_'+id).val();
        var cat = $('#finalCat_'+id).val();

        var html = '';

        if(qry == ''){
            alert('<?php echo $lang_search_text; ?>');
        }

        $.ajax({
            url: 'index.php?route=openbay/openbay/searchEbayCatalog&token=<?php echo $token; ?>',
            type: 'POST',
            dataType: 'json',
            data: {
                categoryId: cat,
                page: 1,
                search: qry
            },
            beforeSend: function(){
                $('#catalog_search_btn_'+id).hide();
                $('#catalog_search_img_'+id).show();
                $('#catalogDiv_'+id).empty();
            },
            success: function(data) {
                $('#catalog_search_btn_'+id).show();
                $('#catalog_search_img_'+id).hide();
                if(data.error == false){
                    if(data.data.productSearchResult.paginationOutput.totalEntries == 0 || data.data.ack == 'Failure'){
                        $('#catalogDiv_'+id).append('<?php echo $lang_catalog_no_products; ?>');
                    }else{
                        data.data.productSearchResult.products = $.makeArray(data.data.productSearchResult.products);

                        $.each(data.data.productSearchResult.products, function(key, val){
                            processCatalogItem(val, id);
                        });
                    }
                }
            },
            failure: function(){
                $('#catalog_search_btn_'+id).show();
                $('#catalog_search_img_'+id).hide();
                $('#catalogDiv_'+id).append('<?php echo $lang_search_failed; ?>');
            },
            error: function(){
                $('#catalog_search_btn_'+id).show();
                $('#catalog_search_img_'+id).hide();
                $('#catalogDiv_'+id).append('<?php echo $lang_search_failed; ?>');
            }
        });
    }

    function processCatalogItem(val, id){
        html = '';
        html += '<div style="float:left; display:inline; width:450px; height:100px; padding:5px; margin-right:10px; margin-bottom:10px;" class="border">';
            html += '<div style="vertical-align:middle; float:left; display:inline; width:20px; height:100px; vertical-align:middle;">';
                html += '<input type="radio" class="openbayData_'+id+'" name="catalog_epid_'+id+'" value="'+val.productIdentifier.ePID+'" />';
            html += '</div>';
            html += '<div style="float:left; display:inline; width:100px; height:100px; overflow:hidden; text-align: center;">';
                html += '<img src="'+val.stockPhotoURL.thumbnail.value+'" />';
            html += '</div>';
            html += '<div style="float:left; display:inline; width:300px;">';
                html += '<p style="line-height:24px;">'+val.productDetails.value.text.value+'</p>';
            html += '</div>';
        html += '</div>';

        $('#catalogDiv_'+id).append(html);
    }

    function listingDuration(data, id){
        var lang            = new Array();
        var listingDefault  = "<?php echo (isset($default['defaults']['listing_duration']) ? $default['defaults']['listing_duration'] : ''); ?>";

        lang["Days_1"]      = '1 Day';
        lang["Days_3"]      = '3 Days';
        lang["Days_5"]      = '5 Days';
        lang["Days_7"]      = '7 Days';
        lang["Days_10"]     = '10 Days';
        lang["Days_30"]     = '30 Days';
        lang["GTC"]         = 'GTC';

        html_inj        = '';
        $.each(data, function(key, val){
            html_inj += '<option value="'+val+'"';
            if(val == listingDefault){ html_inj += ' selected="selected"';}
            html_inj += '>'+lang[val]+'</option>';
        });

        $('#durationRow_'+id).empty().html(html_inj);
        $('#durationRow_'+id).show();
        $('#durationLoading_'+id).hide();
    }

    function categorySuggestedChange(val, id){
        $('#cSelections_'+id).hide();
        loadCategories(1, true, id);
        $('#finalCat_'+id).attr('value', val);
        getCategoryFeatures(val, id);
    }

    function editAll(){
        var id = '';
        var name = '';

        $('#previewBtn').show();
        $('#previewEditBtn').hide();
        $('#submitBtn').hide();
        $('.p_row_buttons_prev').remove();
        $('.p_row_buttons_view').remove();

        $.each($('.pId'), function(i){
            id = $(this).val();
            name = $('#title_'+$(this).val()).val();
            $('#p_row_msg_'+$(this).val()).hide();
            $('.p_row_content_'+$(this).val()).show();
            $('#p_row_title_'+$(this).val()).text(name).hide();
            $('#p_msg_'+i).empty();
        });
    }

    function previewAll(){
        var id = '';
        var name = '';
        var processedData = '';

        showGreyScreen('loadingVerify');

        $('.warning').hide();
        $('#previewBtn').hide();
        $('#previewEditBtn').show();
        $('#submitBtn').show();

        $.each($('.pId'), function(i){
            id = $(this).val();
            name = $('#title_'+$(this).val()).val();

            $('#p_row_msg_'+$(this).val()).show();
            $('.p_row_content_'+$(this).val()).hide();
            $('#p_row_title_'+$(this).val()).text(name).show();

            //set the catalog id if chosen
            $('#catalog_epid_'+id).val($("input[type='radio'][name='catalog_epid_"+id+"']:checked").val());

            processedData = $(".openbayData_"+id).serialize();

            $.ajax({
                url: 'index.php?route=openbay/openbay/verifyBulk&token=<?php echo $token; ?>&i='+id,
                type: 'POST',
                dataType: 'json',
                data: processedData,
                beforeSend: function(){ addCount(); },
                success: function(data) {
                    if(data.ack != 'Failure'){

                        var msgHtml = '';
                        var feeTot = '';
                        var currencyCode = '';

                        if(document.location.protocol == 'https:') {
                            $('#p_row_buttons_'+data.i).prepend('<a class="button p_row_buttons_prev" target="_BLANK" href="'+data.preview+'"><?php echo $lang_preview; ?></a>');
                        } else {
                            var prevHtml = "previewListing('"+data.preview+"')";
                            $('#p_row_buttons_'+data.i).prepend('<a class="button p_row_buttons_prev" onclick="'+prevHtml+'"><?php echo $lang_preview; ?></a>');
                        }

                        if(data.errors){
                            $.each(data.errors, function(k,v){
                                msgHtml += '<div class="attention" style="margin:5px;">'+v+'</div>';
                            });
                        }

                        $.each(data.fees, function(key, val){
                            if(val.Fee != 0.0 && val.Name != 'ListingFee'){
                                feeTot = feeTot + parseFloat(val.Fee);
                            }
                            currencyCode = val.Cur;
                        });

                        msgHtml += '<div class="success" style="margin:5px;">Total fees: '+currencyCode+' '+feeTot+'</div>';

                        $('#p_msg_'+data.i).html(msgHtml);
                    }else{
                        var errorHtml = '';

                        $.each(data.errors, function(k,v){
                            errorHtml += '<div class="warning" style="margin:5px;">'+v+'</div>';
                        });

                        $('#p_msg_'+data.i).html(errorHtml);
                    }
                    removeCount();
                },
                failure: function(){
                    removeCount();
                    alert('<?php echo $lang_error_reverify; ?>');
                },
                error: function(){
                    removeCount();
                    alert('<?php echo $lang_error_reverify; ?>');
                }
            });
        });
    }

    function submitAll() {
      var confirm_box = confirm('<?php echo $lang_ajax_confirm_listing; ?>');
      if (confirm_box) {
        var id = '';
        var name = '';
        var processedData = '';

        showGreyScreen('loadingVerify');

        $('.warning').hide();
        $('.attention').hide();
        $('#previewBtn').hide();
        $('#previewEditBtn').hide();
        $('#submitBtn').hide();
        $('.p_row_buttons_prev').remove();

        $.each($('.pId'), function (i) {
          id = $(this).val();
          name = $('#title_' + $(this).val()).val();

          $('#p_row_msg_' + $(this).val()).show();
          $('.p_row_content_' + $(this).val()).hide();
          $('#p_row_title_' + $(this).val()).text(name).show();

          $.ajax({
            url: 'index.php?route=openbay/openbay/listItemBulk&token=<?php echo $token; ?>&i=' + id,
            type: 'POST',
            dataType: 'json',
            data: $(".openbayData_" + id).serialize(),
            beforeSend: function () {
              addCount();
            },
            success: function (data) {
              if (data.ack != 'Failure') {
                var prevHtml = "previewListing('" + data.preview + "')";
                var msgHtml = '';
                var feeTot = '';
                var currencyCode = '';

                if (data.errors) {
                  $.each(data.errors, function (k, v) {
                    msgHtml += '<div class="attention" style="margin:5px;">' + v + '</div>';
                  });
                }

                $.each(data.fees, function (key, val) {
                  if (val.Fee != 0.0 && val.Name != 'ListingFee') {
                    feeTot = feeTot + parseFloat(val.Fee);
                  }
                  currencyCode = val.Cur;
                });

                $('#p_row_buttons_' + data.i).prepend('<a class="button p_row_buttons_view" href="<?php echo $listing_link; ?>' + data.itemid + '" target="_BLANK"><?php echo $lang_view; ?></a>');

                msgHtml += '<div class="success" style="margin:5px;"><?php echo $lang_listed; ?>' + data.itemid + '</div>';

                $('#p_msg_' + data.i).html(msgHtml);
              } else {
                var errorHtml = '';

                $.each(data.errors, function (k, v) {
                  errorHtml += '<div class="warning" style="margin:5px;">' + v + '</div>';
                });

                $('#p_msg_' + data.i).html(errorHtml);
              }
              removeCount();
            },
            failure: function () {
              removeCount();
            },
            error: function () {
              removeCount();
            }
          });
        });

      }
    }

    function previewListing(url) {
      showGreyScreen('previewPage');
      $('#previewContentIframe').attr('src', url);
    }

    function showFeatures(id) {
      showGreyScreen('featurePage_' + id);
    }

    function showCatalog(id) {
      showGreyScreen('catalogPage_' + id);
    }

    function genericProfileChange(id) {
      modifyPrices(id);
    }

    function identifierNotRequired(id) {
      var not_required_text = "<?php echo $setting['product_details']['product_identifier_unavailable_text']; ?>";

      if ($('#identifier_not_required_' + id + ':checked').length == 1) {
        if ($('#identifier_ean_required_' + id).val() == 1) {
          $('#identifier_ean_' + id).val(not_required_text);
        }
        if ($('#identifier_isbn_required_' + id).val() == 1) {
          $('#identifier_isbn_' + id).val(not_required_text);
        }
        if ($('#identifier_upc_required_' + id).val() == 1) {
          $('#identifier_upc_' + id).val(not_required_text);
        }
      } else {
        if ($('#identifier_ean_required_' + id).val() == 1) {
          $('#identifier_ean_' + id).val($('#identifier_ean_original_' + id).val());
        }
        if ($('#identifier_isbn_required_' + id).val() == 1) {
          $('#identifier_isbn_' + id).val($('#identifier_isbn_original_' + id).val());
        }
        if ($('#identifier_upc_required_' + id).val() == 1) {
          $('#identifier_upc_' + id).val($('#identifier_upc_original_' + id).val());
        }
      }
    }
</script>

<?php echo $footer; ?>