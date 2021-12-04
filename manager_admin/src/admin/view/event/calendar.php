
<script>

    
</script>

<style>

  body {
    margin: 40px 10px;
    padding: 0;
    font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
    font-size: 14px;
  }

  #calendar, .note {
    max-width: 1100px;
    margin: 0 auto;
    display: flex;
    flex-direction: column;
  }

  #calendar a{
    color: black;
  }

  .note ul{
    display: flex;
    flex-wrap: wrap;
  }

  .note ul li{
    display: flex; 
    align-items: center;
    width: 30.333%;
  }

  .note ul li span:first-child{
    width: 10px; 
    height: 10px;
    border: 1px solid black;
    display: inline-block;
    margin-right: 5px;
  }

  /*
  i wish this requiredd CSS was better documented :(
  https://github.com/FezVrasta/popper.js/issues/674
  derived from this CSS on this page: https://popper.js.org/tooltip-examples.html
  */

  .popper,
  .tooltip {
    position: absolute;
    z-index: 9999;
    background: #FFC107;
    color: black;
    width: 150px;
    border-radius: 3px;
    box-shadow: 0 0 2px rgba(0,0,0,0.5);
    padding: 10px;
    text-align: center;
  }
  .style5 .tooltip {
    background: #1E252B;
    color: #FFFFFF;
    max-width: 200px;
    width: auto;
    font-size: .8rem;
    padding: .5em 1em;
  }
  .popper .popper__arrow,
  .tooltip .tooltip-arrow {
    width: 0;
    height: 0;
    border-style: solid;
    position: absolute;
    margin: 5px;
  }

  .tooltip .tooltip-arrow,
  .popper .popper__arrow {
    border-color: #FFC107;
  }
  .style5 .tooltip .tooltip-arrow {
    border-color: #1E252B;
  }
  .popper[x-placement^="top"],
  .tooltip[x-placement^="top"] {
    margin-bottom: 5px;
  }
  .popper[x-placement^="top"] .popper__arrow,
  .tooltip[x-placement^="top"] .tooltip-arrow {
    border-width: 5px 5px 0 5px;
    border-left-color: transparent;
    border-right-color: transparent;
    border-bottom-color: transparent;
    bottom: -5px;
    left: calc(50% - 5px);
    margin-top: 0;
    margin-bottom: 0;
  }
  .popper[x-placement^="bottom"],
  .tooltip[x-placement^="bottom"] {
    margin-top: 5px;
  }
  .tooltip[x-placement^="bottom"] .tooltip-arrow,
  .popper[x-placement^="bottom"] .popper__arrow {
    border-width: 0 5px 5px 5px;
    border-left-color: transparent;
    border-right-color: transparent;
    border-top-color: transparent;
    top: -5px;
    left: calc(50% - 5px);
    margin-top: 0;
    margin-bottom: 0;
  }
  .tooltip[x-placement^="right"],
  .popper[x-placement^="right"] {
    margin-left: 5px;
  }
  .popper[x-placement^="right"] .popper__arrow,
  .tooltip[x-placement^="right"] .tooltip-arrow {
    border-width: 5px 5px 5px 0;
    border-left-color: transparent;
    border-top-color: transparent;
    border-bottom-color: transparent;
    left: -5px;
    top: calc(50% - 5px);
    margin-left: 0;
    margin-right: 0;
  }
  .popper[x-placement^="left"],
  .tooltip[x-placement^="left"] {
    margin-right: 5px;
  }
  .popper[x-placement^="left"] .popper__arrow,
  .tooltip[x-placement^="left"] .tooltip-arrow {
    border-width: 5px 0 5px 5px;
    border-top-color: transparent;
    border-right-color: transparent;
    border-bottom-color: transparent;
    right: -5px;
    top: calc(50% - 5px);
    margin-left: 0;
    margin-right: 0;
  }
  .selector {
    display: inline-block;
    width: 180px !important;
    background: none !important;
    border: none !important;
    position: absolute !important;
    right: 19%;
    top: 12%;
    font-size: 14px !important;
    display: none;
  }

  .selector .title{
    display: inline !important;
    color: black !important;
    padding: 0 !important;
  }

  .selector select{
    float: right;
    opacity: 1 !important;
    border: 1px solid #C4C4C4 !important;
    padding: 5px;
    position: relative !important;
    width: 50% !important;
    min-width: unset !important;
  }

  .box-event{
    position: absolute;
    top: 483px;
    left: 1202px;
    z-index: 1000;
    background-color: yellow;
    border-radius: 20px;
    color: white;
  }

  .box-event .box-main{
    padding: 10px 20px;
  }

  .box-addevent{
    position: fixed;
    top: 50%;
    left: -50%;
    transform: translate(-50%, -50%);
    z-index: 1000;
    height: 530px;
    background-color: white;
    padding: 10px;
    padding-right: 30px;
    box-shadow: 0px 0px 5px 2px #ccc;
    overflow-y: overlay;
  }

  .box-addevent .btn-close{
    float: right;
  }

  .show-error{
    margin-top: 30px;
  }

  .show-error p{
    background-color: #f0f0f0;
    padding: 5px 10px;
  }

</style>

<div class="box-addevent">
  <form id="formElem">
    <table>
      <tr>
        <td colspan="2"><span class="btn btn-close btn-addevent">Close</span></td>
      </tr>
      <tr>  
        <th>Tên event</th>
        <td> <input type="text" name="event_name" required> </td>
      </tr>
      <tr>  
        <th>Ngày bắt đầu</th>
        <td> <input type="datetime-local" name="start_time" value="<?=date('Y-m-d\TH:i')?>"> </td>
      </tr>
      <tr>  
        <th>Ngày kết thúc</th>
        <td> <input type="datetime-local" name="end_time" value="<?=date('Y-m-d\TH:i')?>"> </td>
      </tr>
      <tr>  
        <th>Tên khách hàng</th>
        <td> <input type="text" name="name_customer" required> </td>
      </tr>
      <tr>  
        <th>SDT</th>
        <td> <input type="number" name="phone_customer" required> </td>
      </tr>
      <tr>  
        <th>Email</th>
        <td> <input type="text" name="email_customer" required> </td>
      </tr>
      <tr>  
        <th>Số người lớn</th>
        <td> <input type="number" name="number_adults" required min="0" value="0"> </td>
      </tr>
      <tr>  
        <th>Số trẻ em</th>
        <td> <input type="number" name="number_kid" min="0" required value="0"> </td>
      </tr>
      <tr>  
        <th>Loại event</th>
        <td> 
          <select name="type_id" id="type_id">
            
          </select>
        </td>
      </tr>
      <tr>  
        <th>Cả ngày</th>
        <td>
          <select name="status" id="status">
            <option value="0">Không</option>
            <option value="1">Có</option>
          </select>
        </td>
      </tr>
      <tr> 
        <td class="text-right pagination-right" colspan="2"><input type="submit" name="submit" value="Xác nhận"></td>
      </tr>

      <input type="hidden" name="created_user" value="" />
      <input type="hidden" name="created_time" value="" />
      <input type="hidden" name="updated_user" value="" />
      <input type="hidden" name="updated_time" value="" />
    </table>
  </form>
  <div class="show-error">
  
  </div>
</div>

<div id="content" class="clearfix">
  <div class="note">
    <h2>Note: </h2>
    <ul class="list-group">
      <li class="list-group-item active"> 
        <span class="label" style="background: orange"></span> 
        <span class="title"> Sự kiện còn dưới 10 phút sẽ diễn ra </span>
      </li> <br>
    </ul>
  </div>
  <div id="theme-system-selector" class='selector'>
    <span class="title"> Limit time: </span>
      <select>
        <option value='00:30:00' selected>Choose</option>
        <option value='00:10:00'>10</option>
        <option value='00:15:00'>15</option>
        <option value='00:20:00'>20</option>
        <option value='00:25:00'>25</option>
        <option value='00:30:00'>30</option>
        <option value='00:35:00'>35</option>
        <option value='00:40:00'>40</option>
        <option value='00:45:00'>45</option>
      </select>
  </div>
  <div id='calendar'></div>
</div>
<script type="text/javascript" src="../theme/admin/tb/js/fullcalendar.min.js"></script>
<script type="text/javascript" src="../theme/admin/tb/js/theme-chooser.js"></script>
<script type="text/javascript" src="../theme/admin/tb/js/calendar.js"></script>
