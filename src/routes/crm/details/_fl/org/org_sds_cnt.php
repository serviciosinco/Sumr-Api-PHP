<?php 

	
	
	$_fl_eml = ", (SELECT GROUP_CONCAT(cnteml_eml) FROM  ".TB_CNT_EML." WHERE cnteml_cnt = id_cnt) AS _eml";
	$_fl_tel = ", (SELECT GROUP_CONCAT(cnttel_tel) FROM  ".TB_CNT_TEL." WHERE cnttel_cnt = id_cnt) AS _tel";
	$_fl_doc = ", (SELECT GROUP_CONCAT(cntdc_dc) FROM  ".TB_CNT_DC." WHERE cntdc_cnt = id_cnt) AS _dc";
	$Ls_Pro_Qry  = "SELECT
						* $_fl_eml $_fl_tel $_fl_doc
					FROM
						".TB_ORG_SDS_CNT."
					INNER JOIN ".TB_CNT." ON id_cnt = orgsdscnt_cnt
					WHERE
						orgsdscnt_enc = '".$__i."'";
		  
	$Ls_Pro = $__cnx->_qry($Ls_Pro_Qry);
	$row_Ls_Pro = $Ls_Pro->fetch_assoc(); 
	$Tot_Ls_Pro = $Ls_Pro->num_rows;						
		 	
	if($row_Ls_Pro['id_cnt'] != NULL){ $__fll_cnt = Gt_FllCnt([ 'cnt'=>$row_Ls_Pro['id_cnt'] ]); }
	 
?>
<div class="ln_d_1" style=" display: block;">
	<h1 class="u_nm"><?php echo $row_Ls_Pro['cnt_nm'].' '.$row_Ls_Pro['cnt_ap']; ?></h1>
	<div class="_pic">
	
		<div id="__grph_crsl_pic" class="owl-carousel" style="display: block">
			<?php if(!isN($__fll_cnt->pht)){ ?>
				<?php foreach($__fll_cnt->pht as $_k => $_v){ ?>
					<div class="item"><img src="<?php echo $_v->url ?>" /></div>
				<?php } ?>
			<?php }else{ ?>
				<div class="item"><img src="<?php echo DMN_IMG_ESTR; ?>us_nop.png" /></div>
			<?php } ?>
		</div>
	</div>
</div>
<div class="ln_1">
	<ul class="ls_1" id="dtll2">
		<?php
		
		$_eml = explode(",", $row_Ls_Pro['_eml']); $i_eml = 1;
		foreach($_eml as $_v_eml){
			if(!isN($_v_eml)){ ?><li class="" id="_li_nm"><?php echo Strn(TX_EML."-".$i_eml,'',true).ctjTx($_v_eml, 'in'); ?></li><?php $i_eml++; }
		}
		
		$_tel = explode(",", $row_Ls_Pro['_tel']); $i_tel = 1;
		foreach($_tel as $_v_tel){
			if(!isN($_v_tel)){ ?><li class="" id="_li_nm"><?php echo Strn(TX_TEL."-".$i_tel,'',true).ctjTx($_v_tel, 'in'); ?></li><?php $i_tel++; }
		}
		
		$_dc = explode(",", $row_Ls_Pro['_dc']); $i_dc = 1;
		foreach($_dc as $_v_dc){
			if(!isN($_v_dc)){ ?><li class="" id="_li_nm"><?php echo Strn(TX_DC."-".$i_dc,'',true).ctjTx($_v_dc, 'in'); ?></li><?php $i_dc++; }
		}	
			
		?>
	</ul>
</div>

<?php  ?>