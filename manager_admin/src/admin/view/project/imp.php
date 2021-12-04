<div id="content" class="clearfix">
    <div class="contentwrapper"><!--Content wrapper-->
        <div class="heading">
            <h3>案件登録[CSVインポート]</h3>
        </div><!-- End .heading-->

        <!-- Build page from here: Usual with <div class="row-fluid"></div> -->
        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="<?= REQUEST_PARAM_PAGE_ID ?>" value="<?= PageIdConstants::PROJECT ?>" />
            <input type="hidden" name="<?= REQUEST_PARAM_ACTION_METHOD ?>" value="imp" />
            <div class="row-fluid">
                <div class="span12">

                    <div class="box gradient">


                        <div class="content noPad clearfix" id="DataArea">

                            <div class="margin10"> <span class="komered">※フォーマットにそったCSVを読み込む画面です。
                                    CSVに入力した案件IDの案件が存在する場合は、自動で関連付けられます。 <br>
                                    存在しない場合は、新しく案件を作成します。
                                    <br>
                                </span>
                            </div>


                            <table class="input_form_table">
                                <tbody><tr>
                                        <th colspan="2" class="cap">CSVインポート</th>
                                    </tr>
                                    <tr>
                                        <th>
                                            案件ID
                                        </th>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th>
                                            CSV読み込み <span class="komered">※</span>
                                        </th>
                                        <td><input type="file" name="name_csv" id=""></td>
                                    </tr>

                                    <tr>
                                        <td colspan="2" class="text_center"><input type="submit" name="upload" value="確認画面へ"/></td>
                                    </tr>
                                </tbody></table>





                        </div>
                    </div><!-- End .box -->
                </div><!-- End .span12 -->
            </div><!-- End .row-fluid -->
        </form>

        <!-- Page end here -->
    </div><!-- End contentwrapper -->
</div>