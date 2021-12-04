

<div class="clearfix" id="content">
    <div class="contentwrapper"><!--Content wrapper-->
        <!-- <div class="heading">
            <h3>Tìm kiếm sự kiện</h3>
            <div class="search_open">
                <a id="opener">+ Mởく</a>
            </div>
        </div> -->
        <!-- End .heading-->
        <form method="get" action="<?=$urlSearch?>" id="frmListEvent">
            <!-- <div class="content_border">
                    <input type="hidden" name="<?=REQUEST_PARAM_PAGE_ID?>" value="<?=PageIdConstants::EVENT?>" />
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
                                    Tên sự kiện
                                </th>
                                <td>
                                    <input type="text" id="event_name" name="event_name" value="<?=$viewState->get('event_name')?>">
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Tên khách hàng
                                </th>
                                <td>
                                    <input type="text" id="name_customer" name="name_customer" value="<?=$viewState->get('name_customer')?>">
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    SDT
                                </th>
                                <td>
                                    <input type="text" id="phone_customer" name="phone_customer" value="<?=$viewState->get('phone_customer')?>">
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Email khách hàng
                                </th>
                                <td><input type="text" id="email_customer" name="email_customer" value="<?=$viewState->get('email_customer')?>"></td>
                            </tr>
                           
                            <tr>
                                <td class="text_center" colspan="2"><input type="submit" value="Tìm kiếm"></td>
                            </tr>
                    </tbody>
                </table>
            </div> -->
            <!-- Build page from here: Usual with <div class="row-fluid"></div> -->
            <div class="row-fluid">
                <div class="span12">
                    <ul id="show-error-messages" class="header-error-messages updatemessage"></ul>
                    <div class="box gradient">
                        <?=HtmlUtil::paggingHeader($totalRow, "frmListEvent", $pageSize, 2)?>
                        <div id="DataArea" class="content noPad clearfix">
                            <?=HtmlUtil::paggingFooter($currentPage, $pageSize, $totalRow, 'frmListEvent', $paggingStype = 3)?>
                            <table width="100%" cellspacing="0" cellpadding="0" border="0" class="table table-striped table-bordered table-condensed" id="EventTable">
                                <thead>
                                    <tr>
                                        <th width="10px" style="white-space:nowrap;">STT</th>
                                        <th width="119px" style="white-space:nowrap;">Tên sự kiện</th>
                                        <th width="140px" style="white-space:nowrap;">Ngày bắt đầu</th>
                                        <th width="140px" style="white-space:nowrap;">Ngày kết thúc</th>
                                        <th width="180px" style="white-space:nowrap;">Tên khách hàng</th>
                                        <th width="100px" style="white-space:nowrap;">Số điện thoại</th>
                                        <th width="100px" style="white-space:nowrap;">Email</th>
                                        <th width="40px" style="white-space:nowrap;">Thuộc loại</th>
                                        <th width="100px" style="white-space:nowrap;">Tuỳ chọn</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $d = 1; ?>
                                    <?php 
                                    if(!StringUtil::isNullOrEmpty($dataTrash)){
                                    foreach ($dataTrash as $key => $value) { ?>
                                        <?php
                                            $found_key = array_search($value['type_id'], array_column($dataTypeEvent, 'id'));
                                        ?>
                                        <tr id="<?=$d?>">
                                            <td><?=$key+1?></td>
                                            <td><?=$value['event_name']?></td>
                                            <td><?=date_format(date_create($value['start_time']), 'd/m/Y')?></td>
                                            <td><?=date_format(date_create($value['end_time']), 'd/m/Y')?></td>
                                            <td><?=$value['name_customer']?></td>
                                            <td><?=$value['phone_customer']?></td>
                                            <td><?=$value['email_customer']?></td>
                                            <td><?=$dataTypeEvent[$found_key]['name_type']?></td>
                                            <td style="text-align:center;">
                                                <input  type="button"
                                                        submit-action = "<?=$urlTrash?>"
                                                        submit-method = "post"
                                                        submit-data='{"redirect":"<?=UrlUtil::getCurrentUrl()?>","show_id":<?=$value["id"]?>}' 
                                                        value="Remove" 
                                                        class="btn-success btn submit-form" 
                                                        confirm-msg="<?=MessageConstants::COM_CONFIRM_SHOW ?>"/>
                                                
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
                                        <th width="119px" style="white-space:nowrap;">Tên sự kiện</th>
                                        <th width="140px" style="white-space:nowrap;">Ngày bắt đầu</th>
                                        <th width="140px" style="white-space:nowrap;">Ngày kết thúc</th>
                                        <th width="180px" style="white-space:nowrap;">Tên khách hàng</th>
                                        <th width="100px" style="white-space:nowrap;">Số điện thoại</th>
                                        <th width="100px" style="white-space:nowrap;">Email</th>
                                        <th width="30px" style="white-space:nowrap;">Thuộc loại</th>
                                        <th width="100px" style="white-space:nowrap;">Tuỳ chọn</th>
                                    </tr>
                                </tfoot>
                            </table><br>
                            <?=HtmlUtil::paggingFooter($currentPage, $pageSize, $totalRow, 'frmListEvent', $paggingStype = 3)?>
                    </div>
                </div><!-- End .box -->
            </div><!-- End .span12 -->
        </form>
    </div><!-- End .row-fluid -->
    <!-- Page end here -->
</div><!-- End contentwrapper -->
</div>