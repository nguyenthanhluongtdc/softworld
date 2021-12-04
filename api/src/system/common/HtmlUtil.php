<?php

class HtmlUtil {

	public static function paggingHeader($totalRow, $targetForm, $pageSize = null, $paggingStype = 1, $cssClass = "common-list1") {
		$html = "";
		if($paggingStype == 1) {
			$html = "<table class='$cssClass form pagging-header' width='700px;' target-form='".$targetForm."'>
	            <tr>
	                <td nowrap=nowrap class='common-list-title-left' style='border:0px;priority'> 
	                	総件数：$totalRow データ<br />
	                </td>
	                <td nowrap=nowrap class='common-list-title-right' style='border:0px;priority'>
	                    Hiển thị: ";
	        $html .= HtmlUtil::dropList("page_size", AppConfig::$LIST_PAGE_SIZE, (isset($pageSize) ? $pageSize : AppConfig::$DEFAULT_PAGE_SIZE));
			$html .= "データ";
	        $html .= "</td>
	            </tr>
	        </table>";	
		}
		elseif($paggingStype == 2)
		{
			$html = "<!-- begin page info -->";
			$html .= "<div class='title'>";
	            $html .= "<h4>";
	                $html .= "<span>Tổng: ".$totalRow." trường</span>";
	                $html .= "<div class='row_selecter'>";
	                    $html .="<table class='row_selecter_table pagging-header' target-form='".$targetForm."'>";
	                        $html .="<tbody>";
		                        $html .="<tr>";
		                            $html .="<td nowrap=''  class='common-list-title-right'> Hiển thị： ";
 										$html .= HtmlUtil::dropList("page_size", AppConfig::$LIST_PAGE_SIZE, (isset($pageSize) ? $pageSize : AppConfig::$DEFAULT_PAGE_SIZE),null,null,null,array());
		                                $html .= ' trường';
		                            $html .="</td>";
		                        $html .="</tr>";
	                    	$html .="</tbody>";
	                    $html .="</table>";
	                $html .="</div>";
	            $html .= "</h4>";
	        $html .= "</div>";
	        $html .= "<!-- end page info -->";
		}
		return $html;
	}

	public static function paggingFooter($currentPage, $pageSize, $totalRow, $targetForm, $paggingStype = 1) {
		$maxPage = ceil($totalRow/$pageSize);
		if($currentPage > 1 && $currentPage > $maxPage) {
			$currentPage = $maxPage;
		}

		$html = "<div class='pagging' target-form='".$targetForm."'>";
		if($paggingStype == 1) {
			if($currentPage > 1) {
				$html .= "<a href='#' page='1'>&lt;&lt;</a>";
				$html .= "<a href='#' page='" . ($currentPage - 1) . "'>&lt;</a>";
			} else {
				$html .= "<span>&lt;&lt;</span>";
				$html .= "<span>&lt;</span>";
			}
			$html .= "<span>".$currentPage."/".$maxPage."</span>";
			if($currentPage < $maxPage) {
				$html .= "<a href='#' page='" . ($currentPage + 1) . "'>&gt;</a>";
				$html .= "<a href='#' page='" . $maxPage . "''>&gt;&gt;</a>";
			} else {
				$html .= "<span>&gt;</span>";
				$html .= "<span>&gt;&gt;</span>";
			}
				
		} else if($paggingStype == 2) {
			if($currentPage > 1) {
				$html .= "<a href='#' page='1'>&lt;&lt;</a>";
				$html .= "<a href='#' page='" . ($currentPage - 1) . "'>&lt;</a>";
			} else {
				$html .= "<span>&lt;&lt;</span>";
				$html .= "<span>&lt;</span>";
			}
			if($maxPage == 1) {
				$html .= "<span>".$currentPage."/".$maxPage."</span>";
			} else {
				$html .= "<span>
					<input id='mypage' size='4' style='ime-mode:disabled' value='$currentPage'/>
					/$maxPage<input type='button' value='ページジャンプ' class='button'/>
					</span>";
			}
			if($currentPage < $maxPage) {
				$html .= "<a href='#' page='" . ($currentPage + 1) . "'>&gt;</a>";
				$html .= "<a href='#' page='" . $maxPage . "''>&gt;&gt;</a>";
			} else {
				$html .= "<span>&gt;</span>";
				$html .= "<span>&gt;&gt;</span>";
			}
		}
		elseif ($paggingStype == 3) {
			$html = "";
				$html .="<div class='center'><div class='pagination pagging' target-form='".$targetForm."'><ul>";
				if($currentPage == 1){
					$html .="<li class='active'><a href='#' page='" . ($currentPage) . "'>1</a></li>";
					for($i=2; $i<=5 ;$i++){
						if($i <= $maxPage)
							$html .="<li><a href='#' page='" . ($i) . "'>".($i)."</a></li>";
					}
				}
				elseif($currentPage == $maxPage){
					for($i=($maxPage-4); $i < $maxPage; $i++){
						if($i >= 1)
							$html .="<li><a href='#' page='" . ($i) . "'>".($i)."</a></li>";	
					}
					$html .="<li class='active'><a href='#' page='" . ($maxPage) . "'>".$maxPage."</a></li>";
				}
				elseif($currentPage == 2 && $maxPage >= $currentPage){
						$html .="<li><a href='#' page='" . ($currentPage-1) . "'>1</a></li>";
						$html .="<li class='active'><a href='#' page='" . ($currentPage) . "'>".$currentPage."</a></li>";
						for($i=$currentPage+1;$i<$currentPage+4 && $i <= $maxPage;$i++){
							$html .="<li><a href='#' page='" . ($i) . "'>".($i)."</a></li>";
						}
				}
				else{
					if(!($maxPage >= ($currentPage +2)) && ($currentPage-4) >=1 ){
						$html .= "<li><a href='#' page='" . ($currentPage-4) . "'>".($currentPage-4)."</a></li>";
					}
					if(!($maxPage >= ($currentPage+1)) && ($currentPage -3) >= 1 ){
						$html .= "<li><a href='#' page='" . ($currentPage-3) . "'>".($currentPage-3)."</a></li>";
					}
					$html .="<li><a href='#' page='" . ($currentPage-2) . "'>".($currentPage-2)."</a></li>";
					$html .="<li><a href='#' page='" . ($currentPage-1) . "'>".($currentPage-1)."</a></li>";
					$html .="<li class='active'><a href='#' page='" . ($currentPage) . "'>".($currentPage)."</a></li>";
					if($maxPage >= $currentPage+1)
						$html .="<li><a href='#' page='" . ($currentPage+1) . "'>".($currentPage+1)."</a></li>";
					if($maxPage >= $currentPage +2)
						$html .="<li><a href='#' page='" . ($currentPage+2) . "'>".($currentPage+2)."</a></li>";

				}
            	$html .="<li><a href='#' page='" . ($maxPage > $currentPage ? $currentPage + 1 : $currentPage) . "'><span class='icon12 minia-icon-arrow-right-2'></span></a></li>";
            	$html .="<li><a href='#' page='" . $maxPage . "''><span class='icon12 minia-icon-arrow-down-2'></span></a></li>";
				$html .="</ul></div>";
		}
		$html .= '</div>';
		return $html;
	}

	public static function sortControl($nColumn, $sortColumn, $targetForm) {
		$sortColsKey = array_keys($sortColumn);
		$html = "<tr class='sort-data-table' target-form='$targetForm'>";

		for ($i=0; $i < $nColumn; $i++) { 
			if(in_array($i, $sortColsKey)) {
		        $html .= "<td nowrap class='common-list-value'>
					<a sort='".$sortColumn[$i]." asc' href='#'>▲</a>
					<a sort='".$sortColumn[$i]." desc' href='#'>▼</a>
		        </td>";

			} else {
		        $html .= "<td nowrap class='common-list-value'></td>";
			}
		}
		return $html . "</tr>";
	}
	public static function dropList($elementName, $values, $selected
		, $valueMember = null, $displayMember = null
		, $dynamicAttribues = null
		, $defaults = array("" => "")
		, $cssClass = null
		, $event = null
	) {
		$events =null;
		if(!empty($event))
			foreach ($event as $key => $value) {
				$events .= $key.'='.$value;
			}
		$html = "<select id='" . $elementName . "' name='" . $elementName . "' class = '".$cssClass."' ".$events.">";
		if($defaults) {
			foreach ($defaults as $key => $value) {
				$html .= "<option value='$key'>$value</option>";
			}	
		}
		if(!empty($valueMember) && !empty($displayMember)) {
			foreach ($values as $value) {
				// create attributes
				$attributes = "";
				if(isset($dynamicAttribues) && is_array($dynamicAttribues)) {
					foreach ($dynamicAttribues as $key => $attrKey) {
						if(array_key_exists($attrKey, $value)) {
							$attributes .= " $key='$value[$attrKey]' ";
						}
					}
				}
				if($value[$valueMember] == $selected) {
					$html .= "<option $attributes value='" . $value[$valueMember] . "' selected>" . $value[$displayMember] . "</option>";
				} else {
					$html .= "<option $attributes value='" . $value[$valueMember] . "'>" . $value[$displayMember] . "</option>";
				}
			}
		} else {
			foreach ($values as $key => $value) {
				if($key == $selected) {
					$html .= "<option value='$key' selected>$value</option>";
				} else {
					$html .= "<option value='$key'>$value</option>";
				}
			}	
		}
		
		$html .= "</select>";
		return $html;
	}
    
    public static function dropListLable($values, $selected, $valueMember, $displayMember) {
        
        $html = '';
        foreach ($values as $value) {
            if($value[$valueMember] == $selected) {
                $html = $value[$displayMember];
                break;
            }
        }
        return $html;
    }
    public static function radioButtons($elementName, $values, $checked, $valueMember = null, $displayMember = null, $inline = null) {
		if($inline=='block')
			$b = "<br>";
        $html = "<div class='list-radio' id='$elementName'>";
        if(!StringUtil::isNullOrEmpty($valueMember) && !StringUtil::isNullOrEmpty($displayMember)) {
            foreach ($values as $value) {
                if($value[$valueMember] == $checked) {
                    $html .= "<label style='display: inline;'><input type='radio' value='" . $value[$valueMember] . "' checked='checked' name='" . $elementName . "' />" . $value[$displayMember] . " &nbsp;&nbsp;&nbsp </lable>".$b;
                } else {
                    $html .= "<label style='display: inline;'><input type='radio' value='" . $value[$valueMember] . "' name='" . $elementName . "'  />" . $value[$displayMember] . " &nbsp;&nbsp;&nbsp</label> ".$b;
                }
            }
        } else {
            foreach ($values as $key => $value) {
                if($key == $checked) {
                    $html .= "<label style='display: inline;'><input type='radio' value='$key' checked='checked' name='" . $elementName . "'  />$value" . " &nbsp;&nbsp;&nbsp</label> ".$b;
                } else {
                    $html .= "<label style='display: inline;'><input type='radio' value='$key' name='" . $elementName . "' />$value" . " &nbsp;&nbsp;&nbsp </label>".$b;
                }
            }    
        }
        return $html . "</div>";
    }
    public static function checkBoxs($elementName, $values, $arrChecked, $valueMember = null, $displayMember = null, $br=null){
    	$elementName = HtmlUtil::repareElementNameForList($elementName);
		var_dump($elementName);
    	$div_id = str_replace('[]','',$elementName);
        $html = "<div class='form_radio' id='$div_id'>";
        if(!empty($valueMember) && !empty($displayMember)) {
            foreach ($values as $value) {
                if(!empty($arrChecked) && in_array($value[$valueMember], $arrChecked)) {
                    $html .= "<label style='display: inline;'><input type='checkbox' value='$value[$valueMember]' checked='checked' name='" . $elementName . "'  class='form_radio' />&nbsp;".$value[$displayMember]."</label>" . $br;
                } else {
                    $html .= "<label style='display: inline;'><input type='checkbox' value='$value[$valueMember]' name='" . $elementName . "'  class='form_radio' />&nbsp;".$value[$displayMember]."</label>" . $br;
                }
            }
        } else {
            foreach ($values as $key => $value) {
                if(!empty($arrChecked) && in_array($key, $arrChecked)) {
                    $html .= "<label style='display: inline;'><input type='checkbox' value='$key' checked='checked' name='" . $elementName . "'  class='form_radio'  />&nbsp;$value</label>" . $br;
                } else {
                    $html .= "<label style='display: inline;'><input type='checkbox' value='$key' name='" . $elementName . "' class='form_radio' />&nbsp;".$value."</label>&nbsp;&nbsp;" . $br;
                }
            } 
        }
        return $html . "</div>";
    }

    public static function dateInput($elementName, $value, $format = "Y-m-d", $isyearmonth = false, $afterContent = '', $style = '', $isNowIfEmpty = false){
    	$date = DateUtil::dateToArray($value, $format, $isNowIfEmpty);
    	$year = $date["year"];
        $month = $date["month"];
        $day = $date["day"];

        $html = "";
    	if($isyearmonth) {
    		if(!StringUtil::isNullOrEmpty($year) 
    			|| !StringUtil::isNullOrEmpty($month)) {
				$dateValue = "$year-$month";
	        }
	        $html = "<div id='" . $elementName . "' class='date-input' $style>
	        <input type='text' class='year' value='$year' size='6' maxlength='6'>&nbsp;年&nbsp;&nbsp;
	        <input type='text' class='month' value='$month' size='4' maxlength='4'>&nbsp;月&nbsp;&nbsp;
	        <input type='hidden' class='ymd' name='$elementName' value='$dateValue'>$afterContent</div>";
    	} else {
    		if(!StringUtil::isNullOrEmpty($year) 
    			|| !StringUtil::isNullOrEmpty($month) 
        		|| !StringUtil::isNullOrEmpty($day)) {
				$dateValue = "$year-$month-$day";
	        }

	        $html = "<div id='" . $elementName . "' class='date-input' $style>
	        <input type='text' class='year' value='$year' size='6' maxlength='6'>&nbsp;年&nbsp;&nbsp;
	        <input type='text' class='month' value='$month' size='4' maxlength='4'>&nbsp;月&nbsp;&nbsp;
	        <input type='text' class='day' value='$day' size='4' maxlength='4'>&nbsp;日
	        <input type='hidden' class='ymd' name='$elementName' value='$dateValue'>$afterContent</div>";
    	}
        return $html;
    }
    
    public static function dateLable($value, $format = "Y-m-d", $isyearmonth = false){
        $date = DateUtil::dateToArray($value, $format);
        $year = $date["year"];
        $month = $date["month"];
        $day = !$isyearmonth ? $date["day"] : '';
        $daytext = !$isyearmonth ? '&nbsp;日' : '';
        $html = "$year&nbsp;年&nbsp;&nbsp;$month&nbsp;月&nbsp;&nbsp;$day$daytext";
        return $html;
    }

    private static function repareElementNameForList($name) {
    	if(!StringUtil::endsWith($name, "[]")) {
    		$name = $name."[]";
    	}
    	return $name;
    }

    public static function CalendarInput($name,$value){
	   	$year = 0;
	   	$month = 0;
	   	$date = 0;
	   	$value = str_replace('-', '/', $value);
	   	if(!StringUtil::isNullOrEmpty($value)){
	   		$day = explode('/', $value);
	   		$year = $day[0];
	   		$month = $day[1];
	   		$date = $day[2];
	   	}
		$html = 	"<div class='calendar' id='$name' style='display: inline;'>";
		               	 $html .= HtmlUtil::dropList($name.'_year', AppConfig::$YEAR, $year, "", "", "", array(), "selectbox_year");
		                 $html .= " 年 ";
		                 $html .= HtmlUtil::dropList($name.'_month', AppConfig::$MONTH, $month, "", "", "", array(),  "selectbox_month_day");
		                 $html .= " 月 ";
		                 $html .= HtmlUtil::dropList($name.'_day', AppConfig::$DATE, $date, "", "", "", array(),  "selectbox_month_day");
		                 $html .= " 日 ";
		$html .= "<input type='text'  id='".$name."_datetime_picker' name='$name' value='$value' class='datetime_picker input-medium ime_off' style='display:none;' > 
		               </div>
		               <input type='button' value='クリア' id='".$name."_clear' class='calendar_clear_button'>
";
			return $html;
    }

    public static function UploadFileInput($name,$value,$value_tmp, $accept=null){
	    $html =    "<input type='hidden' name='".$name."_tmp' value='".$value_tmp."'>
	               <input type='hidden' name='".$name."_tmp_recent' id='".$name."_tmp_recent' value='1'> 
	               <!--back from preview-->
	               <input type='hidden' name='".$name."_recent_name' id='".$name."_recent_name' value='".$value."'>
	               <input type='file' name='".$name."' id='".$name."'".$accept." >";
	    if(!StringUtil::isNullOrEmpty($value))
	    $html .=  "<lable class='".$name."' >".$value. "</lable>
	               <span id='".$name."_delete' class='button'>X</span>
	               <script>$('#".$name."').on('change', function(){ $('.".$name."').addClass('hide'); $('#".$name."_delete').hide(); $('#".$name."_tmp_recent').val(3); });
	                       $('#".$name."_delete').on('click', function() { $('.".$name."').addClass('hide'); $(this).hide(); $('#".$name."_tmp_recent').val(2); });
	              </script>";
	    return $html;
    }
    public static function AddSpaceStrPdf($str, $format=''){
        return StringUtil::isNullOrEmpty($str) ? '&nbsp;' : $str;
    }
}

?>