<?php


class index extends default_admin_class
{
    var $before_date_y;

    function __construct()
    {
        parent::__construct();


echo "test;;;";
    }

    function main(){
        ?>
        <!--Body content-->
        <div id="content" class="clearfix">
			<div class="contentwrapper"><!--Content wrapper-->
				<div class="heading">
					<h3>ʪ�����</h3>
					<div class="resBtnSearch">
						<a href="#"><span class="icon16 icomoon-icon-search-3"></span></a>
					</div>
					<form name="SearchForm" id="SearchForm" action="/admin/article_list.php" method="post" autocomplete="off">
					<div class="search">
							<input type="text" name="post_key" id="tipue_search_input" class="top-search" placeholder="�����������..." value="" />
							<input type="submit" name="search" id="tipue_search_button" class="search-btn" value=""/>
					</div><!-- End search -->
				</form>
				</div><!-- End .heading-->
					<form name="ListForm" id="ListForm" action="/admin/article_list.php" method="post" autocomplete="off">
				<!-- Build page from here: Usual with <div class="row-fluid"></div> -->
				<div class="row-fluid">
					<div class="span12">
						<div class="box gradient">
							<div class="title">
								<h4>
									<span>�����84��</span>
									<div class="box-form right">
										<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
											<span class="icon16 icomoon-icon-cog-2"></span>
											<span class="caret"></span>
										</a>
										<ul class="dropdown-menu">
											<li><a href="javascript:void(0)" onclick="if(confirm('CSV�������ݡ��Ȥ�Ԥ��ޤ���\n\n��������Ǥ�����\n')==true){ListForm.post_mode.value='CSV�������ݡ���';ListForm.submit();ListForm.post_mode.value='';}"><span class="icon-pencil"></span> CSV�������ݡ���</a></li>
											<li><a href="javascript:void(0)" onclick="if(confirm('�����å����ܺ����Ԥ��ޤ���\n\n��������Ǥ�����\n')==true){ListForm.post_mode.value='�����å����ܺ��';ListForm.submit();ListForm.post_mode.value='';}"><span class="icon-pencil"></span> �����å����ܺ��</a></li>
										</ul>
									</div>
								</h4>
							</div>
							<div class="content noPad clearfix" id="DataArea">
					<form name="ListForm" id="ListForm" action="/admin/article_list.php" method="post" autocomplete="off">
<input type="hidden" name="post_search" id="post_search" value="" /><fieldset><label style="margin:0 5px 7px 0" for="post_act" class="select">
	<select name="post_act" id="post_act" onChange="ListForm.post_search.value=1;ListForm.submit();">
		<option value="" selected="selected">��(�����ե饰)</option>
		<option value="0">��α</option>
		<option value="1"><span class="orange">����</span></option>
		<option value="2"><span class="orange">�ȥåפ����������</span></option>
		<option value="8">��λʪ��</option>
	</select>
	</label>
<label style="margin:0 5px 7px 0" for="post_staff" class="select">
	<select name="post_staff" id="post_staff" onChange="ListForm.post_search.value=1;ListForm.submit();">
		<option value="" selected="selected">��(�����ʡ�)</option>
		<option value="1">�����ƥ������</option>
		<option value="2">?�����Ϲ�</option>
		<option value="3">ɴĻ��ͺ��</option>
		<option value="4">�ڲ���δ��</option>
		<option value="5">��¼���߹�̳</option>
		<option value="6">?SUMIDA</option>
		<option value="7">��ͥ�����</option>
		<option value="8">�ե������ȥ��饹</option>
		<option value="9">�����顼���ʥ���</option>
		<option value="10">�ϥ��֥�å�</option>
		<option value="11">�������WAKO</option>
	</select>
	</label>
<label style="margin:0 5px 7px 0" for="post_cate" class="select">
	<select name="post_cate" id="post_cate" onChange="ListForm.post_search.value=1;ListForm.submit();">
		<option value="" selected="selected">��(���ƥ���)</option>
		<option value="1">��Ư��</option>
		<option value="2">����Ϣ����</option>
		<option value="3">ID������</option>
	</select>
	</label>
<label style="margin:0 5px 7px 0" for="post_nedo_powercompany" class="select">
	<select name="post_nedo_powercompany" id="post_nedo_powercompany" onChange="ListForm.post_search.value=1;ListForm.submit();">
		<option value="" selected="selected">��(�ɳ����ϲ��)</option>
		<option value="11">�̳�ƻ����</option>
		<option value="12">��������</option>
		<option value="13">�������</option>
		<option value="14">��Φ����</option>
		<option value="15">��������</option>
		<option value="16">��������</option>
		<option value="17">�͹�����</option>
		<option value="18">�������</option>
		<option value="19">�彣����</option>
		<option value="20">��������</option>
	</select>
	</label>
<div style="clear:both;"><label style="margin:0 5px 7px 0" for="post_order" class="select">
	<select name="post_order" id="post_order" onChange="ListForm.post_search.value=1;ListForm.submit();">
		<option value="">��(�¤��ؤ�)</option>
		<option value="article_no">No</option>
		<option value="article_act">�����ե饰</option>
		<option value="article_status">�����ʪ��ե饰</option>
		<option value="article_staff">�����ʡ�</option>
		<option value="article_zip1">͹���ֹ�1</option>
		<option value="article_zip2">͹���ֹ�2</option>
		<option value="article_pref">��ƻ�ܸ�</option>
		<option value="article_addr1">�Զ�Į¼</option>
		<option value="article_addr2">���ܡ�����</option>
		<option value="article_gmap_latitude">�Ͽ�ɽ���Ѱ���</option>
		<option value="article_gmap_longitude">�Ͽ�ɽ���ѷ���</option>
		<option value="article_rail_pref1">ϩ��1��ƻ�ܸ�</option>
		<option value="article_rail_rr1">ϩ��1����</option>
		<option value="article_rail_line1">ϩ��1</option>
		<option value="article_rail_station1">�Ǵ���̾1</option>
		<option value="article_rail_time1">�Ǵ��ؤޤǤε�Υ��</option>
		<option value="article_rail_pref2">ϩ��2��ƻ�ܸ�</option>
		<option value="article_rail_rr2">ϩ��2����</option>
		<option value="article_rail_line2">ϩ��2</option>
		<option value="article_rail_station2">�Ǵ���̾2</option>
		<option value="article_rail_time2">�Ǵ��ؤޤǤε�Υ��</option>
		<option value="article_thumbimg">����ͥ����ѥ��᡼��</option>
		<option value="article_file">�ᥤ�󥤥᡼��</option>
		<option value="article_cap">�ᥤ�󥤥᡼������ץ����</option>
		<option value="article_cate">���ƥ���</option>
		<option value="article_id" selected="selected">����ID</option>
		<option value="article_name">ȯ�Ž�̾</option>
		<option value="article_kana">ȯ�Ž�̾�ʥ��ʡ�</option>
		<option value="article_catch">��������ʸ</option>
		<option value="article_description">�ܺ�����ʸ</option>
		<option value="article_access">��������</option>
		<option value="article_url">URL</option>
		<option value="article_capa">�����ƥ�����</option>
		<option value="article_price">�������</option>
		<option value="article_partition_num">����ֹ�</option>
		<option value="article_partition_totalnum">������</option>
		<option value="article_nedo_point">NEDO������̾</option>
		<option value="article_nedo_angle">NEDO�����г�</option>
		<option value="article_nedo_azimuth">NEDO�����̳�</option>
		<option value="article_nedo_solarradiation">NEDO��ǯʿ��������</option>
		<option value="article_nedo_price">NEDO��Ĵã����</option>
		<option value="article_nedo_generatecapa">NEDO��ǯ������ȯ����</option>
		<option value="article_nedo_salesrevenue">NEDO��ǯ���������ż���</option>
		<option value="article_nedo_yield">NEDO������ɽ�������</option>
		<option value="article_nedo_powercompany">NEDO���ɳ����ϲ��</option>
		<option value="article_nedo_output">NEDO����������</option>
		<option value="article_nedo_burdencharge">NEDO����������ô��</option>
		<option value="article_nedo_coopdate">NEDO��Ϣ��ǯ����</option>
		<option value="article_land_agreement">���ϡ����Ϸ���</option>
		<option value="article_land_tradingvalue">���ϡ�����������</option>
		<option value="article_land_rent">���ϡ������¼���</option>
		<option value="article_land_sitearea">���ϡ���������</option>
		<option value="article_modules_maker">�⥸�塼�롡�᡼����</option>
		<option value="article_modules_model">�⥸�塼�롡����</option>
		<option value="article_modules_capa">�⥸�塼�롡�����ƥ�����</option>
		<option value="article_power_maker">�ѥ拾�󡡥᡼����</option>
		<option value="article_power_model">�ѥ拾�󡡷���</option>
		<option value="article_power_capa">�ѥ拾�󡡺�������</option>
		<option value="article_etc_memo">�����åե��</option>
		<option value="article_free_title1">�ե꡼������̾</option>
		<option value="article_free_cont1">�ե꡼������</option>
		<option value="article_free_title2">�ե꡼������̾</option>
		<option value="article_free_cont2">�ե꡼������</option>
		<option value="article_free_title3">�ե꡼������̾</option>
		<option value="article_free_cont3">�ե꡼������</option>
		<option value="article_free_title4">�ե꡼������̾</option>
		<option value="article_free_cont4">�ե꡼������</option>
		<option value="article_free_title5">�ե꡼������̾</option>
		<option value="article_free_cont5">�ե꡼������</option>
		<option value="article_lastdate">�ǽ�������</option>
		<option value="article_date">��Ͽ��</option>
	</select>
	</label>
<label style="margin:0 5px 7px 0" for="post_sort" class="select">
	<select name="post_sort" id="post_sort" onChange="ListForm.post_search.value=1;ListForm.submit();">
		<option value="">����</option>
		<option value="desc">�߽�</option>
	</select>
	</label>
</div></fieldset><div class="center">
	<div class="pagination">
		<ul>
			<li class="active"><a href="/admin/article_list.php?post_page=1">1</a></li>
			<li><a href="/admin/article_list.php?post_page=2">2</a></li>
			<li><a href="/admin/article_list.php?post_page=3">3</a></li>
			<li><a href="/admin/article_list.php?post_page=4">4</a></li>
			<li><a href="/admin/article_list.php?post_page=5">5</a></li>
			<li><a href="/admin/article_list.php?post_page=2"><span class="icon12 minia-icon-arrow-right-2"></span></a></li>
			<li><a href="/admin/article_list.php?post_page=5"><span class="icon12 minia-icon-arrow-down-2"></span></a></li>
		</ul>
	</div>
</div>
<table id="DnDTable" cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered table-condensed" width="100%">
<thead><tr>
<th width="40" style="white-space:nowrap;">�Խ�</th>
<th width="40" style="white-space:nowrap;">����</th>
<th style="white-space:nowrap;">ʪ�勵����</th>
<th style="white-space:nowrap;">����ID</th>
<th style="white-space:nowrap;">�����ʡ�</th>
<th style="white-space:nowrap;">ȯ�Ž�̾</th>
<th style="white-space:nowrap;">���ƥ���</th>
<th style="white-space:nowrap;">����</th>
</tr></thead>

<tbody>
<tr id="80">
	<td style="text-align:center;"><button type="button" class="btn-success btn" onclick="location.href='article_mnt.php?search=1&article_no=80'">�Խ�</button></td>
	<td>��α</td>
	<td>�̾����ʪ��</td>
	<td>a0002</td>
	<td>�����ƥ������</td>
	<td><a href="http://solorpanel.sysdemo.net/article/?no=80&access_key=U2FsdGVkX1%2BcJBt2rtg1x2zAR3tlLs4QaWzGSGwrAhvpmKLQibWE6hH8Scj27uFG" target="_blank">�ƥ���</a></td>
	<td>��Ư��</td>
	<td>���縩��������</td>
</tr><tr id="84">
	<td style="text-align:center;"><button type="button" class="btn-success btn" onclick="location.href='article_mnt.php?search=1&article_no=84'">�Խ�</button></td>
	<td><span class="orange">����</span></td>
	<td>�̾����ʪ��</td>
	<td>B001</td>
	<td>�����顼���ʥ���</td>
	<td><a href="http://solorpanel.sysdemo.net/article/?no=84&access_key=U2FsdGVkX18Q3e7ArmEFeh6dFXBGaQW%2FP58R3qw9%2BdYiwzNH67GOyHSw8sJfRbdU" target="_blank">ʡ��ز���ȯ�Ž�</a></td>
	<td>����Ϣ����</td>
	<td>ʡ�縩ʡ��Ի���</td>
</tr><tr id="2">
	<td style="text-align:center;"><button type="button" class="btn-success btn" onclick="location.href='article_mnt.php?search=1&article_no=2'">�Խ�</button></td>
	<td><span class="orange">����</span></td>
	<td>�̾����ʪ��</td>
	<td>C001</td>
	<td>��¼���߹�̳</td>
	<td><a href="http://solorpanel.sysdemo.net/article/?no=2&access_key=U2FsdGVkX1%2Bcg3r4zIsk0D0DgDRy5Bj8rNDNGNgMdRFXbzw4li%2FNVbAwQFjR8iGd" target="_blank">���裴ȯ�Ž�</a></td>
	<td>����Ϣ����</td>
	<td>��̸���뷴��Į</td>
</tr><tr id="16">
	<td style="text-align:center;"><button type="button" class="btn-success btn" onclick="location.href='article_mnt.php?search=1&article_no=16'">�Խ�</button></td>
	<td><span class="orange">����</span></td>
	<td>�̾����ʪ��</td>
	<td>C002</td>
	<td>��¼���߹�̳</td>
	<td><a href="http://solorpanel.sysdemo.net/article/?no=16&access_key=U2FsdGVkX1%2Fk%2BHT74Q9hTi%2F%2BRuYGZkUzuGLiJaOjLXEw2ga7LXf1lapmYjXr5jvU" target="_blank">���������۸�ȯ�Ž�</a></td>
	<td>����Ϣ����</td>
	<td>�Ų�������Ա�����</td>
</tr><tr id="41">
	<td style="text-align:center;"><button type="button" class="btn-success btn" onclick="location.href='article_mnt.php?search=1&article_no=41'">�Խ�</button></td>
	<td>��α</td>
	<td>�̾����ʪ��</td>
	<td>C003</td>
	<td>?�����Ϲ�</td>
	<td><a href="http://solorpanel.sysdemo.net/article/?no=41&access_key=U2FsdGVkX18FwfGNGlRpudXWBcJBcAbkd8ycBhIjJRt1TGDUx3SPHeqAqXXt%2FkhB" target="_blank">���㰵14�������ո������</a></td>
	<td>ID������</td>
	<td>���ո������</td>
</tr><tr id="42">
	<td style="text-align:center;"><button type="button" class="btn-success btn" onclick="location.href='article_mnt.php?search=1&article_no=42'">�Խ�</button></td>
	<td>��α</td>
	<td>�̾����ʪ��</td>
	<td>C006</td>
	<td>?�����Ϲ�</td>
	<td><a href="http://solorpanel.sysdemo.net/article/?no=42&access_key=U2FsdGVkX1%2FIb%2Fyx1VeerQIq0VpFdiSixBBrz8XGUuzFCvfH8WT5rl7E4MCJRMbf" target="_blank">��̳��ȯ�Ž�</a></td>
	<td>ID������</td>
	<td>���츩��̳����</td>
</tr><tr id="32">
	<td style="text-align:center;"><button type="button" class="btn-success btn" onclick="location.href='article_mnt.php?search=1&article_no=32'">�Խ�</button></td>
	<td><span class="orange">����</span></td>
	<td>�̾����ʪ��</td>
	<td>C012</td>
	<td>��ͥ�����</td>
	<td><a href="http://solorpanel.sysdemo.net/article/?no=32&access_key=U2FsdGVkX18huOBeNr%2BeYgz%2BGTHH5Q2TcM1b7QMWgkEC0rlUCvoMsH6FllyJRKtg" target="_blank">������ڻ����۸�ȯ�Ž�?</a></td>
	<td>����Ϣ����</td>
	<td>���ڸ�����Բ��ڻ�</td>
</tr><tr id="33">
	<td style="text-align:center;"><button type="button" class="btn-success btn" onclick="location.href='article_mnt.php?search=1&article_no=33'">�Խ�</button></td>
	<td><span class="orange">����</span></td>
	<td>�̾����ʪ��</td>
	<td>C013</td>
	<td>��ͥ�����</td>
	<td><a href="http://solorpanel.sysdemo.net/article/?no=33&access_key=U2FsdGVkX19m8h3MzyH9gXYiKFYWfSeZjqEv6cXSPNP11axCPUl5pjHhap5HczyZ" target="_blank">����Į���ڻ����۸�ȯ�Ž�?</a></td>
	<td>����Ϣ����</td>
	<td>���ڸ�����Բ��ڻ�</td>
</tr><tr id="82">
	<td style="text-align:center;"><button type="button" class="btn-success btn" onclick="location.href='article_mnt.php?search=1&article_no=82'">�Խ�</button></td>
	<td><span class="orange">����</span></td>
	<td>�̾����ʪ��</td>
	<td>C014</td>
	<td>��ͥ�����</td>
	<td><a href="http://solorpanel.sysdemo.net/article/?no=82&access_key=U2FsdGVkX1994tK6l7YEOUZwf7CoSf3c2VSHeJ1dfil7RJ%2FGzTsx%2Ff4KnHfmXX6H" target="_blank">¿�����ⰵ���۸�ȯ�Ž�</a></td>
	<td>����Ϣ����</td>
	<td>���츩¿������</td>
</tr><tr id="30">
	<td style="text-align:center;"><button type="button" class="btn-success btn" onclick="location.href='article_mnt.php?search=1&article_no=30'">�Խ�</button></td>
	<td><span class="orange">����</span></td>
	<td>�̾����ʪ��</td>
	<td>C017</td>
	<td>�ե������ȥ��饹</td>
	<td><a href="http://solorpanel.sysdemo.net/article/?no=30&access_key=U2FsdGVkX1%2Fws%2B0GrODIwE8IxlMN0AJ4AmunIM%2FOMWNk0tZi3N%2FOkXF6bdn18dZc" target="_blank">�ڱ��Կ�ΩĮ���۸�ȯ�Ž�</a></td>
	<td>��Ư��</td>
	<td>��븩�ڱ��Կ�ΩĮ�����</td>
</tr><tr id="31">
	<td style="text-align:center;"><button type="button" class="btn-success btn" onclick="location.href='article_mnt.php?search=1&article_no=31'">�Խ�</button></td>
	<td><span class="orange">����</span></td>
	<td>�̾����ʪ��</td>
	<td>C018</td>
	<td>�ե������ȥ��饹</td>
	<td><a href="http://solorpanel.sysdemo.net/article/?no=31&access_key=U2FsdGVkX18rraBLYlxxALNs%2BnwWqcBmg5o3qAR2naZSSFoZzgHoKx7GYFabfZt5" target="_blank">�������۸�ȯ�Ž�</a></td>
	<td>��Ư��</td>
	<td>���ո����ĻԴ���</td>
</tr><tr id="75">
	<td style="text-align:center;"><button type="button" class="btn-success btn" onclick="location.href='article_mnt.php?search=1&article_no=75'">�Խ�</button></td>
	<td>��α</td>
	<td>�̾����ʪ��</td>
	<td>C020</td>
	<td>��¼���߹�̳</td>
	<td><a href="http://solorpanel.sysdemo.net/article/?no=75&access_key=U2FsdGVkX1%2FZy4JBly9xVQgPl8Fc6DpnwfhVYJORWH4T91kFa5qPA7FWoKpHT6Gw" target="_blank">��ϲ���۸�ȯ�Ž�</a></td>
	<td>����Ϣ����</td>
	<td>���츩��ϲ��</td>
</tr><tr id="83">
	<td style="text-align:center;"><button type="button" class="btn-success btn" onclick="location.href='article_mnt.php?search=1&article_no=83'">�Խ�</button></td>
	<td>��α</td>
	<td>�̾����ʪ��</td>
	<td>C021</td>
	<td>&nbsp;</td>
	<td><a href="http://solorpanel.sysdemo.net/article/?no=83&access_key=U2FsdGVkX1%2BYV9rSVgxxtGQMET11Qxf58F5TlxS0pBveg6%2BiQ3HjqnbTqua75FWp" target="_blank">���ջ����۸�ȯ�Ž�</a></td>
	<td>����Ϣ����</td>
	<td>Ĺ���׷�</td>
</tr><tr id="43">
	<td style="text-align:center;"><button type="button" class="btn-success btn" onclick="location.href='article_mnt.php?search=1&article_no=43'">�Խ�</button></td>
	<td>��α</td>
	<td>�̾����ʪ��</td>
	<td>D001</td>
	<td>?�����Ϲ�</td>
	<td><a href="http://solorpanel.sysdemo.net/article/?no=43&access_key=U2FsdGVkX1%2BLg5Zlk592knZ0M3i%2BbYa71fb7VvTIgnQwQdjNevDXyxJNKov%2FJYSy" target="_blank">����1ȯ�Ž�</a></td>
	<td>ID������</td>
	<td>���θ�˭�Ļ�</td>
</tr><tr id="44">
	<td style="text-align:center;"><button type="button" class="btn-success btn" onclick="location.href='article_mnt.php?search=1&article_no=44'">�Խ�</button></td>
	<td><span class="orange">����</span></td>
	<td>�̾����ʪ��</td>
	<td>D002</td>
	<td>?�����Ϲ�</td>
	<td><a href="http://solorpanel.sysdemo.net/article/?no=44&access_key=U2FsdGVkX1%2BzDrEK4RWttWMvj%2BlAtEVd0DOOoezLpdK6C733aVI0Qr0K0Rd8C1dg" target="_blank">����ȯ�Ž�</a></td>
	<td>����Ϣ����</td>
	<td>���θ�˭�Ļ�</td>
</tr><tr id="45">
	<td style="text-align:center;"><button type="button" class="btn-success btn" onclick="location.href='article_mnt.php?search=1&article_no=45'">�Խ�</button></td>
	<td><span class="orange">����</span></td>
	<td>�̾����ʪ��</td>
	<td>D003</td>
	<td>?�����Ϲ�</td>
	<td><a href="http://solorpanel.sysdemo.net/article/?no=45&access_key=U2FsdGVkX1%2BbzRd%2FcDZmDlroUGl%2FsfXQWRRGLX4a1X1NLJ7D0vTJ2b9euCD8Qlad" target="_blank">��Ȫȯ�Ž�</a></td>
	<td>����Ϣ����</td>
	<td>���θ�˭�Ļ�</td>
</tr><tr id="46">
	<td style="text-align:center;"><button type="button" class="btn-success btn" onclick="location.href='article_mnt.php?search=1&article_no=46'">�Խ�</button></td>
	<td><span class="orange">����</span></td>
	<td>�̾����ʪ��</td>
	<td>D005</td>
	<td>?�����Ϲ�</td>
	<td><a href="http://solorpanel.sysdemo.net/article/?no=46&access_key=U2FsdGVkX19DAarBEr7dNHT%2FJ%2FxjVBBZjxoZnpJQ%2BSI6SV5J0gRvY9g3JWAx7ppW" target="_blank">������Ȫ25ȯ�Ž�</a></td>
	<td>����Ϣ����</td>
	<td>���θ�˭�Ļ�</td>
</tr><tr id="5">
	<td style="text-align:center;"><button type="button" class="btn-success btn" onclick="location.href='article_mnt.php?search=1&article_no=5'">�Խ�</button></td>
	<td>��α</td>
	<td>�̾����ʪ��</td>
	<td>D006</td>
	<td>ɴĻ��ͺ��</td>
	<td><a href="http://solorpanel.sysdemo.net/article/?no=5&access_key=U2FsdGVkX1%2FAnW3L7Hs8CGfr18teoLHHj%2F620Mzyw7Og4OfLSu4isc6AjBPeIbnU" target="_blank">����ò���㰵�Ʒ�</a></td>
	<td>ID������</td>
	<td>����ò��</td>
</tr><tr id="14">
	<td style="text-align:center;"><button type="button" class="btn-success btn" onclick="location.href='article_mnt.php?search=1&article_no=14'">�Խ�</button></td>
	<td>��α</td>
	<td>�̾����ʪ��</td>
	<td>E002</td>
	<td>��¼���߹�̳</td>
	<td><a href="http://solorpanel.sysdemo.net/article/?no=14&access_key=U2FsdGVkX1%2BlflX7%2FkyOC7K6jP8wSx2gjv5xDY%2F4SMtdZ9WXdIhhS2AuZiqFmteE" target="_blank">���ȯ�Ž�</a></td>
	<td>ID������</td>
	<td>���ɸ����ɻ����Į</td>
</tr><tr id="18">
	<td style="text-align:center;"><button type="button" class="btn-success btn" onclick="location.href='article_mnt.php?search=1&article_no=18'">�Խ�</button></td>
	<td>��α</td>
	<td>�̾����ʪ��</td>
	<td>E004</td>
	<td>��¼���߹�̳</td>
	<td><a href="http://solorpanel.sysdemo.net/article/?no=18&access_key=U2FsdGVkX1%2FGuSpaiz4XtQ6FRByC6ftu%2BPyqRU6KYYBfI7NeDqEth8VRfvZqXidw" target="_blank">��¼ȯ�Ž�</a></td>
	<td>ID������</td>
	<td>�����ܵ����Ե���Į�����ظ�</td>
</tr></tbody>
<tfoot><tr>
<th width="40" style="white-space:nowrap;">�Խ�</th>
<th width="40" style="white-space:nowrap;">����</th>
<th style="white-space:nowrap;">ʪ�勵����</th>
<th style="white-space:nowrap;">����ID</th>
<th style="white-space:nowrap;">�����ʡ�</th>
<th style="white-space:nowrap;">ȯ�Ž�̾</th>
<th style="white-space:nowrap;">���ƥ���</th>
<th style="white-space:nowrap;">����</th>
</tr></tfoot>

</table><br /><div class="center">
	<div class="pagination">
		<ul>
			<li class="active"><a href="/admin/article_list.php?post_page=1">1</a></li>
			<li><a href="/admin/article_list.php?post_page=2">2</a></li>
			<li><a href="/admin/article_list.php?post_page=3">3</a></li>
			<li><a href="/admin/article_list.php?post_page=4">4</a></li>
			<li><a href="/admin/article_list.php?post_page=5">5</a></li>
			<li><a href="/admin/article_list.php?post_page=2"><span class="icon12 minia-icon-arrow-right-2"></span></a></li>
			<li><a href="/admin/article_list.php?post_page=5"><span class="icon12 minia-icon-arrow-down-2"></span></a></li>
		</ul>
	</div>
</div>
</form>								</div>
							</div><!-- End .box -->
						</div><!-- End .span12 -->
					</div><!-- End .row-fluid -->
				<!-- Page end here -->
			</div><!-- End contentwrapper -->
		</div><!-- End #content -->
        </div><!-- End #wrapper -->
        <?php

    }


}