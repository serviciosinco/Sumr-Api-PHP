<?php 


	if($_pm_action == 'dashboard'){ 
		include(DIR_CNT.'section/header_bottom.php');
		include(DIR_CNT_FM.'dashboard.php');
		include(DIR_CNT.'section/footer.php');	
	}elseif($_pm_action == 'refered'){
		include(DIR_CNT.'section/header_bottom.php');
		include(DIR_CNT_FM.'refered.php');
		include(DIR_CNT.'section/footer.php');	
	}elseif($_pm_section == 'login'){
		include(DIR_CNT.'section/header_bottom.php');
		include(DIR_CNT_FM.'login.php');
		include(DIR_CNT.'section/footer.php');
	}elseif($_pm_module == 'fidelizacion'){
		include(DIR_CNT.'section/header_bottom.php');
		if(!isN($_pm_section)){
			include(DIR_CNT_FM.'default.php');
		}else{
			include(DIR_CNT_FM.'dashboard.php');
		}
		include(DIR_CNT.'section/footer.php');
	}else{
		include(DIR_CNT.'section/header.php');
		echo 'SUMR';
		include(DIR_CNT.'section/footer.php');	
	}
?>