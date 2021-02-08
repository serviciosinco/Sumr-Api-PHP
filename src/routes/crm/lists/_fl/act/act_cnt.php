<?php
if(class_exists('CRM_Cnx')){
	
	$___Ls->cnx->cl = 'ok';
    $___Ls->tt = _Cns('TX_ARTCLS');
    $___Ls->tp = 'mdl_cnt';
	$___Ls->_strt();
	
	if(!isN($___Ls->gt->i)){	
		
		$___Ls->qrys = sprintf("SELECT * FROM ".MDL_ART_TB." WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
		
	}elseif($___Ls->_show_ls == 'ok'){ 
        
		$Ls_Whr =  "FROM ".TB_MDL_CNT_ACT."
                        INNER JOIN ".TB_MDL_CNT." ON mdlcntact_mdlcnt = id_mdlcnt
                        INNER JOIN "._BdStr(DBM).TB_ACT." ON mdlcntact_act = id_act
                        INNER JOIN ".TB_CNT." ON mdlcnt_cnt = id_cnt 
                        LEFT JOIN ".TB_CNT_PLCY." ON (cntplcy_cnt = id_cnt AND cntplcy_sndi=1)
						LEFT JOIN "._BdStr(DBM).TB_CL_PLCY." ON (cntplcy_plcy = id_clplcy AND clplcy_e=1)
                        
                    WHERE
                        mdlcntact_act = id_act AND act_enc = '".$___Ls->gt->isb."' AND  ".$___Ls->ino." != '' ".$___Ls->sch->cod." ORDER BY ".$___Ls->ino." DESC";
        $___Ls->qrys = "SELECT cnt_nm, cnt_enc, cnt_ap, mdlcnt_enc, id_mdlcnt, cntplcy_sndi, (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr"; 

    }
	
	$___Ls->_bld(); 
?>
<?php if($___Ls->ls->chk=='ok'){ ?>
    <?php $___Ls->_bld_l_hdr(); ?>
    <?php if(($___Ls->qry->tot > 0)){ ?>
        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
                   
            
            <tr>
                <th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
                <th width="30%" <?php echo NWRP ?>><?php echo TX_NM ?></th>
                <th width="30%" <?php echo NWRP ?>><?php echo TX_EML ?></th>
                <th width="30%" <?php echo NWRP ?>><?php echo TX_TEL ?></th>
                <th width="1%" <?php echo NWRP ?>></th>
            </tr>
            <?php do { ?>
            <?php $__ls_json[] = $___Ls->ls->rw['mdlcnt_enc']; ?> 
            <tr class="<?php echo $___Ls->ls->nxt->cls; ?>" id="<?php echo $___Ls->ls->nxt->id.$___Ls->ls->rw['mdlcnt_enc'] ?>" id-enc="<?php echo $___Ls->ls->rw['mdlcnt_enc'] ?>" actcnt-id-no="<?php echo $___Ls->ls->rw['mdlcnt_enc']; ?>">
                <td width="1%" <?php echo NWRP ?>><?php echo Spn($___Ls->ls->rw[$___Ls->ino]); ?></td>
                <td width="30%" align="left" nowrap="nowrap">
                    <?php
                        if($___Ls->ls->rw['cntplcy_sndi'] == 1){
                            echo ShortTx(ctjTx($___Ls->ls->rw['cnt_nm'].' '.$___Ls->ls->rw['cnt_ap'],'in'),40,'Pt', true);
                        }else{
                            echo '- '._Cns('TX_ANYMUS').' -';
                        }
                    ?>
                </td>
                <td width="30%" align="left"><div class="bx_emls"><ul class="eml_ls"></ul></div></td>
                <td width="30%" align="left"><div class="bx_tels"><ul class="tel_ls"></ul></div></td>
                <td width="1%" align="left" nowrap="nowrap" class="_btn"><?php echo $___Ls->_btn([ 't'=>'mod' ]); ?></td>
            </tr>
            <?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
            <style>
                .eml_ls, .tel_ls{ list-style-type: none; }
            </style>
            <?php

            $CntJV .=	"
            
                function __getActCntJs(){
        
                    $.post('".Fl_Rnd(FL_JSON_GN.__t('act_cnt_ext',true))."', { act:'".implode(',', $__ls_json)."' },
                    
                    function(d, status){
                        if(d.e == 'ok'){
                            $.each(d.l, function(_k, _v) { 

                                if(!isN(_v.eml)){ 
                                    $.each(_v.eml, function(__k, __v) { 
                                        $('tr[actcnt-id-no='+_v.id+'] .bx_emls ul').append( '<li><span>'+__v+'</span></li>' );
                                    });
                                }

                                if(!isN(_v.tel)){ 
                                    $.each(_v.tel, function(__k_tel, __v_tel) { 
                                        $('tr[actcnt-id-no='+_v.id+'] .bx_tels ul').append( '<li><span>'+__v_tel+'</span></li>' );
                                    });
                                }

                            });  
                        }  
                    });        
                } 

            ";
            
            $CntWb .= " setTimeout(function(){ __getActCntJs(); }, 1000); ";

        ?>
        </table>
        <?php $___Ls->_bld_l_pgs(); ?>
    <?php } ?>
    <?php $___Ls->_h_ls_nr(); ?>
<?php } ?>

<?php if($___Ls->fm->chk=='ok'){ ?>
<div class="FmTb">
  <div id="<?php echo $___Ls->fm->bx->id ?>" class="<?php echo DV_GNR_FM_BX ?>" >
    <form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>" >
      <?php $___Ls->_bld_f_hdr(); ?>

      <div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
	  
        <div class="ln_1">
          <div class="col_1">
		  <?php echo HTML_inp_tx('art_tt', TX_NM, ctjTx($___Ls->dt->rw['art_tt'],'in'), FMRQD); ?>
		  <?php echo HTML_inp_tx('art_fn', TX_FNT, ctjTx($___Ls->dt->rw['art_fn'],'in'), FMRQD); ?>
          </div>
          <div class="col_2">
		  <?php echo HTML_textarea('art_dsc', TX_DSCRIP, ctjTx($___Ls->dt->rw['art_dsc'],'in'), '', 'ok'); ?> 		  
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
<?php } ?>
<?php } ?> 