<div id="content" class="clearfix">
 <div class="contentwrapper"><!--Content wrapper-->
    <div class="heading">
       <h3>スケジュール</h3>
       <div class="search_open">
        <!--    <a id="opener">--><!--</a>-->
    </div>
</div><!-- End .heading-->
<!-- Build page from here: Usual with <div class="row-fluid"></div> -->
<div class="row-fluid">
  <div class="span12">
    <div class="box gradient">
      <div class="row-fluid">
        <div class="span12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <!-- END EXAMPLE TABLE PORTLET-->
        <?php 
          $Max_day_of_month = cal_days_in_month(CAL_GREGORIAN,$month,$year);
          $array_title = array(
            '現調日'
            ,'工事開始日'
            ,'連系日'
            ,'完工日'
          );
          $date = $year.'-'.$month.'-01';//star date of month
          $date = date('w', strtotime($date));
          $columnNumber = 7;
          $rowNumber = ceil(($date + $Max_day_of_month)/$columnNumber);
        ?>
        <table width="100%" border="0" cellspacing="0" cellpadding="5">
          <tbody>
            <tr>
              <td colspan="3">スケジュールを確認したい月を選択して下さい。</td>
            </tr>
          <tr>
            <td width="33%">
              <a href="<?=$urlCal."&curentmonth=$month&curentyear=$year&type=preview"?>">&lt;&lt; 前の月へ</a>
            </td>
            <td width="33%" align="center"><b><?=$year?>年<?=$month?>月</b></td>
            <td width="33%" align="right"><a href="<?=$urlCal."&curentmonth=".$month."&curentyear=$year&type=next"?>">次の月へ &gt;&gt;</a></td>
          </tr>
          </tbody>
        </table>
        <?php for ($table=0; $table < 4; $table++) { //4 table?>
          <?php
            $data = array(); 
            if($table === 0){
              $data = $dsprj_gencho_bi;
            }elseif($table === 1){
              $data = $dsprj_koji_kaishi_bi;
            }elseif($table ===2){
              $data = $dsprj_renkei_bi;
            }elseif ($table ===3) {
              $data = $dsprj_kanko_bi;
            }
          ?>
          <table width="100%" border="0" cellpadding="5" cellspacing="1" class="calendar_table">
            <tbody>
              <tr>
                <td colspan="7" align="center" style="background:#E7E7E7;">
                  <span class="col-bla33-b"><?=$array_title[$table]?></span>
                </td>
              </tr>
            </tbody>
          </table>
          <table width="100%" border="0" cellpadding="5" cellspacing="1" class="calendar_table">
            <tbody>
              <!-- tr header-->
              <tr>
                 <td align="center" class="col-33-bgf8">日</td>
                 <td align="center" class="col-33-bgff">月</td>
                 <td align="center" class="col-33-bgff">火</td>
                 <td align="center" class="col-33-bgff">水</td>
                 <td align="center" class="col-33-bgff">木</td>
                 <td align="center" class="col-33-bgff">金</td>
                 <td class="col-33-bgdc">土</td>
              </tr>
              <!-- end tr header-->
              <?php for ($tr=0; $tr < $rowNumber; $tr++) {//5 row in a table?>
                <?php if($tr == 0)
                {
                  $position = $date;
                  $star = 1;
                }
                ?>
                <tr>
                  <?php for($td = 0; $td < $columnNumber; $td++) { ?>
                    <?php if($td < $position && $tr == 0){ 
                     $star--;
                    ?>
                    <td align="center" class="col-33-bgff"> </td>
                    <?php }else{ ?> 
                    <td class="<?=$td==0?'col-33-bgf8':($td==6?'col-33-bgdc':'col-33-bgff')?>">
                      <div>
                          <?php 
                            if($star <= $Max_day_of_month)
                              echo $star;
                          ?>
                      </div>
                      <p>
                        <?php
                          for ($i=0, $count = count($data); $i <  $count; $i++) {
                            $day = null;
                            $timestamp_day = null;
                            if($table == 0){
                              $prj_gencho_bi = $data[$i]['prj_gencho_bi'];
                              $timestamp_day = strtotime($prj_gencho_bi);
                            }elseif($table == 1){
                              $prj_koji_kaishi_bi = $data[$i]['prj_koji_kaishi_bi'];
                              $timestamp_day = strtotime($prj_koji_kaishi_bi);
                            }elseif($table == 2){
                              $prj_renkei_bi = $data[$i]['prj_renkei_bi'];
                              $timestamp_day = strtotime($prj_renkei_bi);
                            }elseif($table == 3){
                              $prj_kanko_bi = $data[$i]['prj_kanko_bi'];
                              $timestamp_day = strtotime($prj_kanko_bi);
                            }
                            if($timestamp_day != null)
                              $day = date("d", $timestamp_day);
                            if($day !=null && $day == $star){
                              echo "<a href='".$headerUrlProject."&mode=edit&edit_prj_id=".$data[$i]["prj_id"]."'>".$data[$i]['prj_cust_name'].'('.$data[$i]['prj_id'].')</a><br>';
                            }
                          }
                        ?>
                      </p>
                      <p> 
                      </p>
                    </td>
                    <?php } ?>
                    <?php $star++; ?>
                  <?php } ?>
                </tr>
              <?php } ?>
            </tbody>
          </table>
          <br>
        <?php } ?>
        </div>
      </div>
    <div class="content noPad clearfix" id="DataArea"></div>
    </div><!-- End .box -->
  </div><!-- End .span12 -->
</div><!-- End .row-fluid -->
<!-- Page end here -->
</div><!-- End contentwrapper -->
</div>