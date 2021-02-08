<?php 
if(class_exists('CRM_Cnx')){
    $___Ls->ik = 'orgsdsarrsls_enc';
    $___Ls->ino = 'id_orgsdsarrsls';
	
	$___Ls->new->w = 500;
	$___Ls->new->h = 550;
	$___Ls->edit->w = 500;
	$___Ls->edit->h = 550;
	$___Ls->flt = 'ok';
	$___Ls->_strt();
    
    $___Ls->grph->tot = 2;
	
	if(!isN($___Ls->gt->i)){	
		
		$___Ls->qrys = sprintf("
								SELECT * FROM "._BdStr(DBM).TB_ORG_SDS_ARR_SLS."
								INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR." ON id_orgsdsarr = orgsdsarrsls_arr
								INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON orgsdsarr_orgsds = id_orgsds
								INNER JOIN "._BdStr(DBM).TB_ORG."  ON orgsds_org = id_org
								WHERE ".$___Ls->ik." = %s LIMIT 1
								", GtSQLVlStr($___Ls->gt->i, "text"));	
		
	}elseif($___Ls->_show_ls == 'ok'){ 	

        if(!isN($___Ls->_fl->f1) && !isN($___Ls->_fl->f2)){ 
            $__fl .= ' AND DATE_FORMAT(orgsdsarrsls_f, "%Y-%m-%d") BETWEEN "'.$___Ls->_fl->f1.'" AND "'.$___Ls->_fl->f2.'" '; 
        }elseif(!isN($___Ls->_fl->f1)){
            $__fl .= ' AND DATE_FORMAT(orgsdsarrsls_f, "%Y-%m-%d")  = "'.$___Ls->_fl->f1.'" ';
        }elseif(!isN($___Ls->_fl->f2)){
            $__fl .= ' AND DATE_FORMAT(orgsdsarrsls_f, "%Y-%m-%d")  = "'.$___Ls->_fl->f2.'" '; 
        }

        if(!isN($___Ls->_fl->fk->cllcl_lvl)){
			$__fl .= " AND id_org IN ( SELECT id_org FROM "._BdStr(DBM).TB_ORG." 
						INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON orgsds_org = id_org
						INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR." ON orgsdsarr_orgsds = id_orgsds
						INNER JOIN "._BdStr(DBM).TB_CL_LCL." ON orgsdsarr_lcl = id_cllcl WHERE cllcl_lvl = ".$___Ls->_fl->fk->cllcl_lvl." )";	
		}

		if(!isN($___Ls->_fl->fk->_fl_orgls)){

			$__fl .= " AND id_org IN ( ".$___Ls->_fl->fk->_fl_orgls." )";

		}

		if(!isN($___Ls->_fl->fk->_fl_orgtag)){

			$__fl .= " AND id_org IN ( SELECT id_org FROM "._BdStr(DBM).TB_ORG." 
						INNER JOIN "._BdStr(DBM).TB_ORG_TAG." ON orgtag_org = id_org
							WHERE orgtag_tag = ".$___Ls->_fl->fk->_fl_orgtag." )";

        }
        
        if(!isN($___Ls->_fl->fk->_fl_orgest)){
			$__fl .= " AND org_est = ".$___Ls->_fl->fk->_fl_orgest;	
		}

		$Ls_Whr = "FROM "._BdStr(DBM).TB_ORG_SDS_ARR_SLS."
                        INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR." ON id_orgsdsarr = orgsdsarrsls_arr
                        INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON orgsdsarr_orgsds = id_orgsds
                        INNER JOIN "._BdStr(DBM).TB_ORG."  ON orgsds_org = id_org
                    WHERE ".$___Ls->ino." != '' $__fl ORDER BY id_orgsdsarrsls DESC";
        
                    
		$___Ls->qrys = "SELECT id_orgsdsarrsls, orgsdsarrsls_vl, orgsdsarrsls_trs, orgsdsarrsls_f, orgsdsarrsls_enc, org_nm, orgsdsarrsls_fi,
                                (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr ";
	} 
	
	$___Ls->_bld();
?>
<?php if($___Ls->ls->chk=='ok'){ ?>
<?php $___Ls->_bld_l_hdr(); ?>

<?php 

	$__grph_shw = "

		SUMR_Main.bxajx.__grph_fl = { fl:{ f:".json_encode($___Ls->c_f_g)."} };
	
		_ldCnt({ 
			u:'".Fl_Rnd(FL_GRPH_GN.__t('marks', true).$_adsch.$___Ls->ls->vrall)."&_h=300&_t2=".$___Ls->gt->tsb."&_t3=".$___Ls->gt->tsb_m."&_tp=grph_mark_1&_g_r=".$___Ls->id_rnd."' , 
			c:'bx_grph_".$___Ls->id_rnd."_1',
			d:SUMR_Main.bxajx.__grph_fl,
			trs:false, 
			anm:'no',
			_cl:function(){
				
				_ldCnt({ 
					u:'".Fl_Rnd(FL_GRPH_GN.__t('marks', true).$_adsch.$___Ls->ls->vrall)."&_h=300&_t2=".$___Ls->gt->tsb."&_t3=".$___Ls->gt->tsb_m."&_tp=grph_mark_2&_g_r=".$___Ls->id_rnd."' , 
					c:'bx_grph_".$___Ls->id_rnd."_2',
					d:SUMR_Main.bxajx.__grph_fl,
					trs:false,
					anm:'no',
					_cl:function(){

					}
				});
			
			}
		});

	
    ";
    
    $CntWb .= " setTimeout(function(){ ".$__grph_shw." }, 1000); ";
	
	
?>

<?php if(($___Ls->qry->tot > 0)){ ?>



<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
  <tr>
    <th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
    <th width="20%" <?php echo NWRP ?>><?php echo TX_NM ?></th>
    <th width="20%" <?php echo NWRP ?>><?php echo TX_VLE ?></th>
    <th width="20%" <?php echo NWRP ?>><?php echo 'Transacción' ?></th>
    <th width="20%" <?php echo NWRP ?>><?php echo 'Fecha' ?></th>
    <th width="18%" <?php echo NWRP ?>><?php echo 'Fecha de ingreso' ?></th>
    <th width="1%" <?php echo NWRP ?>></th>
  </tr>
  <?php do { ?>
   <tr>   
    <td width="1%" <?php echo NWRP ?>><?php echo Spn($___Ls->ls->rw[$___Ls->ino]); ?></td>
    <td width="20%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['org_nm'],'in'),40,'Pt', true); ?></td>
    <td width="20%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx(cnVlrMon('', $___Ls->ls->rw['orgsdsarrsls_vl']),'in'),40,'Pt', true); ?></td>
    <td width="20%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['orgsdsarrsls_trs'],'in'),40,'Pt', true); ?></td>
    <td width="20%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['orgsdsarrsls_f'],'in'),40,'Pt', true); ?></td>
    <td width="18%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['orgsdsarrsls_fi'],'in'),40,'Pt', true); ?></td>
    <td width="1%" align="left" class="_btn"><?php echo $___Ls->_btn([ 't'=>'mod' ]); ?></td>
  </tr>
  <?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
</table>
<?php $___Ls->_bld_l_pgs(); ?>
<?php } ?>
<?php $___Ls->_h_ls_nr(); ?>
<?php } ?>
<?php if($___Ls->fm->chk=='ok'){ ?>
<div class="FmTb">
  <div id="<?php  echo DV_GNR_FM ?>">                                        
        <form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>" >
	      <?php $___Ls->_bld_f_hdr(); ?>      
		  <div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">			
	        <div class="ln_1">
			  	<div class="col_1">
                    <?php 
                        

                    
                        if($___Ls->dt->tot == 0){

                            echo LsOrgSds([ 'id'=>'orgsdsarr_sls_enc', 'v'=>'orgsds_enc', 'va'=>'', 'rq'=>1, 'org_tp_k' => 'marks', 'est' => 'ok', 'n_rpt' => 'ok' ]);
                            $CntWb .= JQ_Ls('orgsdsarr_sls_enc');

                            $CntWb .= " 
	    
                                $('#orgsdsarr_sls_enc').change(function(){
                                    var __id = $(this).val();
                                    SUMR_Main.ld.f.slc({i:__id, t:'marks_arr', b:'sch_bx' });	
                                });
                            ";

                        }else{

                            echo HTML_inp_hd('orgsdsarr_sls_enc', $___Ls->dt->rw['orgsds_enc']); 

                            $__cl_logo = _ImVrs([ 'img'=>$___Ls->dt->rw['org_img'], 'f'=>DMN_FLE_ORG ]);
                                        
                            if(!isN($__cl_logo->th_400)){
                                $org_d_img = $__cl_logo->th_400;
                                $org_d_img_cls = '_img_org';
                            }else{
                                $org_d_img = $org_b_d_img;
                                $org_d_img_cls = '_empty';
                            }

                            $org_d_clr = $___Ls->dt->rw['org_clr'];

                            echo _DivLogoTM([ 'i'=>$org_d_img, 'c'=>'', 'cls'=>$org_d_img_cls ]);

                            echo h1($___Ls->dt->rw['org_nm'],'__h_org_nm','color:'.$org_d_clr);


                            $CntWb .= " 

                                var __id = '".$___Ls->dt->rw['orgsds_enc']."';
                                SUMR_Main.ld.f.slc({i:__id, t:'marks_arr', b:'sch_bx', t_i: '".$___Ls->dt->rw['orgsdsarrsls_vl']."', t_e: '".$___Ls->dt->rw['orgsdsarrsls_f']."' });	
                                
                            ";    
                        }
                        
                    ?>

	        	</div>
	        	<div class="col_2">
                    
                        <div class="__orgsdsarrsls_vl">
                            <span class="_dlr">$</span>
                            <span class="_vl"><?php echo number_format( $___Ls->dt->rw['orgsdsarrsls_vl'], 0, ",", "."); ?></span>
					    </div>
                        <div class="_d1"><div id="sch_bx" class="_sbls"></div></div>
                    <?php  

						echo HTML_inp_tx('orgsdsarrsls_trs', "Transacciones" , ctjTx($___Ls->dt->rw['orgsdsarrsls_trs'],'in'), '');

		        	?>
	        	</div>
			</div>
	      </div>
	    </form>
        <?php 

		

		
	
	?>

	<style>
		.__orgsdsarrsls_vl{ width: 100%; height: 80px; border: 1px solid #f6f5f6; text-align: center; padding-top: 20px;margin-bottom: 10px; }

		.__orgsdsarrsls_vl > span{ font-family: Economica; color: #759775; font-size: 20px; }
		.__orgsdsarrsls_vl > span._dlr{ font-size: 25px!important; }

		.__orgsdsarrsls_vl > span._vl._err{ color:#b75757!important; }
        ._img_org {
    width: 80%;
    margin: 0 auto;
}

._img_org ._im{    width: 150px;
    height: 150px;}
    .__h_org_nm{ border: 0 !important;padding: 0 !important;
    margin: 0 !important;}
	</style>
    </div>
</div>
<?php } ?>
<?php } ?>