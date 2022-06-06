<?php
if(isset($_COOKIE['login']))
{
	$l_id=$_COOKIE['login'];
	?>
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation" style="background:#495B79;">
        <div class="navbar-header" style="background:#367FA8;">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <?php $userNameQ=$db->query("SELECT user_name,profile_ext FROM user_infromation WHERE user_id=$l_id") or die("");
			$userNameQ_res=$userNameQ->fetch(PDO::FETCH_ASSOC);
			 ?>
            <a class="navbar-brand" href="index.php">Welcome &nbsp;<span style="background:#fff; color:#000; padding:5px; font-weight:bold; font-size:15px; border-radius:4px;"><?php echo $userNameQ_res['user_name']; ?></span></a>
        </div>
        <ul class="nav navbar-right top-nav">
            <li class="dropdown" style="background:#333;">
<a style="color:#fff;" href="log-out.php"><i class="fa fa-user"></i>&nbsp; Logout </a>                    
            </li>
        </ul>
		<style>
            .side-nav li a{
                font-size:14px !important;
            }			
        </style>
        <div class="collapse navbar-collapse navbar-ex1-collapse">
        
        
            <ul class="nav navbar-nav side-nav">
            
             <li>
                 <a href="index.php"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
             </li>
             <?php $login_id=$_COOKIE['login'];
                $header_m_q=$db->query("SELECT
                                        user_id,
                                        user_name,a_field_url,
                                        user_auth,
                                        a_field_name
                                        FROM user_infromation,
                                        authentication
                                        WHERE user_id = $login_id
                                        AND FIND_IN_SET(authentication.a_id,user_auth);");
                while($header_m_q_res=$header_m_q->fetch(PDO::FETCH_ASSOC)){ ?>  
                    <li>
                        <a href="<?php echo $header_m_q_res['a_field_url']; ?>">
                            <i class="fa fa-fw fa-dashboard"></i>
                                <?php echo $header_m_q_res['a_field_name']; ?>
                        </a>
                   </li>
                <?php } ?>
            </ul>
        </div>
</nav>
<?php
}
else{
	header("location:login-page.php");	
}
?>