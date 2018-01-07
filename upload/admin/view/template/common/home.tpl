<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
  <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
  <?php } ?>
  </div>
  <?php if ($error_image) { ?>
    <div class="warning"><?php echo $error_image; ?></div>
  <?php } ?>
  <?php if ($error_image_cache) { ?>
    <div class="warning"><?php echo $error_image_cache; ?></div>
  <?php } ?>
  <?php if ($error_cache) { ?>
    <div class="warning"><?php echo $error_cache; ?></div>
  <?php } ?>
  <?php if ($error_download) { ?>
    <div class="warning"><?php echo $error_download; ?></div>
  <?php } ?>
  <?php if ($error_upload) { ?>
    <div class="warning"><?php echo $error_upload; ?></div>
  <?php } ?>
  <?php if ($error_logs) { ?>
    <div class="warning"><?php echo $error_logs; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/home.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="event">
        <?php if ($mail_log_status) { ?>
          <a href="<?php echo $open_mail_log; ?>" title=""><img src="view/image/email-on.png" alt="" /></a>
        <?php } else { ?>
          <a href="<?php echo $open_mail_log; ?>" title=""><img src="view/image/email-off.png" alt="" /></a>
        <?php } ?>
        <?php if ($quote_log_status) { ?>
          <a href="<?php echo $open_quote_log; ?>" title=""><img src="view/image/quote-on.png" alt="" /></a>
        <?php } else { ?>
          <a href="<?php echo $open_quote_log; ?>" title=""><img src="view/image/quote-off.png" alt="" /></a>
        <?php } ?>
        <?php if ($error_log_status) { ?>
          <a href="<?php echo $open_error_log; ?>" title=""><img src="view/image/bell-on.png" alt="" /></a>
        <?php } else { ?>
          <a href="<?php echo $open_error_log; ?>" title=""><img src="view/image/bell-off.png" alt="" /></a>
        <?php } ?>
        <?php if ($seo_url_status && $seo_url_ratio) { ?>
          <?php if ($seo_url_ratio == 3) { ?>
            <a href="<?php echo $open_seo_url; ?>" title=""><img src="view/image/seo-red.png" alt="" /></a>
          <?php } elseif ($seo_url_ratio == 2) { ?>
            <a href="<?php echo $open_seo_url; ?>" title=""><img src="view/image/seo-yellow.png" alt="" /></a>
          <?php } else { ?>
            <a href="<?php echo $open_seo_url; ?>" title=""><img src="view/image/seo-green.png" alt="" /></a>
          <?php } ?>
        <?php } ?>
      </div>
    </div>
    <div class="content-body">
      <div class="overview">
        <div class="dashboard-heading"><?php echo $text_overview; ?></div>
        <div class="dashboard-content">
          <table class="list" style="margin-bottom:9px;">
            <tr>
              <td class="left"><?php echo $text_total_sale; ?></td>
              <td class="right"><?php echo $total_sale; ?></td>
            </tr>
            <tr>
              <td class="left"><?php echo $text_total_sale_year; ?></td>
              <td class="right"><?php echo $total_sale_year; ?></td>
            </tr>
            <tr>
              <td class="left"><?php echo $text_total_sale_month; ?></td>
              <td class="right"><?php echo $total_sale_month; ?></td>
            </tr>
          </table>
          <table class="list" style="margin-bottom:9px;">
            <tr>
              <td class="left"><?php echo $text_total_order; ?>
              <?php if ($total_pending_orders > 0) { ?>
                <a href="<?php echo $view_orders; ?>" title=""><span class="color" style="background-color:#F2B155; color:#FFF;"><?php echo $total_pending_orders; ?></span></a>
              <?php } else { ?>
                <a href="<?php echo $view_orders; ?>" title=""><span class="color" style="background-color:#AAA; color:#FFF;">&gt;</span></a>
              <?php } ?>
              </td>
              <td class="right"><?php echo $total_order; ?></td>
            </tr>
            <tr>
              <td class="left"><?php echo $text_total_customer; ?>
              <?php if ($total_customer_approval > 0) { ?>
                <a href="<?php echo $view_customers; ?>" title=""><span class="color" style="background-color:#DE5954; color:#FFF;"><?php echo $total_customer_approval; ?></span></a>
              <?php } else { ?>
                <a href="<?php echo $view_customers; ?>" title=""><span class="color" style="background-color:#AAA; color:#FFF;">&gt;</span></a>
              <?php } ?>
              </td>
              <td class="right"><?php echo $total_customer; ?></td>
            </tr>
            <tr>
              <td class="left"><?php echo $text_total_review; ?>
              <?php if ($total_review_approval > 0) { ?>
                <a href="<?php echo $view_reviews; ?>" title=""><span class="color" style="background-color:#DE5954; color:#FFF;"><?php echo $total_review_approval; ?></span></a>
              <?php } else { ?>
                <a href="<?php echo $view_reviews; ?>" title=""><span class="color" style="background-color:#AAA; color:#FFF;">&gt;</span></a>
              <?php } ?>
              </td>
              <td class="right"><?php echo $total_review; ?></td>
            </tr>
            <?php if ($allow_affiliate) { ?>
            <tr>
              <td class="left"><?php echo $text_total_affiliate; ?>
              <?php if ($total_affiliate_approval > 0) { ?>
                <a href="<?php echo $view_affiliates; ?>" title=""><span class="color" style="background-color:#DE5954; color:#FFF;"><?php echo $total_affiliate_approval; ?></span></a>
              <?php } else { ?>
                <a href="<?php echo $view_affiliates; ?>" title=""><span class="color" style="background-color:#AAA; color:#FFF;">&gt;</span></a>
              <?php } ?>
              </td>
              <td class="right"><?php echo $total_affiliate; ?></td>
            </tr>
            <?php } ?>
          </table>
        </div>
      </div>
      <div class="statistic">
        <div class="range"><?php echo $entry_range; ?>
          <select id="range" onchange="getSalesChart(this.value);">
            <option value="day"><?php echo $text_day; ?></option>
            <option value="week"><?php echo $text_week; ?></option>
            <option value="month"><?php echo $text_month; ?></option>
            <option value="year"><?php echo $text_year; ?></option>
          </select>
        </div>
        <div class="dashboard-heading"><?php echo $text_statistics; ?></div>
        <div class="dashboard-content">
          <div id="report" style="width:100%; height:258px;"></div> 
        </div>
      </div>
      <div class="tiles">
        <div class="tile">
          <div class="tile-red">
            <p><span><?php echo $total_order_today; ?></span>
            <a href="<?php echo $view_orders; ?>" title=""><i class="fa fa-shopping-cart"></i><br /><?php echo $text_order_today; ?></a></p>
          </div>
        </div>
        <div class="tile">
          <div class="tile-blue">
            <p><span><?php echo $total_customer_today; ?></span>
            <a href="<?php echo $view_customers; ?>" title=""><i class="fa fa-users"></i><br /><?php echo $text_customer_today; ?></a></p>
          </div>
        </div>
        <div class="tile">
          <div class="tile-yellow">
            <p><span><?php echo $total_sale_today; ?></span>
            <a href="<?php echo $view_sales; ?>" title=""><i class="fa fa-line-chart"></i><br /><?php echo $text_sale_today; ?></a></p>
          </div>
        </div>
        <div class="tile">
          <div class="tile-green">
            <p><span><?php echo $total_online; ?></span>
            <a href="<?php echo $view_online; ?>" title=""><i class="fa fa-feed"></i><br /><?php echo $text_online; ?></a></p>
          </div>
        </div>
      </div>
      <div class="latest">
        <div class="dashboard-heading"><?php echo $text_latest; ?></div>
        <div class="dashboard-content">
        <div id="latest-tabs" class="htabs">
          <a href="#tab-latest-map"><?php echo $tab_map; ?></a>
          <?php if ($orders) { ?>
            <a href="#tab-latest-order"><?php echo $tab_order; ?></a>
          <?php } ?>
          <?php if ($customers) { ?>
            <a href="#tab-latest-customer"><?php echo $tab_customer; ?></a>
          <?php } ?>
          <?php if ($reviews) { ?>
            <a href="#tab-latest-review"><?php echo $tab_review; ?></a>
          <?php } ?>
          <?php if ($affiliates && $allow_affiliate) { ?>
            <a href="#tab-latest-affiliate"><?php echo $tab_affiliate; ?></a>
          <?php } ?>
          <?php if ($returns && $allow_return) { ?>
            <a href="#tab-latest-return"><?php echo $tab_return; ?></a>
          <?php } ?>
          <?php if ($uploads) { ?>
            <a href="#tab-latest-upload"><?php echo $tab_upload; ?></a>
          <?php } ?>
        </div>
        <div id="tab-latest-map" class="htabs-content">
          <div style="width:100%;">
          <?php if ($top_countries) { ?>
            <div  style="width:26%; float:right;">
              <h2><?php echo $text_topcountry; ?> &nbsp; <?php echo (!empty($top_flag)) ? "<img src='" . $top_flag . "' alt='' />" : ''; ?></h2>
              <br /><br />
              <div class="chart">
              <?php foreach ($top_countries as $top_country) { ?>
                <div class="donut-chart fill" data-percent="<?php echo $top_country['amount']; ?>" data-title="<?php echo $top_country['country']; ?> %"></div>
              <?php } ?>
              </div>
            </div>
            <div id="vmap" style="width:72%;"></div>
          <?php } else { ?>
            <div id="vmap" style="width:100%;"></div>
          <?php } ?>
          </div>
        </div>
        <?php if ($orders) { ?>
        <div id="tab-latest-order" class="htabs-content">
          <table class="list">
            <thead>
              <tr>
                <td class="left"><?php echo $column_order; ?></td>
                <td class="left"><?php echo $column_customer; ?></td>
                <td class="left"><?php echo $column_customer_group; ?></td>
                <td class="left" colspan="3"><?php echo $column_conversion; ?></td>
                <td class="left"><?php echo $column_date_added; ?></td>
                <td class="left"><?php echo $column_status; ?></td>
                <td class="left"><?php echo $column_total; ?></td>
                <td class="right"><?php echo $column_action; ?></td>
              </tr>
            </thead>
            <tbody>
            <?php if ($orders) { ?>
              <?php foreach ($orders as $order) { ?>
              <tr>
                <td class="center"><?php echo $order['order_id']; ?></td>
                <td class="left"><?php echo $order['customer']; ?></td>
                <td class="center"><?php echo $order['customer_group']; ?></td>
                <td class="center"><?php echo $order['passed']; ?></td>
                <td class="center"><?php echo $order['missed']; ?></td>
                <td class="center"><?php echo $order['conversion']; ?></td>
                <td class="center"><?php echo $order['date_added']; ?></td>
                <td class="center"><?php echo $order['status']; ?></td>
                <td class="right"><?php echo $order['total']; ?></td>
                <td class="right"><?php foreach ($order['action'] as $action) { ?>
                  <a href="<?php echo $action['href']; ?>" class="button-form"><?php echo $action['text']; ?></a>
                <?php } ?></td>
              </tr>
              <?php } ?>
            <?php } else { ?>
              <tr>
                <td class="center" colspan="10"><?php echo $text_no_results; ?></td>
              </tr>
            <?php } ?>
            </tbody>
          </table>
        </div>
        <?php } ?>
        <?php if ($customers) { ?>
        <div id="tab-latest-customer" class="htabs-content">
          <table class="list">
            <thead>
              <tr>
                <td class="left"><?php echo $column_customer; ?></td>
                <td class="left"><?php echo $column_email; ?></td>
                <td class="left"><?php echo $column_customer_group; ?></td>
                <td class="left"><?php echo $column_approved; ?></td>
                <td class="left"><?php echo $column_status; ?></td>
                <td class="left"><?php echo $column_date_added; ?></td>
                <td class="left"><?php echo $column_orders_passed; ?></td>
                <td class="left"><?php echo $column_orders_missed; ?></td>
                <td class="right"><?php echo $column_action; ?></td>
              </tr>
            </thead>
            <tbody>
            <?php if ($customers) { ?>
              <?php foreach ($customers as $customer) { ?>
              <tr>
                <td class="left"><?php echo $customer['name']; ?><?php if ($show_dob) { ?> (<?php echo $customer['age']; ?>)<?php } ?></td>
                <td class="left"><?php echo $customer['email']; ?></td>
                <td class="center"><?php echo $customer['customer_group']; ?></td>
                <td class="center"><?php echo $customer['approved']; ?></td>
                <?php if ($customer['status'] == 1) { ?>
                  <td class="center"><span class="enabled"><?php echo $text_enabled; ?></span></td>
                <?php } else { ?>
                  <td class="center"><span class="disabled"><?php echo $text_disabled; ?></span></td>
                <?php } ?>
                <td class="center"><?php echo $customer['date_added']; ?></td>
                <td class="center"><?php echo $customer['orders_passed']; ?>
                <?php foreach ($customer['action_passed'] as $action_passed) { ?>
                  <?php if ($customer['orders_passed'] > 0) { ?>
                    <a href="<?php echo $action_passed['href']; ?>" title="<?php echo $action_passed['text']; ?>"><span class="color" style="background-color:#4691D2; color:#FFF;">&gt;</span></a>
                  <?php } else { ?>
                    <a title=""><span class="color" style="background-color:#AAA; color:#FFF;">&gt;</span></a>
                  <?php } ?>
                <?php } ?>
                </td>
                <td class="center"><?php echo $customer['orders_missed']; ?> &nbsp;&nbsp;
                <?php foreach ($customer['action_missed'] as $action_missed) { ?>
                  <?php if ($customer['orders_missed'] > 0) { ?>
                    <a href="<?php echo $action_missed['href']; ?>" title="<?php echo $action_missed['text']; ?>"><span class="color" style="background-color:#4691D2; color:#FFF;">&gt;</span></a>
                  <?php } else { ?>
                    <a title=""><span class="color" style="background-color:#AAA; color:#FFF;">&gt;</span></a>
                  <?php } ?>
                <?php } ?>
                </td>
                <td class="right"><?php foreach ($customer['action'] as $action) { ?>
                  <a href="<?php echo $action['href']; ?>" class="button-form"><?php echo $action['text']; ?></a>
                <?php } ?></td>
              </tr>
              <?php } ?>
            <?php } else { ?>
              <tr>
                <td class="center" colspan="9"><?php echo $text_no_results; ?></td>
              </tr>
            <?php } ?>
            </tbody>
          </table>
        </div>
        <?php } ?>
        <?php if ($reviews) { ?>
        <div id="tab-latest-review" class="htabs-content">
          <table class="list">
            <thead>
              <tr>
                <td class="left"><?php echo $column_product; ?></td>
                <td class="left"><?php echo $column_author; ?></td>
                <td class="left"><?php echo $column_rating; ?></td>
                <td class="left"><?php echo $column_status; ?></td>
                <td class="left"><?php echo $column_date_added; ?></td>
                <td class="left"><?php echo $column_rating_total; ?></td>
                <td class="right"><?php echo $column_action; ?></td>
              </tr>
            </thead>
            <tbody>
            <?php if ($reviews) { ?>
              <?php foreach ($reviews as $review) { ?>
              <tr>
                <td class="left"><?php echo $review['name']; ?></td>
                <td class="left"><?php echo $review['author']; ?></td>
                <td class="center"><img src="view/image/theme-<?php echo $admin_css; ?>/stars-<?php echo $review['rating'] . '.png'; ?>" alt="<?php echo $review['rating']; ?>" style="margin-top:2px;" /></td>
                <?php if ($review['status'] == 1) { ?>
                  <td class="center"><span class="enabled"><?php echo $text_enabled; ?></span></td>
                <?php } else { ?>
                  <td class="center"><span class="disabled"><?php echo $text_disabled; ?></span></td>
                <?php } ?>
                <td class="center"><?php echo $review['date_added']; ?></td>
                <td class="center"><?php echo $review['rating_total']; ?>
                <?php foreach ($review['action_rated'] as $action_rated) { ?>
                  <?php if ($review['rating_total'] > 0) { ?>
                    <a href="<?php echo $action_rated['href']; ?>" title="<?php echo $action_rated['text']; ?>"><span class="color" style="background-color:#4691D2; color:#FFF;">&gt;</span></a>
                  <?php } else { ?>
                    <a title=""><span class="color" style="background-color:#AAA; color:#FFF;">&gt;</span></a>
                  <?php } ?>
                  <?php } ?>
                </td>
                <td class="right"><?php foreach ($review['action'] as $action) { ?>
                  <a href="<?php echo $action['href']; ?>" class="button-form"><?php echo $action['text']; ?></a>
                <?php } ?></td>
              </tr>
              <?php } ?>
            <?php } else { ?>
              <tr>
                <td class="center" colspan="7"><?php echo $text_no_results; ?></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
        </div>
        <?php } ?>
        <?php if ($affiliates && $allow_affiliate) { ?>
        <div id="tab-latest-affiliate" class="htabs-content">
          <table class="list">
            <thead>
              <tr>
                <td class="left"><?php echo $column_affiliate; ?></td>
                <td class="left"><?php echo $column_email; ?></td>
                <td class="left"><?php echo $column_tracking; ?></td>
                <td class="left"><?php echo $column_balance; ?></td>
                <td class="left"><?php echo $column_approved; ?></td>
                <td class="left"><?php echo $column_status; ?></td>
                <td class="left"><?php echo $column_date_added; ?></td>
                <td class="right"><?php echo $column_action; ?></td>
              </tr>
            </thead>
            <tbody>
            <?php if ($affiliates) { ?>
              <?php foreach ($affiliates as $affiliate) { ?>
              <tr>
                <td class="left"><?php echo $affiliate['name']; ?></td>
                <td class="left"><?php echo $affiliate['email']; ?></td>
                <td class="left"><?php echo $affiliate['code']; ?></td>
                <td class="center"><?php echo $affiliate['balance']; ?></td>
                <td class="center"><?php echo $affiliate['approved']; ?></td>
                <?php if ($affiliate['status'] == 1) { ?>
                  <td class="center"><span class="enabled"><?php echo $text_enabled; ?></span></td>
                <?php } else { ?>
                  <td class="center"><span class="disabled"><?php echo $text_disabled; ?></span></td>
                <?php } ?>
                <td class="center"><?php echo $affiliate['date_added']; ?></td>
                <td class="right"><?php foreach ($affiliate['action'] as $action) { ?>
                  <a href="<?php echo $action['href']; ?>" class="button-form"><?php echo $action['text']; ?></a>
                <?php } ?></td>
              </tr>
              <?php } ?>
            <?php } else { ?>
              <tr>
                <td class="center" colspan="8"><?php echo $text_no_results; ?></td>
              </tr>
            <?php } ?>
            </tbody>
          </table>
        </div>
        <?php } ?>
        <?php if ($returns && $allow_return) { ?>
        <div id="tab-latest-return" class="htabs-content">
          <table class="list">
            <thead>
              <tr>
                <td class="left"><?php echo $column_return_id; ?></td>
                <td class="left"><?php echo $column_order; ?></td>
                <td class="left"><?php echo $column_customer; ?></td>
                <td class="left"><?php echo $column_product; ?></td>
                <td class="left"><?php echo $column_status; ?></td>
                <td class="left"><?php echo $column_date_added; ?></td>
                <td class="left"><?php echo $column_return_history; ?></td>
                <td class="right"><?php echo $column_action; ?></td>
              </tr>
            </thead>
            <tbody>
            <?php if ($returns) { ?>
              <?php foreach ($returns as $return) { ?>
              <tr>
                <td class="center"><?php echo $return['return_id']; ?></td>
                <td class="center"><?php echo $return['order_id']; ?></td>
                <td class="left"><?php echo $return['customer']; ?></td>
                <td class="left"><?php echo $return['product']; ?></td>
                <td class="center"><?php echo $return['status']; ?></td>
                <td class="center"><?php echo $return['date_added']; ?></td>
                <td class="center"><?php echo $return['return_history']; ?>
                <?php foreach ($return['action_return'] as $action_return) { ?>
                  <?php if ($return['return_history'] > 0) { ?>
                    <a href="<?php echo $action_return['href']; ?>" title="<?php echo $action_return['text']; ?>"><span class="color" style="background-color:#4691D2; color:#FFF;">&gt;</span></a>
                  <?php } else { ?>
                    <a title=""><span class="color" style="background-color:#AAA; color:#FFF;">&gt;</span></a>
                  <?php } ?>
                <?php } ?>
                </td>
                <td class="right">
                  <?php foreach ($return['action'] as $action) { ?>
                    <a href="<?php echo $action['href']; ?>" class="button-form"><?php echo $action['text']; ?></a>
                  <?php } ?>
                </td>
              </tr>
              <?php } ?>
            <?php } else { ?>
              <tr>
                <td class="center" colspan="8"><?php echo $text_no_results; ?></td>
              </tr>
            <?php } ?>
            </tbody>
          </table>
        </div>
        <?php } ?>
        <?php if ($uploads) { ?>
        <div id="tab-latest-upload" class="htabs-content">
          <table class="list">
            <thead>
              <tr>
                <td class="left"><?php echo $column_upload_id; ?></td>
                <td class="left"><?php echo $column_name; ?></td>
                <td class="left"><?php echo $column_filename; ?></td>
                <td class="left"><?php echo $column_date_added; ?></td>
                <td class="right"><?php echo $column_action; ?></td>
              </tr>
            </thead>
            <tbody>
            <?php if ($uploads) { ?>
              <?php foreach ($uploads as $upload) { ?>
              <tr>
                <td class="center"><?php echo $upload['upload_id']; ?></td>
                <td class="left"><?php echo $upload['name']; ?></td>
                <td class="left"><?php echo $upload['filename']; ?></td>
                <td class="center"><?php echo $upload['date_added']; ?></td>
                <td class="right"><?php foreach ($upload['action'] as $action) { ?>
                  <a href="<?php echo $action['href']; ?>" class="button-form"><?php echo $action['text']; ?></a>
                <?php } ?></td>
              </tr>
              <?php } ?>
            <?php } else { ?>
              <tr>
                <td class="center" colspan="5"><?php echo $text_no_results; ?></td>
              </tr>
            <?php } ?>
            </tbody>
          </table>
        </div>
        <?php } ?>
      </div>
      <div class="tops">
        <div class="tiers">
          <div class="dashboard-heading-left"><?php echo $text_topseller; ?></div>
          <div class="dashboard-content-left">
            <table class="list" style="margin-bottom:10px;">
            <thead>
              <tr>
                <td class="left"><?php echo $column_product; ?></td>
                <td class="left"><img src="view/image/dashboard/top-model.png" alt="" title="" /></td>
                <td class="right"><img src="view/image/dashboard/top-total.png" alt="" title="" /></td>
                <td class="right"><img src="view/image/dashboard/top-price.png" alt="" title="" /></td>
              </tr>
            </thead>
            <tbody>
              <?php if ($sellers) { ?>
                <?php foreach ($sellers as $seller) { ?>
                  <tr>
                    <td class="left"><a href="<?php echo $seller['href']; ?>" title=""><?php echo $seller['name']; ?></a></td>
                    <td class="left"><?php echo $seller['model']; ?></td>
                    <td class="right"><?php echo $seller['quantity']; ?></td>
                    <td class="right"><?php echo $seller['total']; ?></td>
                  </tr>
                <?php } ?>
              <?php } else { ?>
                <tr>
                  <td class="center" colspan="4"><?php echo $text_no_results; ?></td>
                </tr>
              <?php } ?>
            </tbody>
            </table>
          </div>
        </div>
        <div class="tiers">
          <div class="dashboard-heading-middle"><?php echo $text_topview; ?></div>
          <div class="dashboard-content-middle">
            <table class="list" style="margin-bottom:10px;">
            <thead>
              <tr>
                <td class="left"><?php echo $column_product; ?></td>
                <td class="left"><img src="view/image/dashboard/top-model.png" alt="" title="" /></td>
                <td class="right"><img src="view/image/dashboard/top-viewed.png" alt="" title="" /></td>
                <td class="right"><img src="view/image/dashboard/top-percent.png" alt="" title="" /></td>
              </tr>
            </thead>
            <tbody>
              <?php if ($views) { ?>
                <?php foreach ($views as $view) { ?>
                  <tr>
                    <td class="left"><a href="<?php echo $view['href']; ?>" title=""><?php echo $view['name']; ?></a></td>
                    <td class="left"><?php echo $view['model']; ?></td>
                    <td class="right"><?php echo $view['viewed']; ?></td>
                    <td class="right"><?php echo $view['percent']; ?></td>
                  </tr>
                <?php } ?>
              <?php } else { ?>
                <tr>
                  <td class="center" colspan="4"><?php echo $text_no_results; ?></td>
                </tr>
              <?php } ?>
            </tbody>
            </table>
          </div>
        </div>
        <div class="tiers">
          <div class="dashboard-heading-right"><?php echo $text_topcustomer; ?></div>
          <div class="dashboard-content-right">
            <table class="list" style="margin-bottom:10px;">
            <thead>
              <tr>
                <td class="left"><?php echo $column_customer; ?></td>
                <td class="right"><img src="view/image/dashboard/top-order.png" alt="" title="" /></td>
                <td class="right"><img src="view/image/dashboard/top-product.png" alt="" title="" /></td>
                <td class="right"><img src="view/image/dashboard/top-price.png" alt="" title="" /></td>
              </tr>
            </thead>
            <tbody>
              <?php if ($clients) { ?>
                <?php foreach ($clients as $client) { ?>
                  <tr>
                    <td class="left"><a href="<?php echo $client['href']; ?>" title=""><?php echo $client['customer']; ?></a></td>
                    <td class="right"><?php echo $client['orders']; ?></td>
                    <td class="right"><?php echo $client['products']; ?></td>
                    <td class="right"><?php echo $client['total']; ?></td>
                  </tr>
                <?php } ?>
              <?php } else { ?>
                <tr>
                  <td class="center" colspan="4"><?php echo $text_no_results; ?></td>
                </tr>
              <?php } ?>
            </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!--[if IE]>
<script type="text/javascript" src="view/javascript/jquery/flot/excanvas.min.js"></script>
<![endif]-->

<script type="text/javascript"><!--
function getSalesChart(range) {
	$.ajax({
		type: 'get',
		url: 'index.php?route=common/home/chart&token=<?php echo $token; ?>&range=' + range,
		dataType: 'json',
		success: function(json) {
			var option = {
				shadowSize: 0,
				colors: ['#F2B155', '#DE5954', '#4691D2'],
				bars: {
					show: true,
					fill: true,
					lineWidth: 1,
					barColor: '<?php echo $chart_colour; ?>'
				},
				grid: {
					color: '<?php echo $chart_colour; ?>',
					borderColor: '<?php echo $chart_border; ?>',
					backgroundColor: '<?php echo $chart_background; ?>',
					hoverable: true
				},
				points: {
					show: false
				},
				xaxis: {
					show: true,
					color: '<?php echo $chart_colour; ?>',
					font: '<?php echo $chart_colour; ?>',
					tickColor: '<?php echo $chart_border; ?>',
					ticks: json['xaxis']
				},
				yaxis: {
					color: '<?php echo $chart_colour; ?>',
					font: '<?php echo $chart_colour; ?>',
					tickColor: '<?php echo $chart_border; ?>'
				}
			}
			$.plot($('#report'), [json['cart'], json['order'], json['customer']], option);
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
}

jQuery(document).ready(function() {
	getSalesChart($('#range').val());
})(jQuery);
//--></script>

<script type="text/javascript"><!--
$(document).ready(function() {
	$.ajax({
		type: 'get',
		url: 'index.php?route=common/home/map&token=<?php echo $token; ?>',
		dataType: 'json',
		success: function(json) {
			data = [];

			for (i in json) {
				data[i] = json[i]['total'];
			}

			$('#vmap').vectorMap({
				map: 'world_en',
				backgroundColor: '<?php echo $chart_background; ?>',
				borderColor: '<?php echo $chart_border; ?>',
				borderOpacity: 0.25,
				borderWidth: 1,
				color: '#9FD5F1',
				hoverOpacity: 0.7,
				selectedColor: '#666666',
				enableZoom: true,
				showTooltip: true,
				values: data,
				normalizeFunction: 'polynomial',
				onLabelShow: function(event, label, code) {
					if (json[code]) {
						label.html('<strong>' + label.text() + '</strong><br />' + json[code]['orders'] + '  ' + json[code]['total'] + '<br />' + json[code]['sales'] + '  ' + json[code]['amount']);
					}
				}
			});
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});
//--></script>

<script type="text/javascript"><!--
$(document).ready(function() {
	$('.donut-chart').cssCharts({type:"donut"}).trigger('show-donut-chart');
});
//--></script>

<script type="text/javascript"><!--
$(document).ready(function() {
	$('#latest-tabs a').tabs();
});
//--></script>

<?php echo $footer; ?>