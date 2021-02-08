<?php
	if($_GET["_lnd"] != '' && $_GET["_lnd"] != NULL){
		
		$_tab = Php_Ls_Cln($_GET["_tab"]);
		$_lnd = Php_Ls_Cln($_GET["_lnd"]);

		
		$GtLnd = GtLndTabUsLs( ["tp"=>"enc", "id"=>$_tab, "lnd_tp"=>"enc", "lnd_mod"=>"ok"] );
		
		echo $GtLnd->ls['0']->html;
		
	}
	
?>