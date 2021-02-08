<?php

	$rsp['online']['tot'] = 0;

	$Ls_UsOnl_Qry  = sprintf("
								SELECT COUNT(DISTINCT id_us) AS __tot
								FROM "._BdStr(DBM).TB_US."
							  	   INNER JOIN "._BdStr(DBM).TB_US_CL." ON uscl_us = id_us
							  	   INNER JOIN "._BdStr(DBM).TB_CL." ON uscl_cl = id_cl
							  	WHERE id_us != ''
							  		AND cl_enc = ".GtSQLVlStr(DB_CL_ENC, 'text')."
							  		AND us_est = 1
									  $__fl_usonline
							");

	$Ls_UsOnl = $__cnx->_qry($Ls_UsOnl_Qry);

	//$rsp['online']['q'] = compress_code($Ls_UsOnl_Qry);

	if($Ls_UsOnl){

	 	$row_Ls_UsOnl = $Ls_UsOnl->fetch_assoc();
	 	$Tot_Ls_UsOnl = $Ls_UsOnl->num_rows;

	 	if($Tot_Ls_UsOnl > 0){
		 	$rsp['e'] = 'ok';
		 	$rsp['online']['tot'] = $row_Ls_UsOnl['__tot'];
		}

	}else{

		$rsp['w'] = $__cnx->c_r->error;

	}

?>