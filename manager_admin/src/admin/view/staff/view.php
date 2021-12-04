<div class="clearfix" id="content">
    <div class="contentwrapper"><!--Content wrapper-->
        <div class="heading">
            <h3>社員検索</h3>
            <div class="search_open">
                <a id="opener">+ 開く</a>
            </div>
        </div><!-- End .heading-->
        <form method="get" action="<?=$urlSearch?>" id="frmListStaff">
            <div class="content_border">
                    <input type="hidden" name="<?=REQUEST_PARAM_PAGE_ID?>" value="<?=PageIdConstants::STAFF?>" />
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
                                    <input type="text" id="staff_id" name="staff_id" value="<?=$viewState->get('staff_id')?>">
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Tên nhân viên
                                </th>
                                <td>
                                    <input type="text" id="staff_name" name="staff_name" value="<?=$viewState->get('staff_name')?>">
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Bộ phận
                                </th>
                                <td>
                                    <?= HtmlUtil::dropList('staff_office_id', $loffice, $viewState->get('staff_office_id'), 'office_id', 'office_name') ?>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Phòng ban
                                </th>
                                <td>
                                     <?= HtmlUtil::dropList('staff_department_id', AppConfig::$STAFF_DEPARTMENT_ID, $viewState->get('staff_department_id')) ?>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    SDT
                                </th>
                                <td><input type="text" id="staff_phone_num" name="staff_phone_num" value="<?=$viewState->get('staff_phone_num')?>"></td>
                            </tr>
                            <tr>
                                <th>
                                    Email
                                </th>
                                <td><input type="text" id="staff_email" name="staff_email" value="<?=$viewState->get('staff_email')?>"></td>
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
                        <?=HtmlUtil::paggingHeader($totalRow, "frmListStaff", $pageSize, 2)?>
                        <div id="DataArea" class="content noPad clearfix">
                            <?=HtmlUtil::paggingFooter($currentPage, $pageSize, $totalRow, 'frmListStaff', $paggingStype = 3)?>
                            <table width="100%" cellspacing="0" cellpadding="0" border="0" class="table table-striped table-bordered table-condensed" id="StaffTable">
                                <thead>
                                    <tr>
                                        <th width="51px" style="white-space:nowrap;">Văn phòng</th>
                                        <th width="51px" style="white-space:nowrap;">Phòng ban</th>
                                        <th width="119px" style="white-space:nowrap;">Tên nhân viên</th>
                                        <th width="193px" style="white-space:nowrap;">Số điện thoại</th>
                                        <th width="260px" style="white-space:nowrap;">Địa chỉ</th>
                                        <th width="180px" style="white-space:nowrap;">Email</th>
                                        <th width="232px" style="white-space:nowrap;width: 120px;">Lựa chọn</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $d = 1; ?>
                                    <?php 
                                    if(!StringUtil::isNullOrEmpty($lStaff)){
                                    foreach ($lStaff as $value) { ?>
                                        <tr id="<?=$d?>">
                                            <td><?=$value['office_name']?></td>
                                            <td><?= AppConfig::$STAFF_DEPARTMENT_ID[$value['staff_department_id']]?></td>
                                            <td><?=$value['staff_name']?></td>
                                            <td><?=$value['staff_phone_num']?></td>
                                            <?php $staff_prefectures = AppConfig::$PREFECTURE[$value['staff_prefectures']]?>
                                            <td><?=$value['staff_pos_code'].' '.$staff_prefectures.' '.$value['staff_city'].' '.$value['staff_address'].' '. $value['staff_mansion_info']?></td>
                                            <td><a href="mailto:test@test.com"><?=$value['staff_email']?></a></td>
                                            <td style="text-align:center;">
                                                <a href="<?=UrlUtil::url($urlEdit, array("edit_staff_id"=>$value["staff_id"]))?>" class="btn-success btn"/>Sửa</a>
                                                <input  type="button" 
                                                        submit-action = "<?=$urlDelete?>"
                                                        submit-method = "post"
                                                        submit-data='{"redirect":"<?=UrlUtil::getCurrentUrl()?>","delete_staff_id":<?=$value["staff_id"]?>}' 
                                                        value="Xoá" 
                                                        class="btn-danger btn submit-form" 
                                                        confirm-msg="<?=MessageConstants::COM_CONFIRM_DELETE ?>"/>
                                            </td>
                                        </tr>
                                    <?php
                                        $d++;
                                    } }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th width="51px" style="white-space:nowrap;">Văn phòng</th>
                                        <th width="51px" style="white-space:nowrap;">Phòng ban</th>
                                        <th width="119px" style="white-space:nowrap;">Tên nhân viên</th>
                                        <th width="193px" style="white-space:nowrap;">Số điện thoại</th>
                                        <th width="260px" style="white-space:nowrap;">Địa chỉ</th>
                                        <th width="180px" style="white-space:nowrap;">Email</th>
                                        <th width="232px" style="white-space:nowrap;width: 120px;">Lựa chọn</th>
                                    </tr>
                                </tfoot>
                            </table><br>
                            <?=HtmlUtil::paggingFooter($currentPage, $pageSize, $totalRow, 'frmListStaff', $paggingStype = 3)?>
                    </div>
                </div><!-- End .box -->
            </div><!-- End .span12 -->
        </form>
    </div><!-- End .row-fluid -->
    <!-- Page end here -->
</div><!-- End contentwrapper -->
</div>