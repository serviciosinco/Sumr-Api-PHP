<?php

		$pth = '../../includes/';
		$__https_off = 'off';
		$__no_sbdmn = 'ok';
		$__bdfrnt = 'ok';
		include($pth .'inc.php');

	//---------------- Get Parameters ----------------//

		$_id = Php_Ls_Cln($_GET['id']);
		$_cbck = Php_Ls_Cln($_GET['callback']);

	//---------------- Get Data Global ----------------//

		if(!isN($_id)){ $_wdgt_dt = GtClWdgtDt([ 'id'=>$_id, 't'=>'enc' ]); }

	//---------------- Start Process ----------------//

	if(PrmLnk('rtn', 1, 'ok') == 'json'){

		include(DIR_CNT.'json.php');

	}elseif(PrmLnk('rtn', 1, 'ok') == 'action'){

		include(DIR_CNT.'action.php');

	}elseif(PrmLnk('rtn', 1, 'ok') == 'test'){

		include(DIR_CNT.'test.php');

	}else{

		echo 'No path to show';

	}



?>