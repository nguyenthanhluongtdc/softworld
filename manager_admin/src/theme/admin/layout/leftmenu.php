<!--Responsive navigation button-->
<div class="resBtn">
    <a href="#"><span class="icon16 minia-icon-list-3"></span></a>
</div>
<!--Sidebar collapse button-->
<div class="collapseBtn leftbar">
   <a href="#" class="tipR" title="管理メニューを隠す"><span class="icon12 minia-icon-layout"></span></a>
</div>
<!--Sidebar background-->
<div id="sidebarbg"></div>
<!--Sidebar content-->
<div id="sidebar">
    <div class="sidenav">
        <div class="sidebar-widget" style="margin: -1px 0 0 0;">
            <h5 class="title" style="margin-bottom:0">MENU</h5>
        </div><!-- End .sidenav-widget -->
        <div class="alert alert-info" style="margin:37px 5px 5px 5px;padding:2px 5px">
            <?=$userInfo['staff_name']?><!--システム管理者 でログイン中 でログイン中 -->
        </div>
        <div class="mainnav">
            <ul>
                <?php if(!empty($headerUrlEvent) && !empty($headerUrlEventRegist)): ?>
                <li>
                    <a href="#" class="hasUl"><span class="dark icon16 icomoon-icon-factory"></span>Manager event</a>
                    <ul class="sub opensub">
                        <li><a href="<?=$headerUrlEvent?>"><span class="icon16 icomoon-icon-search-2 blue"></span> List </a></li>
                        <li><a href="<?=$headerUrlEventRegist?>"><span class="icon16 icomoon-icon-file-add red"></span>Create new</a></li>
                        <li><a href="<?=$headerUrlEventCalendar?>"><span class="icon16 icomoon-icon-calendar-2 red"></span>Calendar</a></li>
                        <li><a href="<?=$headerUrlEventTrash?>"><span class="icon16 icomoon-icon-file-remove red"></span>Trash</a></li>
                        <li class="leftmenu_last">&nbsp;</li>
                    </ul>
                </li>
                <?php endif;?>

                <?php if(!empty($headerUrlTypeEvent) && !empty($headerUrlTypeEventRegist)): ?>
                <li>
                    <a href="#" class="hasUl"><span class="dark icon16 icomoon-icon-bars"></span>Manger type event</a>
                    <ul class="sub opensub">
                        <li><a href="<?=$headerUrlTypeEvent?>"><span class="icon16 icomoon-icon-search-2 blue"></span>List</a></li>
                        <li><a href="<?=$headerUrlTypeEventRegist?>"><span class="icon16 icomoon-icon-file-add red"></span>Create new</a></li>
                        <li class="leftmenu_last">&nbsp;</li>
                    </ul>
                </li>
                <?php endif;?>

                <?php if(!empty($headerUrlStaff) && !empty($headerUrlStaffRegist)): ?>
                <li>
                    <a href="#" class="hasUl"><span class="dark icon16 icomoon-icon-user-4"></span>Quản lý nhân viên</a>
                    <ul class="sub opensub">
                        <li><a href="<?=$headerUrlStaff?>"><span class="icon16 icomoon-icon-search-2 blue"></span>Danh sách</a></li>
                        <li><a href="<?=$headerUrlStaffRegist?>"><span class="icon16 icomoon-icon-file-add red"></span>Tạo mới</a></li>
                        <li class="leftmenu_last">&nbsp;</li>
                    </ul>
                </li>
                <?php endif;?>
                <?php if(!empty($headerUrlOffice) && !empty($headerUrlOfficeRegist)):?>
                <li>
                    <a href="#" class="hasUl drop"><span class="dark icon16 icomoon-icon-office"></span>Quản lý văn phòng</a>
                    <ul class="sub opensub" style="display:block">
                        <li><a href="<?=$headerUrlOffice?>"><span class="icon16 icomoon-icon-search-2 blue"></span>Danh sách<span class="notification green" id="cnt_logcontact" style="display:none">0</span></a></li>
                        <li><a href="<?=$headerUrlOfficeRegist?>"><span class="icon16 icomoon-icon-file-add red"></span>Tạo mới</a></li>
                        <li class="leftmenu_last">&nbsp;</li>
                    </ul>
                </li>
                <?php endif; ?>

                <?php if(!empty($headerUrlProject) && !empty($headerUrlProjectRegist)): ?>
                <li>
                    <a href="#" class="hasUl"><span class="dark icon16 entypo-icon-users"></span>案件管理</a>
                    <ul class="sub opensub">
                        <li><a href="<?=$headerUrlProject?>"><span class="icon16 icomoon-icon-search-2 blue"></span>案件検索</a></li>                    
                        <li><a href="<?=$headerUrlProjectCal?>"><span class="icon16 icomoon-icon-search-2 blue"></span>スケジュール</a></li>
                        <li><a href="<?=$headerUrlProjectRegist?>"><span class="icon16 icomoon-icon-file-add red"></span>案件新規登録[画面入力]</a></li>
                        <?php endif;?>
                        <?php if(!empty($headerUrlPayment)): ?>
                        <li><a href="<?=$headerUrlPayment?>"><span class="icon16 icomoon-icon-file blue"></span>入金状況検索</a></li>
                        <?php endif;?>
                        <?php if(!empty($headerUrlKanko)): ?>
                        <li><a href="<?=$headerUrlKanko?>"><span class="icon16 icomoon-icon-file blue"></span>定期点検リスト</a></li>
                        <li class="leftmenu_last">&nbsp;</li>
                    </ul>
                </li>
                <?php endif;?>
                <li style="display: none;">
                    <a href="#" class="hasUl"><span class="dark icon16 icomoon-icon-file-pdf"></span>帳票管理</a>
                    <ul class="sub opensub">
                        <li><a href="./?req=order_regi"><span class="icon16 icomoon-icon-file blue"></span>発注書作成</a></li>
                        <li class="leftmenu_last">&nbsp;</li>
                    </ul>
                </li>
                <!--                        <li>-->
                <!--                            <a href="#" class="hasUl"><span class="dark icon16 icomoon-icon-bars-2"></span>集計管理</a>-->
                <!--                            <ul class="sub opensub">-->
                <!--                                <li><a href="--><!--?req=total"><span class="icon16 icomoon-icon-bars blue"></span>社員別売上集計</a></li>-->
                <!--        <li class="leftmenu_last">&nbsp;</li>-->
                <!--                            </ul>-->
                <!--                        </li>-->
                <?php if(!empty($headerUrlIncentive)): ?>
                <li>
                    <a href="#" class="hasUl"><span class="dark icon16 icomoon-icon-bars-2"></span>歩合管理</a>
                    <ul class="sub opensub">
                        <li><a href="<?=$headerUrlIncentive?>"><span class="icon16 icomoon-icon-bars blue"></span>歩合集計</a></li>
                        <li class="leftmenu_last">&nbsp;</li>
                    </ul>
                </li>
                <?php endif;?>
                <li><a href="<?=$urlLogout?>" onclick="return window.confirm('Bạn có muốn đăng xuất không!')"><span class="icon16 icomoon-icon-exit-2 red"></span>Log out</a></li>
            </ul>
        </div>
    </div><!-- End sidenav -->
</div><!-- End #sidebar -->