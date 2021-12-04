<div id="content" class="clearfix">
    <div class="contentwrapper"><!--Content wrapper-->
        <div class="heading">
            <h3>入金状況検索</h3>
            <div class="search_open">
                <a id="opener">+ 開く</a>
            </div>
        </div><!-- End .heading-->
        <form action="<?= $urlSearch ?>" method="get" id="frmlistpayment" >
            <input type="hidden" name="<?= REQUEST_PARAM_PAGE_ID ?>" value="<?= PageIdConstants::PAYMENT ?>" />
            <input type="hidden" name="<?= REQUEST_PARAM_ACTION_METHOD ?>" value="search" />
            <input type="hidden" name="current_page" value="<?= $currentPage ?>" />
            <input type="hidden" id="sort_condition" name="sort_condition" value="<?= $viewState->get("sort_condition") ?>" />
            <div class="content_border">
                <table class="search_form_table">
                    <tbody><tr>
                            <th>
                                入金ステータス
                            </th>
                            <td>
                                <?= HtmlUtil::checkBoxs("prj_status_payment[]", AppConfig::$STATUS_PAYMENT, $viewState->get("prj_status_payment")) ?>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                支払い方法
                            </th>
                            <td>
                                <?= HtmlUtil::checkBoxs("prj_pay_method[]", AppConfig::$METHOD_PAYMENT, $viewState->get("prj_pay_method")); ?>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                入金予定日
                            </th>
                            <td>
                                <div id="keiyakudate_to_id" class="keiyakudate_toDate" style="display: inline;">
                                    <?= HtmlUtil::CalendarInput("prj_billing_date_from", $viewState->get("prj_billing_date_from")) ?>
                                    ～
                                    <?= HtmlUtil::CalendarInput("prj_billing_date_to", $viewState->get("prj_billing_date_to")) ?>
                                    <span id="prj_billing_date_from_msg"></span>
                                    <span id="prj_billing_date_to_msg"></span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                お客様氏名
                            </th>
                            <td><input type="text" name="prj_cust_name" value="<?= $viewState->get("prj_cust_name") ?>" id=""></td>
                        </tr>
                        <tr>
                            <th>
                                お客様住所
                            </th>
                            <td>
                                <?= HtmlUtil::dropList("prj_cust_prefectures", AppConfig::$PREFECTURE, $viewState->get("prj_cust_prefectures")) ?>
                                <input type="text" name="prj_cust_address_full" value="<?= $viewState->get("prj_cust_address_full") ?>" id=""/>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                お客様電話番号
                            </th>
                            <td><input type="text" name="prj_cust_phone_num" value="<?= $viewState->get("prj_cust_phone_num") ?>" id=""></td>
                        </tr>
                        <tr>
                            <th>
                                担当社員ID
                            </th>
                            <td><input type="text" name="prj_staff_id" value="<?= $viewState->get("prj_staff_id") ?>" id="prj_staff_id"></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text_center"><input type="submit" value="検索"></td>
                        </tr>
                    </tbody></table>
            </div>      
            <div class="row-fluid">
                <div class="span12">
                    <div class="box gradient hover">
                        <?= HtmlUtil::paggingHeader($totalRow, "frmlistpayment", $pageSize, 2) ?>
                        <div class="content noPad clearfix" id="DataArea">
                            <?= HtmlUtil::paggingFooter($currentPage, $pageSize, $totalRow, "frmlistpayment", 3) ?>
                            <table id="DnDTable" cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered table-condensed" width="100%">
                                <thead>
                                    <tr>
                                        <th style="white-space:nowrap;">お客様名</th>
                                        <th style="white-space:nowrap;">住所</th>
                                        <th style="white-space:nowrap;">担当者</th>
                                        <th style="white-space:nowrap;">入金ステータス</th>
                                        <th style="white-space:nowrap;">支払い方法</th>
                                        <th style="white-space:nowrap;">更新年月日</th>
                                        <th style="white-space:nowrap;">登録者</th>
                                        <th style="white-space:nowrap;">編集</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($lSprjInfo != NULL) {
                                        ?>
                                        <?php foreach ($lSprjInfo as $ds) : ?>
                                            <?php 
                                                $payment_status = ArrayUtil::StringToArray($ds['payment_status']);
                                                $cust_prefectures = AppConfig::$PREFECTURE[$ds['prj_cust_prefectures']];
                                            ?>
                                            <tr id="1">
                                                <td><?= $ds['prj_cust_name'] ?></td>
                                                <td><?= $ds['prj_cust_pos_code'].' '.$cust_prefectures.' '.$ds['prj_cust_city'].' '.$ds['prj_cust_address'].' '. $ds['prj_cust_mansion_info']?></td>
                                                <td><?= str_replace(',', '、', $ds['staff_name_prj']) ?></td>
                                                <td>
                                                    <?php   for ($i=0, $count = count($payment_status); $i < $count; $i++) { 
                                                        $sep = '';
                                                        if($i < $count-1)
                                                            $sep = '、';
                                                    ?>
                                                    <span <?= $payment_status[$i] == 2 ? 'style="color:red"':''?>>
                                                        <?=AppConfig::$STATUS_PAYMENT[$payment_status[$i]].$sep;?> 
                                                    </span>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <?=AppConfig::$METHOD_PAYMENT[$ds['prj_pay_method']];?>  
                                                </td>
                                                <td><?= $ds['updated_time'] ?></td>
                                                <td><?= $ds['userCreated'] ?></td>
                                                <td style="text-align:center;"><a type="button" class="btn-success btn" style="min-width: 30px" href="<?=UrlUtil::url($urlEdit, array("edit_prj_id"=>$ds["prj_id"]))?>">編集</a>

                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                        <?php
                                    }
                                    ?>

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th style="white-space:nowrap;">お客様名</th>
                                        <th style="white-space:nowrap;">住所</th>
                                        <th style="white-space:nowrap;">担当者</th>
                                        <th style="white-space:nowrap;">入金ステータス</th>
                                        <th style="white-space:nowrap;">支払い方法</th>
                                        <th style="white-space:nowrap;">更新年月日</th>
                                        <th style="white-space:nowrap;">登録者</th>
                                        <th style="white-space:nowrap;">編集/削除</th>
                                    </tr>
                                </tfoot>
                            </table><br/>
                            <?= HtmlUtil::paggingFooter($currentPage, $pageSize, $totalRow, "frmlistpayment", 3) ?>
                        </div>
                    </div><!-- End .box -->
                </div><!-- End .span12 -->
            </div><!-- End .row-fluid -->
            <!-- Page end here -->
        </form>    
    </div><!-- End contentwrapper -->
</div>