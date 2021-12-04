<div id="content" class="clearfix">
<div class="contentwrapper">
<!--Content wrapper-->
<div class="heading">
<h3>歩合集計</h3>
</div>
<!-- End .heading-->
<div class="content_border" id="disp_block">
</div>
<!-- Build page from here: Usual with <div class="row-fluid"></div> -->
<div class="row-fluid">
<div class="span12">
<div class="box gradient">
    <?php if (isset($data1) && $flat == 1): ?>   
        <?php include_once('preview1.php') ?>
    <?php endif; ?>
    <?php if (isset($data2) && $flat == 2) : ?>
        <?php include_once('preview2.php') ?>
    <?php endif; ?>
</div>
<!-- End .box -->
</div>
<!-- End .span12 -->
</div>
<!-- Page end here -->
</div>
<!-- End contentwrapper -->
</div>