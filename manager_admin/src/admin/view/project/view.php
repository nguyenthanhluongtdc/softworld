<div id="content" class="clearfix">
    <div class="contentwrapper">
        <!--Content wrapper-->
        <div class="heading">
            <h3>案件検索</h3>
            <div class="search_open">
                <a id="opener">+ 開く</a>
            </div>
        </div>
        <!-- End .heading-->
        <form method="get" action="<?= $urlSearch ?>" id="frmListProject">
            <div class="content_border" style="display: none;">
                <input type="hidden" name="<?= REQUEST_PARAM_PAGE_ID ?>" value="<?= PageIdConstants::PROJECT ?>" />
                <input type="hidden" name="<?= REQUEST_PARAM_ACTION_METHOD ?>" value="search" />
                <input type="hidden" name="current_page" value="<?= $currentPage ?>" />
                <input type="hidden" id="sort_condition" name="sort_condition" value="<?= $viewState->get("sort_condition") ?>" />
                <?php include_once('_search.php') ?>
            </div>
            <!-- Build page from here: Usual with <div class="row-fluid"></div> -->
            <div class="row-fluid">
                <div class="span12">
                    <ul id="show-error-messages" class="header-error-messages updatemessage"></ul>
                    <div class="box gradient">
                        
                        <?= HtmlUtil::paggingHeader($totalRow, "frmListProject", $pageSize, 2) ?>
                        <div class="content noPad clearfix" id="DataArea">
                            <?= HtmlUtil::paggingFooter($currentPage, $pageSize, $totalRow, 'frmListProject', $paggingStype = 3) ?>
                            <table id="DnDTable" cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered table-condensed" width="100%">
                                <thead>
                                    <tr>
                                         <th style="white-space:nowrap;">案件ID</th>
                                        <th style="white-space:nowrap;">お客様名</th>
                                        <th style="white-space:nowrap;">住所</th>
                                        <th style="white-space:nowrap;">担当者</th>
                                        <th style="white-space:nowrap;">ステータス</th>
                                        <th style="white-space:nowrap;">更新年月日</th>
                                        <th style="white-space:nowrap;">登録者</th>
                                        <th style="white-space:nowrap;width: 120px;">編集/削除</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($lProject)) {
                                        $i = 1;
                                        foreach ($lProject as $value) {
                                            ?> 
                                            <tr id="1">
                                                <td style="text-align: center"><?=$value['prj_id']?></td>
                                                <td><?= $value['prj_cust_name'] ?></td>
        <?php $prj_cust_prefectures = AppConfig::$PREFECTURE[$value['prj_cust_prefectures']] ?>
                                                <td><?= $value['prj_cust_pos_code'] . ' ' . $prj_cust_prefectures . ' ' . $value['prj_cust_city'] . ' ' . $value['prj_cust_address'] . ' ' . $value['prj_cust_mansion_info'] ?></td>
                                                <td><?= str_replace(',', '、', $value['inChangeName']) ?></td>
                                                <td><?= AppConfig::$PROJECT_STATUS[$value['prj_status']] ?></td>
                                                <td><?= DateUtil::dateFormat($value['updated_time'], 'Y-m-d H:i:s', 'Y/m/d H:i') ?></td>
                                                <td><?= $value['userCreated'] ?></td>
                                                <td style="text-align:center;">
                                                    <a style="text-decoration:none" href="<?= UrlUtil::url($urlEdit, array("edit_prj_id" => $value["prj_id"])) ?>"  class="btn-success btn"/>編集</a>
                                                    <input  type="button" 
                                                            submit-action = "<?= $urlDelete ?>"
                                                            submit-method = "post"
                                                            submit-data='{"redirect":"<?= UrlUtil::getCurrentUrl() ?>","delete_prj_id":<?= $value["prj_id"] ?>}' 
                                                            value="削除" 
                                                            class="btn-danger btn submit-form" 
                                                            confirm-msg="<?= MessageConstants::COM_CONFIRM_DELETE ?>"/>
                                                </td>
                                            </tr>     
                                            <?php
                                            ++$i;
                                        }
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th style="white-space:nowrap;">案件ID</th>
                                        <th style="white-space:nowrap;">お客様名</th>
                                        <th style="white-space:nowrap;">住所</th>
                                        <th style="white-space:nowrap;">担当者</th>
                                        <th style="white-space:nowrap;">ステータス</th>
                                        <th style="white-space:nowrap;">更新年月日</th>
                                        <th style="white-space:nowrap;">登録者</th>
                                        <th style="white-space:nowrap;">編集/削除</th>
                                    </tr>
                                </tfoot>
                            </table>
                            <br>
<?= HtmlUtil::paggingFooter($currentPage, $pageSize, $totalRow, 'frmListProject', $paggingStype = 3) ?>
                        </div>
                    </div>
                    <!-- End .box -->
                </div>
                <!-- End .span12 -->
            </div>
            <!-- End .row-fluid -->
            <!-- Page end here -->
    </div>
    <!-- End contentwrapper -->
</div>