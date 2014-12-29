<div class="upper_nav_center">
    <div id="login_div" style="display:none; width:100%">
        <div id="login_instruction" class="login_part">
        
        </div>
        <div id="register" class="login_part ref_form_div">
        	<h2 class="heading">New Member?</h2>
            <p>Enter the <strong>reference code</strong> of your referer</p>
            <form class="referer_form" method="get" action="<?php echo $root; ?>register/reg_scripts/">
            <input type="text" name="ref" placeholder="Enter your referer id here" maxlength="19" size="" required />
            <input class="referer_btn" type="submit" value="Continue" />
            </form>
            
        </div>
        <div id="login" class="login_part">
        	<h2 class="heading">Existing Member?</h2>
            <p>Enter your account email address and password. </p>
            <form method="POST" action="<?php echo $root; ?>scripts/login_script.php">
            <table width="100%">
            <tr><td><b>Email</b></td>
            <td>: <input type="email" name="email" placeholder="Enter your username here" maxlength="20" size="" required></td>
            <td rowspan="2"><input type="submit" name="login" value="Go" style="height:45px"></td></tr>
            <tr><td><b>Password</b></td>
            <td>: <input type="password" name="password" placeholder="Enter your password here" maxlength="10" size="" required>
            </td></tr>
            <tr><td>&nbsp;</td><td colspan="2"> <label><input type="checkbox" name="forgot" class="forgot" /> Forgot Password?</label></td>
            </table>
            </form>
        </div>
    </div>
    <div id="login_link_div" style="float:right; padding-top:10px;"> &gt;&gt; 
    <a href="#" id="login_link" style="color:#DDDDDD;">Register / Login</a></div>
</div>
