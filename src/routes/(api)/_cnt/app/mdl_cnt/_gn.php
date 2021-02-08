<?php 


	if(!isN($_cl_us)){ $__dt_us = GtUsDt($_cl_us, 'enc'); }
	if(!isN($_cl_us_oth)){ $__dt_us_oth = GtUsDt($_cl_us_oth, 'enc'); }
	if(!isN($_cl_enc)){ $__dt_cl = GtClDt($_cl_enc, 'enc'); }
	if(!isN(_GetPost('mdlcnt_enc'))){ $_mdlcnt_enc = _GetPost('mdlcnt_enc'); } //Enc del mdl_cnt
	if( !isN($__dt_cl->sbd) ){ $_bd = "sumr_c_".$__dt_cl->sbd; } //Nombre de la base de datos
	if(!isN(_GetPost('siscntest_enc'))){ $_siscntest_enc = _GetPost('siscntest_enc'); } //Enc del estado
	if(!isN(_GetPost('pgs_row'))){ $_pgs_row = _GetPost('pgs_row'); } //Contador para infinite-scroll
	if(!isN(_GetPost('cnt_nm_fl'))){ $_cnt_nm_fl = _GetPost('cnt_nm_fl'); } //Valor del buscador (Nombre - Apellido)
	
	$_tp = _GetPost('tp');
	
	if($__p3_o == 'mdl_s_tp'){
		
		include(GL_APP."mdl_cnt/mdl_s_tp.php");
		
	}elseif($__p3_o == 'mdl_cnt'){
		
		include(GL_APP."mdl_cnt/mdl_cnt.php");
		
	}elseif($__p3_o == 'mdl_cnt_est'){
		
		include(GL_APP."mdl_cnt/mdl_cnt_est.php");

	}
	
	
?>