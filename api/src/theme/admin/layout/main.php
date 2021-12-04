<!DOCTYPE html>        
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title><?= isset($titlePage) ? $titlePage : "聖陽 WEB管理システム" ?></title>
        <meta name="robots" content="noindex,nofollow">
        <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato" />
        <link type="text/css" rel="stylesheet" href="../theme/admin/tb/css/bootstrap/bootstrap.css" />
        <link type="text/css" rel="stylesheet" href="../theme/admin/tb/css/bootstrap/bootstrap-responsive.min.css" />
        <link type="text/css" rel="stylesheet" href="../theme/admin/tb/css/supr-theme/jquery.ui.supr.css" />
        <link type="text/css" rel="stylesheet" href="../theme/admin/tb/css/supr-theme/jquery.ui.datepicker.css" />
        <link type="text/css" rel="stylesheet" href="../theme/admin/tb/css/icons.css" />
        <!--add new css-->
        <link type="text/css" rel="stylesheet" href="../theme/admin/tb/plugins/misc/qtip/jquery.qtip.css" />
        <link type="text/css" rel="stylesheet" href="../theme/admin/css/themes/base/jquery.ui.tabs.css" />
        <link type="text/css" rel="stylesheet" href="../theme/admin/tb/css/supr-theme/jquery.ui.theme.css" />
        <link type="text/css" rel="stylesheet" href="../theme/admin/tb/css/supr-theme/jquery.ui.core.css" />
        <link type="text/css" rel="stylesheet" href="../theme/admin/tb/css/supr-theme/jquery.ui.datepicker.css" />
        <link type="text/css" rel="stylesheet" href="../theme/admin/tb/plugins/misc/qtip/jquery.qtip.css" />
        <!--add new css -->
        <link type="text/css" rel="stylesheet" href="../theme/admin/tb/plugins/forms/uniform/uniform.default.css" />
        <link type="text/css" rel="stylesheet" href="../theme/admin/tb/css/main.css?cache=<?= time() ?>" />
        <link type="text/css" rel="stylesheet" href="../theme/admin/tb/css/custom.css" />
        <link type="text/css" rel="stylesheet" href="../theme/admin/tb/css/default.css" />
        <link type="text/css" rel="stylesheet" href="../theme/admin/css/main.css" />
        <!--[if lt IE 9]>
        <script type="text/javascript" src="https://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/apple-touch-icon-144-precomposed.png" />
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/apple-touch-icon-114-precomposed.png" />
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/apple-touch-icon-72-precomposed.png" />
        <link rel="apple-touch-icon-precomposed" href="images/apple-touch-icon-57-precomposed.png" />
        <script type="text/javascript" src="../theme/admin/js/jquery.min.js"></script>
        <script type="text/javascript" src="../theme/admin/js/admin.js?time=<?= time() ?>"></script>
        <script type="text/javascript" src="../theme/admin/tb/js/jquery.cookie.js"></script>
        <script type="text/javascript" src="../theme/admin/js/ui/jquery.ui.datepicker.js"></script>
        <script type="text/javascript" src="../theme/admin/tb/js/supr-theme/jquery-ui-1.10.1.custom.min.js"></script>
        <!--core-->
        <script type="text/javascript" src="../theme/admin/js/jquery.number.js"></script>
        <script type="text/javascript" src="../theme/admin/js/show-message.js"></script>
        <script type="text/javascript" src="../theme/admin/js/main.js?time=<?= time() ?>"></script>
        <script type="text/javascript" src="../theme/admin/js/enter2tab.js"></script>
        <!--end core-->
        <style type="text/css">
            .button_submit_cancel{
                padding-left: 5px;
                padding-right: 5px;
            }
        </style>
        <script type="text/javascript">
<?php
if (isset($listErrorMessage)) {
    $errors = json_encode($listErrorMessage);
    ?>
                appErrors = <?= $errors ?>;
    <?php
}
?>
            REQUEST_PARAM_ACTION_REPORT_METHOD = "<?= REQUEST_PARAM_ACTION_REPORT_METHOD ?>";
        </script>
    </head>
    <body>
        <div id="qLoverlay"></div>
        <div id="qLbar"></div>
        <div id="header">
            <div class="navbar">
                <div class="navbar-inner">
                    <div class="container-fluid">
                        <a class="brand" href="<?=$UrlIndex?>" style="font-size:28px;margin-left:-28px"><span class="slogan"> Dashboard </span></a>
                        <div class="nav-no-collapse">
                            <ul class="nav pull-right usernav">
                                <li><a href="<?= $urlLogout ?>" onclick="return window.confirm('ログアウトしますか？')"><span class="icon16 icomoon-icon-exit"></span>Đăng xuất</a></li>
                            </ul>
                        </div><!-- /.nav-collapse -->
                    </div>
                </div><!-- /navbar-inner -->
            </div><!-- /navbar -->
        </div><!-- End #header -->
        <div id="wrapper">
            <?php include_once('leftmenu.php') ?>
            <!--Body content-->
            <?php
            require_once $viewPath
            ?>
        </div>
        <script type="text/javascript" src="../theme/admin/tb/js/bootstrap/bootstrap.min.js"></script>
        <script type="text/javascript" src="../theme/admin/tb/plugins/misc/qtip/jquery.qtip.min.js"></script>
        <script type="text/javascript" src="../theme/admin/tb/plugins/misc/totop/jquery.ui.totop.min.js"></script>
        <script type="text/javascript" src="../theme/admin/tb/plugins/forms/watermark/jquery.watermark.min.js"></script>
        <script type="text/javascript" src="../theme/admin/tb/plugins/forms/uniform/jquery.uniform.min.js"></script>
        <script type="text/javascript" src="../theme/admin/tb/js/main.js"></script>
        <!--tab js-->
        <script src="../theme/admin/js/ui.core.js" type="text/javascript"></script>
        <script src="../theme/admin/js/ui.tabs.min.js" type="text/javascript"></script>
        <script type="text/javascript">
                                    $(function () {
                                        $('#ui-tab > ul').tabs({fx: {opacity: 'toggle', duration: 'fast'}});
                                    });
        </script>
        <!--end tab js-->
    </body>
</html>

