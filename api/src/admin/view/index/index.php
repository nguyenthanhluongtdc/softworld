<div class="clearfix" id="content">
    <div class="contentwrapper">
        <!--Content wrapper-->
        <div class="heading">
            <h3>管理画面トップ 案件変更履歴 未承認一覧</h3>
            <div class="resBtnSearch">
                <a href="#"><span class="icon16 icomoon-icon-search-3"></span></a>
            </div>
        </div>
        <!-- End .heading-->
        承認をしなければいけない案件変更届があります。下記から変更内容を確認して、承認を行って下さい。
        <form method="get" id="frmListPrjInfos">
            <input type="hidden" name="<?=REQUEST_PARAM_PAGE_ID?>" value="<?= PageIdConstants::INDEX ?>" />
            <input type="hidden" name="<?=REQUEST_PARAM_ACTION_METHOD?>" value="search" />
            <input type="hidden" name="current_page" value="<?=$currentPage?>" />
            <input type="hidden" id="sort_condition" name="sort_condition" value="<?=$viewState->get("sort_condition") ?>" />
            <div class="row-fluid">
                <div class="span12">
                    <div class="box gradient">
                        <?=HtmlUtil::paggingHeader($totalRow, "frmListPrjInfos", $pageSize, 2)?>
                        <?php if (isset($lstprjinfos)) { ?>
                        <div id="DataArea" class="content noPad clearfix">
                            <?=HtmlUtil::paggingFooter($currentPage, $pageSize, $totalRow, 'frmListPrjInfos', $paggingStype = 3)?>
                            <table width="100%" cellspacing="0" cellpadding="0" border="0" class="table table-striped table-bordered table-condensed" id="DnDTable">
                                <thead>
                                    <tr>
                                        <th style="white-space:nowrap;width: 100px;">お客様名</th>
                                        <th style="white-space:nowrap;">住所</th>
                                        <th style="white-space:nowrap;">変更日</th>
                                        <th style="white-space:nowrap;">変更箇所</th>
                                        <th style="white-space:nowrap;width: 90px;" >内容確認</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($lstprjinfos as $item) {
                                    ?>
                                    <tr id="1">
                                        <td><?= $item['prj_cust_name'] ?></td>
                                        <td><?= $item['adress'] ?></td>
                                        <td><?= $item['history_updated_time'] ?></td>
                                        <td><?= $item['update_item_str'] ?></td>
                                        <td style="text-align:center;">
                                            <a href="<?=UrlUtil::url($urlHistory, array("prj_id"=>$item["prj_id"],'id'=>$item['id']))?>" class="btn-primary btn" type="button">履歴確認</a>
                                        </td>
                                    </tr>
                                    <?php
                                        }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th style="white-space:nowrap;width: 100px;">お客様名</th>
                                        <th style="white-space:nowrap;">住所</th>
                                        <th style="white-space:nowrap;">変更日</th>
                                        <th style="white-space:nowrap;">変更箇所</th>
                                        <th style="white-space:nowrap;">内容確認</th>
                                    </tr>
                                </tfoot>
                            </table>
                            <br>
                            <?=HtmlUtil::paggingFooter($currentPage, $pageSize, $totalRow, 'frmListPrjInfos', $paggingStype = 3)?>
                        </div>
                        <?php } ?>
                    </div>
                    <!-- End .box -->
                </div>
                <!-- End .span12 -->
            </div>
        </form>
    </div>
</div>