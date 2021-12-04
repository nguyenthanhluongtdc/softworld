<div class="clearfix" id="content">
    <div class="contentwrapper"><!--Content wrapper-->
        <div class="heading">
            <h3>事業所検索</h3>
            <div class="search_open">
                <a id="opener">+ 開く</a>
            </div>
        </div><!-- End .heading-->
        <form method="get" id="frmListOffice">
        <div class="content_border" style="display:hidden !important;">
            
                <input type="hidden" name="<?=REQUEST_PARAM_PAGE_ID?>" value="<?= PageIdConstants::OFFICE ?>" />
                <input type="hidden" name="<?=REQUEST_PARAM_ACTION_METHOD?>" value="search" />
                <input type="hidden" name="current_page" value="<?=$currentPage?>" />
                <input type="hidden" id="sort_condition" name="sort_condition" value="<?=$viewState->get("sort_condition") ?>" />
                <table class="search_form_table">
                    <tbody><tr>
                            <th>
                                事業所名
                            </th>
                            <td><input type="text" value="<?=$viewState->get("office_name")?>" id="office_name" name="office_name"></td>
                        </tr>

                        <tr>
                            <th>
                                電話番号
                            </th>
                            <td><input type="text" value="<?=$viewState->get("office_phone_num")?>" id="office_phone_num" name="office_phone_num"></td>
                        </tr>

                        <tr>
                            <th>
                                都道府県
                            </th>
                            <td>
                                <?= HtmlUtil::dropList('office_prefectures', AppConfig::$PREFECTURE, $viewState->get("office_prefectures")) ?>
                            </td>
                        </tr>

                        <tr>
                            <td class="text_center" colspan="2">
                                <input type="submit" value="検索">
                            </td>
                        </tr>
                    </tbody></table>
            
        </div>
        <!-- Build page from here: Usual with <div class="row-fluid"></div> -->

        <div class="row-fluid">
            <div class="span12">
                <ul id="show-error-messages" class="header-error-messages updatemessage"></ul>
                <div class="box gradient">
                    <?=HtmlUtil::paggingHeader($totalRow, "frmListOffice", $pageSize, 2)?>
                    
                    <?php if (isset($lstOffices)) { ?>
                    <div id="DataArea" class="content noPad clearfix">
                        <?=HtmlUtil::paggingFooter($currentPage, $pageSize, $totalRow, 'frmListOffice', $paggingStype = 3)?>
                       
                        <table width="100%" cellspacing="0" cellpadding="0" border="0" class="table table-striped table-bordered table-condensed" id="DnDTable">
                            <thead><tr>
                                    <th style="white-space:nowrap;width: 100px;">事業所名</th>
                                    <th style="white-space:nowrap;">住所</th>
                                    <th style="white-space:nowrap;">電話番号</th>
                                    <th style="white-space:nowrap;">編集/削除</th>
                                </tr></thead>
                            <tbody>
                                <?php
                                foreach ($lstOffices as $item) {
                                ?>
                                <tr>

                                    <td><?=$item["office_name"]?></td>
                                    <td><?=$item["office_pos_code"] . '&nbsp;' . AppConfig::$PREFECTURE[$item['office_prefectures']] . '&nbsp;' . $item["office_city"] . '&nbsp;' . $item["office_address"] . '&nbsp;' . $item["office_mansion_info"]?></td>
                                    <td><?=$item["office_phone_num"]?></td>
                                    <td style="text-align:center;">
                                        <input class="btn-success btn" data-href="<?=UrlUtil::url($urlEdit, array("edit_id"=>$item["office_id"]))?>" type="button" value="編集" class="button"/>
                                        <input class="btn-danger btn submit-form" type="button" 
                                        submit-action = "<?=$urlDelete?>"
                                        submit-method = "post"
                                        submit-data='{"redirect":"<?=UrlUtil::getCurrentUrl()?>","delete_id":<?=$item["office_id"]?>}' 
                                        value="削除" 
                                        confirm-msg="<?=MessageConstants::COM_CONFIRM_DELETE ?>"/>
                                    </td>
                                </tr>
                                <?php
                                    }
                                ?>
                                
                            </tbody>
                            <tfoot><tr>
                                    <th width="40" style="white-space:nowrap;">事業所名</th>
                                    <th style="white-space:nowrap;">住所</th>
                                    <th style="white-space:nowrap;">電話番号</th>
                                    <th style="white-space:nowrap;">編集/削除</th>
                                </tr></tfoot>

                        </table><br>
                        <?=HtmlUtil::paggingFooter($currentPage, $pageSize, $totalRow, 'frmListOffice', $paggingStype = 3)?>
                    </div>
                    <?php } ?>
                </div><!-- End .box -->
                
            </div><!-- End .span12 -->
        </div><!-- End .row-fluid -->
        </form>
        <!-- Page end here -->
    </div><!-- End contentwrapper -->
</div>