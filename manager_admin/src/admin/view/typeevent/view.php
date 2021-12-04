
<div class="clearfix" id="content">
    <div class="contentwrapper"><!--Content wrapper-->
        <div class="heading">
            <h3>Tìm kiếm sự kiện</h3>
            <div class="search_open">
                <a id="opener">+ Mởく</a>
            </div>
        </div><!-- End .heading-->
        <form method="get" action="<?=$urlSearch?>" id="frmListTypeEvent">
            <div class="content_border">
                    <input type="hidden" name="<?=REQUEST_PARAM_PAGE_ID?>" value="<?=PageIdConstants::TYPE_EVENT?>" />
                    <input type="hidden" name="<?=REQUEST_PARAM_ACTION_METHOD?>" value="search" />
                    <input type="hidden" name="current_page" value="<?=$currentPage?>" />
                    <input type="hidden" id="sort_condition" name="sort_condition" value="<?=$viewState->get("sort_condition") ?>" />
                    <table class="search_form_table">
                        <tbody>
                            <tr>
                                <th>
                                    ID
                                </th>
                                <td>
                                    <input type="text" id="id" name="id" value="<?=$viewState->get('id')?>">
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Tên loại
                                </th>
                                <td>
                                    <input type="text" id="name_type" name="name_type" value="<?=$viewState->get('name_type')?>">
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Mã màu
                                </th>
                                <td>
                                    <input type="text" id="code_color" name="code_color" value="<?=$viewState->get('code_color')?>">
                                </td>
                            </tr>

                            <tr>
                                <th>
                                    Mã phân loại
                                </th>
                                <td>
                                    <input type="text" id="code_type" name="code_type" value="<?=$viewState->get('code_type')?>">
                                </td>
                            </tr>
                            <tr>
                                <td class="text_center" colspan="2"><input type="submit" value="Tìm kiếm"></td>
                            </tr>
                    </tbody>
                </table>
            </div>
            <!-- Build page from here: Usual with <div class="row-fluid"></div> -->
            <div class="row-fluid">
                <div class="span12">
                    <ul id="show-error-messages" class="header-error-messages updatemessage"></ul>
                    <div class="box gradient">
                        <?=HtmlUtil::paggingHeader($totalRow, "frmListTypeEvent", $pageSize, 2)?>
                        <div id="DataArea" class="content noPad clearfix">
                            <?=HtmlUtil::paggingFooter($currentPage, $pageSize, $totalRow, 'frmListTypeEvent', $paggingStype = 3)?>
                            <table width="100%" cellspacing="0" cellpadding="0" border="0" class="table table-striped table-bordered table-condensed" id="EventTable">
                                <thead>
                                    <tr>
                                        <th width="10px" style="white-space:nowrap;">STT</th>
                                        <th width="119px" style="white-space:nowrap;">Tên loại</th>
                                        <th width="140px" style="white-space:nowrap;">Mã màu</th>
                                        <th width="140px" style="white-space:nowrap;">Mã phân loại</th>
                                        <th width="30px" style="white-space:nowrap;">Tuỳ chọn</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $d = 1; ?>
                                    <?php 
                                    if(!StringUtil::isNullOrEmpty($listTypeEvent)){
                                    foreach ($listTypeEvent as $key => $value) { ?>
                                        <tr id="<?=$d?>">
                                            <td><?=$key+1?></td>
                                            <td><?=$value['name_type']?></td>
                                            <td><?=$value['code_color']?></td>
                                            <td><?=$value['code_type']?></td>
                                            <td>
                                                <a href="<?=UrlUtil::url($urlEdit, array("id"=>$value["id"]))?>" class="btn-success btn"/>Update</a>
                                                <input  type="hidden" 
                                                        submit-action = "<?=$urlDelete?>"
                                                        submit-method = "post"
                                                        submit-data='{"redirect":"<?=UrlUtil::getCurrentUrl()?>","delete_id":<?=$value["id"]?>}' 
                                                        value="Delete" 
                                                        class="btn-danger btn submit-form" 
                                                        confirm-msg="<?=MessageConstants::COM_CONFIRM_DELETE ?>"/>

                                                        <label for="o" class="btn-danger btn-delete btn">Delete</label>

                                                <a href="<?=UrlUtil::url($urlCopy, array("id"=>$value["id"]))?>" class="btn-success btn"/>Copy</a>
                                            </td>
                                        </tr>
                                    <?php
                                        $d++;
                                    } }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th width="10px" style="white-space:nowrap;">STT</th>
                                        <th width="119px" style="white-space:nowrap;">Tên loại</th>
                                        <th width="140px" style="white-space:nowrap;">Mã màu</th>
                                        <th width="140px" style="white-space:nowrap;">Mã phân loại</th>
                                        <th width="30px" style="white-space:nowrap;">Tuỳ chọn</th>
                                    </tr>
                                </tfoot>
                            </table><br>
                            <?=HtmlUtil::paggingFooter($currentPage, $pageSize, $totalRow, 'frmListTypeEvent', $paggingStype = 3)?>
                    </div>
                </div><!-- End .box -->
            </div><!-- End .span12 -->
        </form>
    </div><!-- End .row-fluid -->
    <!-- Page end here -->
</div><!-- End contentwrapper -->
</div>


      