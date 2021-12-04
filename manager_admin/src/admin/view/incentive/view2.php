<script>
    function view_td(ma) {
        $(".cl" + ma).toggle();
    }
    
    function commission_amout_total()
    {
        var total = 0;
        $(".commission_amount_item").each(function() {
                var commisstion_item = $(this).val();
                total = parseInt(total) + parseInt(commisstion_item);  
                
        });
        $('.res_commisson_total').html(total);
    }
</script>
<style>
    .table tbody th {
        text-align: left;
        font-size: 12px;
    }
</style>

    <form action="" method="post" >
        <div class="content noPad clearfix" <?php echo $flat; ?> style="<?= $flat == 2 ? '' : 'display:none' ?>" id="DataArea">
            <div class="title">
                <table style="width: 100%;">
                    <tbody>
                        <tr>
                            <td style="width: 33%;text-align: left;"> </td>
                            <td style="width: 33%;text-align: center;">
                                <h4>
                                </h4>
                            </td>
                            <td style="width: 33%;text-align: right;">  </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="text_right padding_10px">
                <button type="button" class="btn-primary btn" onclick="ExportCSV();">CSVダウンロード</button>
            </div>

            <table  cellspacing="0" cellpadding="0" border="0" width="100%" class="table table-striped table-bordered table-condensed" id="DnDTable">
                <thead>
                    <tr>
                        <th style="white-space:nowrap;">社員名/担当種別</th>
                        <th style="white-space:nowrap;">案件ID</th>
                        <th style="white-space:nowrap;">契約日</th>
                        <th style="white-space:nowrap;">完納日</th>
                        <th style="white-space:nowrap;">PV,EQ,IH</th>
                        <th style="white-space:nowrap;">メーカー</th>
                        <th style="white-space:nowrap;">お客様名</th>
                        <th style="white-space:nowrap;">Kw</th>
                        <th style="white-space:nowrap;">売上金額</th>
                        <th style="white-space:nowrap;">仕切金額</th>
                        <th style="white-space:nowrap;">利益額</th>
                        <th style="white-space:nowrap;">歩合(%/円)</th>
                    </tr>
                </thead>
                <?php if (!ArrayUtil::isNullOrEmpty($data2)) :?>
                <tbody>
                    <?php $i = 0; ?>
                    <?php foreach ($data2 as $name => $value) : ?>
                        <?php
                        $sum +=$value['prj_prod_price_selling_total'];
                        $sum1 +=$value['prj_prod_price_part_total'];
                        $sum_selling +=$value['prj_prod_price_selling_total'];
                        $sum_part +=$value['prj_prod_price_part_total'];
                        $prj_comm_amount +=$value['prj_comm_amount'];

                        if (!StringUtil::isNullOrEmpty($value['commission_amount']))
                            $commission_amount = $value['commission_amount'];
                        else
                            $commission_amount = $prj_comm_amount;
                            
                        $commission_amount_total +=$commission_amount;
                        ?>
                        <tr>
                            <th style="white-space:nowrap; border-top:solid 2px #000000;"><?= $name ?><br>
                                <a onclick="view_td(<?= $i ?>)" id="href1" href="javascript:void(0);">詳細</a>
                            </th>
                            <th style="white-space:nowrap; border-top:solid 2px #000000;"></th>
                            <th style="white-space:nowrap; border-top:solid 2px #000000;"></th>
                            <th style="white-space:nowrap; border-top:solid 2px #000000;"></th>
                            <th style="white-space:nowrap; border-top:solid 2px #000000;"></th>
                            <th style="white-space:nowrap; border-top:solid 2px #000000;"></th>
                            <th style="white-space:nowrap; border-top:solid 2px #000000;"></th>
                            <th style="white-space:nowrap; border-top:solid 2px #000000;"></th>
                            <th  style="white-space:nowrap; border-top:solid 2px #000000;text-align: right;" data="prj_prod_price_selling_total">
                                <span class="number" ><?= $value['prj_prod_price_selling_total'] ?></span>
                            </th>
                            <th class="number" style="white-space:nowrap; border-top:solid 2px #000000;text-align: right;" data="prj_prod_price_part_total">
                                <?= $value['prj_prod_price_part_total'] ?>
                            </th>
                            <th class="number" style="white-space:nowrap; border-top:solid 2px #000000;text-align: right;">
                                <?= $value['prj_prod_price_selling_total'] - $value['prj_prod_price_part_total'] ?>
                            </th>
                            <th style="white-space:nowrap; border-top:solid 2px #000000;">
                                <input type="hidden" name="comm_update_time<?= $value['staff_id'] ?>" value="<?= $value['comm_update_time'] ?>"> 
                                <input onchange="commission_amout_total()" type="text" class="input-mini ime_off total_percent_<?= $value['staff_id'] ?> commission_amount_item"  value="<?= $commission_amount ?>"  name="commission_amount<?= $value['staff_id'] ?>" >円
                                <br>
                                <span class="number" ><?= $value['prj_comm_amount'] ?>円</span>
                            </th>
                        </tr>

                        <?php foreach ($value['array'] as $k => $v) : ?>
                            <?php foreach ($v as $item) : ?>

                                <?php
                                if (StringUtil::isNullOrEmpty($item['prj_comm_partition_amount']))
                                {
                                     $prj_comm_partition_amount = $item['total_prod_price_part']-$item['total_prod_price_part1'];
                                }
                                else
                                {
                                    $prj_comm_partition_amount = $item['prj_comm_partition_amount'];
                                }
                                

                                $subtract = (int) $item['prj_prod_price_selling_total'] - (int) $prj_comm_partition_amount;

                                $percent = 0;
                                if ($item['prj_prod_price_selling_total'] != 0 && $subtract != 0) {
                                    $percent = round(($item['prj_staff_commission_amount'] / $subtract) * 100, 2);
                                }
                                ?>
                                <tr style="display: none"   class="cl<?= $i ?>" id="id1_1">
                                    <td style=" border-top:solid 2px #000000;">
                <?php echo $item['staff_name']; ?>
                                        (<?= AppConfig::$ROLE_GROUP[$item['prj_role_grp']] ?>)
                                    </td>
                                    <td style=" border-top:solid 2px #000000;"><?php echo $item['prj_id']; ?></td>
                                    <td style=" border-top:solid 2px #000000;"><?= $item['prj_keiyaku_bi'] ?></td>
                                    <td style=" border-top:solid 2px #000000;"><?= $item['prj_kanko_bi'] ?></td>
                                    <td style=" border-top:solid 2px #000000;">
                <?php
                $pv = ArrayUtil::StringToArray($item['prj_kind_pv']);
                if (in_array(1, $pv))
                    echo '○、';
                else
                    echo 'なし、';

                $prj_kind_od = ArrayUtil::StringToArray($item['prj_kind_od']);
                if (in_array(1, $prj_kind_od))
                    echo '○、';
                else
                    echo 'なし、';
                $prj_kind_od = ArrayUtil::StringToArray($item['prj_kind_od']);
                if (in_array(2, $prj_kind_od))
                    echo '○';
                else
                    echo 'なし';
                ?>  
                                    </td>
                                    <td style=" border-top:solid 2px #000000;" data="maker">
                <?= AppConfig::$MAKER[$item['prj_maker']]; ?>
                                    </td>
                                    <td style=" border-top:solid 2px #000000;" data='prj_cust_name'>
                                        <a target="_blank" href="<?= UrlUtil::url($urlEdit, array("edit_prj_id" => $item["prj_id"])) ?>">
                <?php echo $item['prj_cust_name']; ?>
                                        </a>
                                    </td>
                                    <td style=" border-top:solid 2px #000000;" data='prj_prod_kw'>
                <?php
                echo ($item['prj_prod_kw']);
                ?>&nbsp;Kw
                                    </td>
                                    <td style=" border-top:solid 2px #000000;text-align: right;" data="prj_prod_price_selling_total">
                                        <span class="number">
                <?= (int) ($item['prj_prod_price_selling_total']); ?>
                                            <span>
                                                </td>
                                                <td style=" border-top:solid 2px #000000;text-align: right;" data="prj_comm_partition_amount">
                <span class="number"><?= ($prj_comm_partition_amount); ?></span>
                                                </td>
                                                <td style=" border-top:solid 2px #000000;text-align: right;" data="subtract">
                                                    <span class="staff_<?= $value['staff_id'] ?>_<?= $item['prj_id'] . $item['prj_role_grp'] ?> number">
                <?= ($subtract); ?>
                                                    </span>
                                                </td>

                                                <td style=" border-top:solid 2px #000000;" data="percent">
                                                    <input type="text" value="<?= $percent ?>" readonly="true" class="input-Xmini ime_off staff_<?= $value['staff_id'] ?>_<?= $item['prj_id'] . $item['prj_role_grp'] ?>" >%

                                                    <br>
                                                    <span class="number" >
                <?= $item['prj_staff_commission_amount'] ?>
                                                    </span>
                          
                                                </td>
                                                </tr>
            <?php endforeach; ?>  
                                        <?php endforeach; ?>  
                                        <?php $i++ ?>
                                    <?php endforeach; ?>       
                                    </tbody>
                                    <tbody>
                                        <tr>
                                            <th style="white-space:nowrap;">合計</th>
                                            <th style="white-space:nowrap;"></th>
                                            <th style="white-space:nowrap;"></th>
                                            <th style="white-space:nowrap;"></th>
                                            <th style="white-space:nowrap;"></th>
                                            <th style="white-space:nowrap;"></th>
                                            <th style="white-space:nowrap;"></th>
                                            <th style="white-space:nowrap;"></th>
                                            <th style="white-space:nowrap;text-align: right;"> <span class="sum number"> <?= ($sum); ?></span> </th>
                                            <th style="white-space:nowrap;text-align: right;" class="number"> <?= ($sum1); ?> </th>
                                            <th style="white-space:nowrap;text-align: right;" class="number"> <?= ($sum_selling - $sum_part); ?> </th>
                                            <th style="white-space:nowrap;text-align: right;"> 
                                                <span class="number res_commisson_total"><?=$commission_amount_total?></span>（変更後）<br />
                                                <span class="number"><?= ($prj_comm_amount); ?></span>（変更前）
                                            </th>
                                        </tr>
                                        <tr>
                                    <input type="hidden" value="1" name="regist_step">
                                    <td style="text-align: center;" class="text_center" colspan="12"><input class="button_submit_cancel" type="submit" value="確認画面へ"></td>
                                    </tr>
                                    </tbody>
            <?php endif; ?>
                                    </table>
                                    <br>                                
                                    </div>
                                    </form>
