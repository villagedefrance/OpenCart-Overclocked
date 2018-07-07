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
      <h1><img src="view/image/category.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">
        <a onclick="location='<?php echo $refresh; ?>';" class="button ripple"><i class="fa fa-refresh"></i> &nbsp; <?php echo $button_refresh; ?></a>
        <a onclick="location='<?php echo $close; ?>';" class="button-cancel ripple"><?php echo $button_close; ?></a>
      </div>
    </div>
    <div class="content-body">
      <?php if ($success_text) { ?>
        <div class="success"><?php echo $success_text; ?></div>
      <?php } ?>
      <?php if ($success_xml) { ?>
        <div class="success"><?php echo $success_xml; ?></div>
      <?php } ?>
      <?php if ($success_gzip) { ?>
        <div class="success"><?php echo $success_gzip; ?></div>
      <?php } ?>
      <form action="<?php echo $sitemap; ?>" method="post" enctype="multipart/form-data" id="form" name="generator">
      <?php if (!$sitemaptext || !$sitemapxml) { ?>
        <div class="tooltip" style="margin:5px 0 0 0;"><?php echo $text_create; ?></div>
      <?php } ?>
      <h2><?php echo $text_sitemaps; ?></h2>
      <div class="toolbox">
        <table class="tool">
          <tr>
            <th align="left"><?php echo $text_head_type; ?></th>
            <th align="left"><?php echo $text_head_name; ?></th>
            <th align="left"><?php echo $text_head_size; ?></th>
            <th align="left"><?php echo $text_head_date; ?></th>
            <th align="left"><?php echo $text_head_action; ?></th>
          </tr>
          <?php if ($sitemaptext) { ?>
            <tr>
              <td><?php echo $text_text; ?></td>
              <td><?php echo $text_nametext; ?></td>
              <td><?php echo $text_sizetext; ?></td>
              <td><?php echo $text_datetext; ?></td>
              <td>
                <a onclick="GenText();" class="button-save ripple"><?php echo $generate; ?></a> &nbsp; 
                <a onclick="LoadText();" class="button-form ripple"><?php echo $download; ?></a> &nbsp; 
                <a onclick="window.open('<?php echo $checktext; ?>');" title="" class="button-repair ripple"><?php echo $button_check; ?></a>
              </td>
            </tr>
          <?php } else { ?>
            <tr>
              <td><b><?php echo $text_text; ?></b></td>
              <td colspan="3"><img src="view/image/warning.png" alt="" /> &nbsp; <?php echo $text_notext; ?></td>
              <td><a onclick="GenText();" class="button-save ripple"><?php echo $generate; ?></a></td>
            </tr>
          <?php } ?>
          <?php if ($sitemapxml) { ?>
            <tr>
              <td><?php echo $text_xml; ?></td>
              <td><?php echo $text_namexml; ?></td>
              <td><?php echo $text_sizexml; ?></td>
              <td><?php echo $text_datexml; ?></td>
              <td>
                <a onclick="GenXml();" class="button-save ripple"><?php echo $generate; ?></a> &nbsp; 
                <a onclick="LoadXml();" class="button-form ripple"><?php echo $download; ?></a>
              </td>
            </tr>
          <?php } else { ?>
            <tr>
              <td><b><?php echo $text_xml; ?></b></td>
              <td colspan="3"><img src="view/image/warning.png" alt="" /> &nbsp; <?php echo $text_noxml; ?></td>
              <td><a onclick="GenXml();" class="button-save ripple"><?php echo $generate; ?></a></td>
            </tr>
          <?php } ?>
          <?php if ($sitemapxml) { ?>
            <?php if ($sitemapgzip) { ?>
              <tr>
                <td><?php echo $text_gzip; ?></td>
                <td><?php echo $text_namegzip; ?></td>
                <td><?php echo $text_sizegzip; ?></td>
                <td><?php echo $text_dategzip; ?></td>
                <td>
                  <a onclick="GenGzip();" class="button-save ripple"><?php echo $generate; ?></a> &nbsp; 
                  <a onclick="LoadGzip();" class="button-form ripple"><?php echo $download; ?></a>
                </td>
              </tr>
            <?php } else { ?>
              <tr>
                <td><b><?php echo $text_gzip; ?></b></td>
                <td colspan="3"><img src="view/image/warning.png" alt="" /> &nbsp; <?php echo $text_nogzip; ?></td>
                <td><a onclick="GenGzip();" class="button-save ripple"><?php echo $generate; ?></a></td>
              </tr>
            <?php } ?>
          <?php } else { ?>
            <tr>
              <td><b><?php echo $text_gzip; ?></b></td>
              <td colspan="3"><img src="view/image/warning.png" alt="" /> &nbsp; <?php echo $text_noxml; ?></td>
              <td><a onclick="GenXml();" class="button-save ripple"><?php echo $generate; ?></a></td>
            </tr>
          <?php } ?>
        </table>
      </div>
      <?php if ($sitemapxml) { ?>
        <h2><?php echo $text_submit; ?></h2>
        <div class="toolbox">
          <table class="tool">
            <tr>
              <td>
                <a onclick="window.open('<?php echo $googleweb; ?>');" title="Google Webmaster Tools"><img src="view/image/engines/google-web.gif" alt="Google" /></a> &nbsp;
                <a onclick="window.open('<?php echo $bingweb; ?>');" title="Bing Webmaster Tools"><img src="view/image/engines/bing-web.gif" alt="Bing" /></a> &nbsp;
                <a onclick="window.open('<?php echo $yandexweb; ?>');" title="Yandex Webmaster Tools"><img src="view/image/engines/yandex-web.gif" alt="Yandex" /></a> &nbsp;
                <a onclick="window.open('<?php echo $baiduweb; ?>');" title="Baidu Webmaster Tools"><img src="view/image/engines/baidu-web.gif" alt="Baidu" /></a> &nbsp;
              </td>
            </tr>
            <tr>
              <td style="padding:10px;"><?php echo $text_publish; ?></td>
            </tr>
          </table>
        </div>
      <?php } ?>
      <input type="hidden" name="buttonForm" value="" />
    </form>
    </div>
  </div>
</div>

<script type="text/javascript"><!--
function GenText() {document.generator.buttonForm.value='gentext'; $('#form').submit();}
function GenXml() {document.generator.buttonForm.value='genxml'; $('#form').submit();}
function GenGzip() {document.generator.buttonForm.value='gengzip'; $('#form').submit();}

function LoadText() {document.generator.buttonForm.value='loadtext'; $('#form').submit();}
function LoadXml() {document.generator.buttonForm.value='loadxml'; $('#form').submit();}
function LoadGzip() {document.generator.buttonForm.value='loadgzip'; $('#form').submit();}
//--></script>

<?php echo $footer; ?>