<?php 
if(class_exists('CRM_Cnx')){
	
	$___Ls->cnx->cl = 'ok';
	$___Ls->sch->f = 'actcnthis_dsc';	 
	$___Ls->_strt();
	
	if(!isN($___Ls->gt->i)){	

		$___Ls->qrys = sprintf("SELECT * FROM ".MDL_EMP_HIS_BD.", ".MDL_EMP_BD.", "._BdStr(DBM).TB_SIS_SLC.", "._BdStr(DBM).TB_US."
						   WHERE emphis_emp = id_emp AND
						   		 emphis_tp = id_sisslc AND 
						   		 emphis_us = id_us AND
								 ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));				 
		  
		$__dt_cnt = GtEmpDt($__i);
		
	}elseif($___Ls->_show_ls == 'ok'){ 


		$Ls_Whr = "FROM $__bd, $__bd2, "._BdStr(DBM).TB_SIS_SLC.", "._BdStr(DBM).TB_US."
				   WHERE emphis_emp = id_emp AND
						 emphis_tp = id_sisslc AND 
						 emphis_us = id_us 
						 $__fl AND
						 emphis_emp = '".GtSQLVlStr($___Ls->gt->isb, "int")."'  ".$___Ls->sch->cod." 
				  ORDER BY emphis_fi DESC";
		$___Ls->qrys = "SELECT *, "._QrySisSlcF().", 
						(SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr";

		
		$__dt_cnt = GtEmpDt($__i);
	} 
	
	
	$___Ls->_bld();

?>
<?php if($___Ls->ls->chk=='ok'){  $__blq = 'off'; ?>
<br>
<?php if(_SbLs_ID('i')){ ?>
<div class="<?php echo ID_HDRLS ?> _Prg">
	<div class="btn"> 
	  <img src="<?php echo DIR_IMG_ESTR ?>icn_tel.png" width="54" height="54" name="_INRG_Tel_SbCnt" id="_INRG_Tel_SbCnt" style="padding-right:10px;" /> 
	  <img src="<?php echo DIR_IMG_ESTR ?>icn_mail.png" width="54" height="54" name="_INRG_Mail_SbCnt" id="_INRG_Mail_SbCnt" style="padding-right:10px;" /> 
	  <?php /* <img src="<?php echo DIR_IMG_ESTR ?>icn_vst.png" width="40" height="40" name="_INRG_Vst_SbCnt" id="_INRG_Vst_SbCnt" /> <?php */ ?> 
	</div>
	
	
  <?php
		
		$CntWb .= '
			$("#_INRG_Mail_SbCnt").click(function() { 
				_ldCnt({ 
					u:\'_cnt/_ls/_gn.php?_t='.$___Ls->mdlstp->tp.'_cnt_his&_m=2&Pr=Ing'.Fl_i($__i).'&__rnd=bcf'.TXGN_POP.$___Ls->ls->vrall.'\',
					pop:\'ok\', 
					w:\''.POP_HISTP_W.'\', 
					h:\''.POP_HISTP_H.'\' 
				}); 
			});
			$("#_INRG_Tel_SbCnt").click(function() { 
				_ldCnt({
					\'_cnt/_ls/_gn.php?_t='.$___Ls->mdlstp->tp.'_cnt_his&_m=1&Pr=Ing'.Fl_i($__i).'&__rnd=bcf'.TXGN_POP.$___Ls->ls->vrall.'\',
					pop:\'ok\', 
					w:\''.POP_HISTP_W.'\', 
					h:\''.POP_HISTP_H.'\'
				}); 
			});
			
			$("#_INRG_Vst_SbCnt").click(function() { 
				_ldCnt({ 
					u:\'_cnt/_ls/_gn.php?_t='.$___Ls->mdlstp->tp.'_cnt_his&_m=3&Pr=Ing'.Fl_i($__i).'&__rnd=bcf'.TXGN_POP.$___Ls->ls->vrall.'\',
					pop:\'ok\', 
					w:\''.POP_HISTP_W.'\', 
					h:\''.POP_HISTP_H.'\'
				}); 
			});
		'; 

	?>
</div>
<?php }else{
	
		$___Ls->_bld_l_hdr(); 
	
} ?>

<?php if(($___Ls->qry->tot > 0)){ ?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
  	<thead>
        <tr>
            <th width="1%" <?php echo NWRP ?>><?php echo TX_GSTN; ?></th>
            <th width="15%" <?php echo NWRP ?>><?php echo TX_ACCN; ?></th>
            <th width="15%" <?php echo NWRP ?>><?php echo TX_DTE; ?></th>
            <th width="15%" <?php echo NWRP ?>><?php echo TX_HUR; ?></th>
            <th width="5%" <?php echo NWRP ?>><?php echo TX_DSC; ?></th>

            <th width="1%" <?php echo NWRP ?>></th>
        </tr>
  	</thead>
 	<tbody>
		<?php do { ?>
	  	<?php 
            $__gtusdt = GtUsDt($___Ls->ls->rw['tra_us']);
            $__gtusdt_rsp = GtUsDt($___Ls->ls->rw['tra_us_rsp']);
            $___col = CG_Array(['f'=>$___Ls->ls->rw['___fld'], 'k'=>'key' ]);              
		?>
		<tr>

            <td width="1%" align="left" nowrap="nowrap"><?php echo ctjTx($___Ls->ls->rw['us_nm'].' '.$___Ls->ls->rw['us_ap'],'in') ; ?></td>
            <td width="15%" align="left" nowrap="nowrap"><?php echo ctjTx($___Ls->ls->rw['histp_tt'],'in'); ?></td>
            <td width="15%" align="left" nowrap="nowrap"><?php echo Spn($___Ls->ls->rw['emphis_fi'],'','_f'); ?></td>
            <td width="15%" align="left" nowrap="nowrap"><?php echo Spn($___Ls->ls->rw['emphis_hi'],'','_f'); ?></td>
            <td width="15%" align="left"  ><?php echo ShortTx(ctjTx($___Ls->ls->rw['emphis_dsc'],'in'),70,'Pt', true); ?></td>

            <td width="1%" align="left" nowrap="nowrap" class="_btn"><?php echo $___Ls->_btn([ 't'=>'mod' ]); ?></td>
        </tr>
        <?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
        <?php $CntWb .= " $('#".TBGRP."_gst ._n').html('".$___Ls->qry->tot."'); "; ?>
  	</tbody>
</table>
<?php $___Ls->_bld_l_pgs(); ?>
<?php } ?>
<?php $___Ls->_h_ls_nr(); ?>
<?php } ?>
<?php if(HTML_Ls_Chck('f', $_GET["Pr"], $_GET["_i"], $___Ls->dt->tot)){ $__blq = 'on'; ?>
<div class="FmTb">
  <div id="<?php echo DV_GNR_FM.DV_SBCNT ?>">

    <form action="<?php echo Fl_Rnd(PRC_GN.__t($__bdtp,true)) ?>" method="POST" <?php echo $__fm_trg ?> >
      	<?php $___Ls->_bld_f_hdr(); ?>


			<?php $_id_tbpnl = 'TabPnl_'.Gn_Rnd(20); $CntWb .= " SUMR_Main.bxajx.".$_id_tbpnl." = new Spry.Widget.TabbedPanels('".$_id_tbpnl."', {defaultTab:1}); "; ?>
            <div id="<?php echo $_id_tbpnl ?>" class="TabbedPanels">
              <ul class="TabbedPanelsTabGroup">
                <li class="TabbedPanelsTab"><?php echo TX_DTSBSC ?></li>
              </ul>
              <div class="TabbedPanelsContentGroup">
                <div class="TabbedPanelsContent">
					<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
                        <div class="ln_1">
                              <div class="col_1">
                                  	<ul class="__dt">
                                		<li><?php echo Strn(TX_NIT).': '.$__dt_cnt->nit; ?></li>
                                        <li><?php echo Strn(TX_RS).': '.$__dt_cnt->rs?></li>										                           
                                        <li><?php echo Strn(TX_DIRC).': '.$__dt_cnt->dir; ?></li>
                                        <li><?php echo Strn(TX_BTN_WB).': '.$__dt_cnt->web; ?></li>
                                        <br><br>
                                        <li><?php echo Strn(TX_FING).': '.$___Ls->dt->rw['emphis_fi']; ?></li>
                                        <li><?php echo Strn(TX_HING).': '.$___Ls->dt->rw['emphis_hi']; ?></li>
                                    </ul>
                              </div>
                              <div class="col_2"> 
                                  <?php if($___Ls->dt->tot > 0){  ?>
                                  
                                  		<?php echo h2($___Ls->dt->rw['histp_tt']); ?>
                                  	    <?php 
                                      	    echo "<p class='_Dsc'>".ctjTx($___Ls->dt->rw['emphis_dsc'],'in')."</p>";
										    echo HTML_inp_hd('emphis_dsc', ctjTx($___Ls->dt->rw['emphis_dsc'],'in')); 
										?>
                                  	
                                  
                                  <?php }else{  ?>
                                    <?php echo HTML_textarea('emphis_dsc', TX_CON_DSC, ctjTx($___Ls->dt->rw['emphis_dsc'],'in'), '', 'ok'); ?> 
                                    
                                    <?php echo HTML_inp_hd('___t', $__prfx->prfx3_c); ?>
                                    
                                    <input id="emphis_emp" name="emphis_emp" type="hidden" value="<?php echo $__i; ?>" />
                                    <?php if($___Ls->dt->rw['emphis_tp'] != ''){ $__m = $___Ls->dt->rw['emphis_tp']; }else{ $__m = Php_Ls_Cln($_GET['_m']); } ?>
                                    <?php //echo LsCntHisTp('emphis_tp','id_histp', $__m, TX_ACCN, 2); $CntWb .= JQ_Ls('emphis_tp',TX_ACCN); ?>
                                    
                                    <?php 
                                        $l = __Ls(['k'=>'his_tp', 'id'=>'emphis_tp', 'va'=>$___Ls->dt->rw['emphis_tp'] , 'ph'=>TX_ACCN]); 
										echo $l->html; $CntWb .= $l->js;  
									?>
                                    
                                    
                                    
                                 <?php }  ?>
                              </div>

                        </div>
                    </div>
                </div>
              </div>
				</div>
	    <?php
		      				
      	$CntJV .=	"
      	
               function __ShwDwn(){ ".PgRg($__ls, __t('dwn') )." }
	    ";?>
                    
    </form>
  </div>
</div>
<?php } ?>
<?php } ?>
