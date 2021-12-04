<div id="content" class="clearfix">
    <div class="contentwrapper"><!--Content wrapper-->
        <div class="heading">
            <h3>定期点検リスト</h3>
        </div><!-- End .heading-->
        完工日から1,5,9,13年を迎える案件のリストです。
        <div class="row-fluid">
            <div class="span12">
                <div class="box gradient hover">
                    <div class="title">
                        <table style="width: 100%;">
                            <tbody><tr>
                                    <td style="width: 33%;text-align: left;">  
                                        <a href="<?= $urlSearch ?>&year=<?= $year ?>&month=<?= $month ?>&type=preview">&lt;&lt; 前の月へ</a>
                                    </td>
                                    <td style="width: 33%;text-align: center;">
                                        <h4>
                                            <?php
                                               echo  $year.'年'.$month.'月';
                                            ?>
                                        </h4>
                                    </td>
                                    <td style="width: 33%;text-align: right;">  
                                        <a href="<?= $urlSearch ?>&year=<?= $year ?>&month=<?= $month ?>&type=next">
                                            次の月へ &gt;&gt;
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="content noPad clearfix" id="DataArea">
                        <table id="DnDTable" cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered table-condensed" width="100%">
                            <thead>
                                <tr>
                                    <th style="white-space:nowrap;">1年</th>
                                    <th style="white-space:nowrap;">完工日</th>
                                    <th style="white-space:nowrap;">5年</th>
                                    <th style="white-space:nowrap;">完工日</th>
                                    <th style="white-space:nowrap;">9年</th>
                                    <th style="white-space:nowrap;">完工日</th>
                                    <th style="white-space:nowrap;">13年</th>
                                    <th style="white-space:nowrap;">完工日</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php for ($i = 0; $i < $max; $i++) :?>
                                        <tr id="<?=$i?>">
                                            <td>
                                                <a href="<?=UrlUtil::url($urlEdit, array("edit_prj_id"=>$lsKanko_1[$i]['prj_id']))?>"><?=$lsKanko_1[$i]['prj_cust_name']?></a>
                                            </td>
                                        <td><?= $lsKanko_1[$i]['prj_kanko_bi'] ?></td>
                                        <td>
                                            <a href="<?=UrlUtil::url($urlEdit, array("edit_prj_id"=>$lsKanko_5[$i]['prj_id']))?>"><?=$lsKanko_5[$i]['prj_cust_name']?></a>
                                        </td>
                                        <td><?= $lsKanko_5[$i]['prj_kanko_bi'] ?></td>
                                        <td>
                                            <a href="<?=UrlUtil::url($urlEdit, array("edit_prj_id"=>$lsKanko_9[$i]['prj_id']))?>"><?=$lsKanko_9[$i]['prj_cust_name']?></a>
                                        </td>
                                        <td><?= $lsKanko_9[$i]['prj_kanko_bi'] ?> </td>
                                        <td>
                                            <a href="<?=UrlUtil::url($urlEdit, array("edit_prj_id"=>$lsKanko_13[$i]['prj_id']))?>"><?=$lsKanko_13[$i]['prj_cust_name']?></a>
                                        </td>
                                        <td><?= $lsKanko_13[$i]['prj_kanko_bi'] ?> </td>
                                    </tr>
                                  <?php endfor;?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th style="white-space:nowrap;">1年</th>
                                    <th style="white-space:nowrap;">完工日</th>
                                    <th style="white-space:nowrap;">5年</th>
                                    <th style="white-space:nowrap;">完工日</th>
                                    <th style="white-space:nowrap;">9年</th>
                                    <th style="white-space:nowrap;">完工日</th>
                                    <th style="white-space:nowrap;">13年</th>
                                    <th style="white-space:nowrap;">完工日</th>
                                </tr>
                            </tfoot>
                        </table><br>
                        <div class="center">
                        </div>
                    </div>
                </div><!-- End .box -->
            </div><!-- End .span12 -->
        </div><!-- End .row-fluid -->
        <!-- Page end here -->
    </div><!-- End contentwrapper -->
</div>