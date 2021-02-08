<?php 
if(class_exists('CRM_Cnx')){
		
	$__id_prfx = '_'.Gn_Rnd(10);
	$__id = $__prfx->prfx2.'_'.$___Dt->mdlstp->tp;
	
	$_vl = Php_Ls_Cln($_GET['___i']); if($_vl != ''){ $__f_id = ' AND '.$__id.' = '.$_vl; }

	if($__t== 'spa_enc_grph' && $_GET['_enc'] == 12){
		$sis_fld = 21;
	}elseif($__t== 'spa_enc_grph2' && $_GET['_enc'] == 12){
		$sis_fld = 24;
	}elseif($__t == 'acd_enc_grph' && $_GET['_enc'] == 7){
		$sis_fld = 13;
	}elseif($__t == 'evns_enc_grph' && $_GET['_enc'] == 13){
		$sis_fld = 25;
	}elseif($__t == 'evns_enc_grph2' && $_GET['_enc'] == 13){
		$sis_fld = 26;
	}elseif($__t == 'evns_enc_grph3' && $_GET['_enc'] == 13){
		$sis_fld = 27;
	}elseif($__t == 'rst_enc_grph' && $_GET['_enc'] == 11){
		$sis_fld = 13;
	}elseif($__t == 'rst_enc_grph2' && $_GET['_enc'] == 11){
		$sis_fld = 20;
	}elseif($__t == 'pqr_enc_grph' && $_GET['_enc'] == 10){
		$sis_fld = 13;
	}elseif($__t == 'pqr_enc_grph2' && $_GET['_enc'] == 10){
		$sis_fld = 16;
	}elseif($__t == 'pqr_enc_grph3' && $_GET['_enc'] == 10){
		$sis_fld = 17;
	}
	
	
	$Ls_Cnt_Qry = "SELECT fldlst_tt, fld_tt ,count(*) AS __tot_rst FROM ".TB_ENC.", ".TB_ENC_CNT.", ".TB_ENC_CNT_DTS.", sis_fld_lst, sis_fld
		WHERE enccnt_enc = id_enc AND encdts_enccnt = id_enccnt AND fldlst_fld = id_fld
		AND encdts_dts = id_fldlst AND id_fld = ".$sis_fld." AND id_enc = ".$_GET['_enc']." GROUP BY fldlst_tt";
		$Ls_Cnt_Rg = $__cnx->_qry($Ls_Cnt_Qry); $Ls_Cnt_Rg2 = $__cnx->_qry($Ls_Cnt_Qry);  
	 $row_Ls_Cnt_Rg2 = $Ls_Cnt_Rg2->fetch_assoc(); $Tot_Ls_Cnt_Rg = $Ls_Cnt_Rg->num_rows; 
	
		do {
			if($row_Ls_Cnt_Rg['__tot_rst'] < 1){ $_prnt = 0; }else{ $_prnt = $row_Ls_Cnt_Rg['__tot_rst']; }
			$_medio[] = "{ name:'".ctjTx(str_replace("'", "",$row_Ls_Cnt_Rg['fldlst_tt']),'in')."',   data:[". number_format($_prnt, 2, '.', '') ."] } "; 
			$_tabla .= '<tr><td>'.ctjTx($row_Ls_Cnt_Rg['fldlst_tt'],'in').'</td><td>'. number_format($_prnt, 2, '.', '') .'</td></tr>';  
			                    
		} while ($row_Ls_Cnt_Rg = $Ls_Cnt_Rg->fetch_assoc()); 
	
	$_grf_tag = implode(",", $_medio);
 
 
?>

<?php if($__f == 'prnt'){ echo h2($row_Ls_Cnt_Rg['sisfld_tt']); } ?> 
<div id="Grph_bx_dt_3_1<?php echo $__id_prfx ?>" class="_grp" style="width:100%;height:<?php echo $__h ?>; overflow:hidden; position: relative; "></div>
 
<?php if($__f == 'prnt'){ ?>  
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="Ls_Rg">
        <tr>
            <th><?php echo MDL_SIS_MD; ?></th>
            <th><?php echo TX_LEADS; ?></th>
        </tr>
        <?php echo $_tabla ?>     
    </table>
<?php } ?>


<?php 
	$CntWb .= "
		SUMR_Grph.f.g1({ 
			id: '#Grph_bx_dt_3_1".$__id_prfx."',
			d: [".$_grf_tag."],
			tt: '', 
			tt_sb: '".ctjTx($row_Ls_Cnt_Rg2['sisfld_tt'],'in')."',
			c_e: false
		});
	";	
	
?>



<?php } ?>
<?php  ?>