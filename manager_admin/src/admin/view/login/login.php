<style type="text/css">

    #loginbox {
        margin-top: 30px;
    }

    .panel {    
           background-color: rgba(250, 250, 250, 0.47);
 
    }

    .panel-body {
        padding-top: 30px;
    }

    input[type="email"],input[type="password"]{
        height: 30px;    
        width: 100%;
    }
 
</style>
<?php// echo($result_ex); ?>
<div class="container" style="margin:0 auto">    
    <div id="loginbox" class="mainbox col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3"> 
        <div class="panel panel-default" >
            <div class="panel-heading">
                <div class="panel-title text-center">Đăng nhập</div>
            </div>     
            <div class="panel-body" >
                <div id="input-form">
                    <ul id="show-error-messages" class="item-error-messages"></ul>
                    <form method="POST" action="<?= $urlLogin ?>" name="mainform">
                        <input type="text" style="display:none">
                        <input type="password" style="display:none">  
                        <p><label for="">Tài khoản</label></p>

                        <input  type="email" id="staff_email" name="staff_email" value="<?= $viewState->get("staff_email") ?>" size="20"/>

                        <p><label for="">Mật khẩu</label></p>

                        <input type="password" id="staff_password" name="staff_password" size="20" class="form " />

                        <p> <input type="checkbox" id="remember"> <label for="remember">Remember me</label></p>

                        <p><button type="submit" value="Đăng nhập" class="btn btn-primary pull-right" >Đăng nhập</button></p>
                    </form>
                </div>   
            </div>                     
        </div>  
    </div>
</div>