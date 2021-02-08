<?php
if(class_exists('CRM_Cnx')){

	$___Ls->new->w = 500;
	$___Ls->new->h = 350;
	$___Ls->edit->w = 600;
    $___Ls->edit->h = 350;
	$___Ls->ls->lmt = 5000;

    $___Ls->_strt();

	if(!isN($___Ls->gt->i)){

        $___Ls->qrys = sprintf("SELECT * FROM "._BdStr(DBA).TB_AUTO_TP." WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));

	}elseif($___Ls->_show_ls == 'ok'){

		$Ls_Whr = "	FROM "._BdStr(DBA).TB_AUTO_TP."
					WHERE id_autotp != '' AND ".$___Ls->ino." != '' $__fl ".$___Ls->sch->cod."
					ORDER BY autotp_nm ASC";

        $___Ls->qrys = "SELECT *, (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr";

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
				<th width="30%" <?php echo NWRP ?>><?php echo TX_CL?></th>
				<th width="15%" <?php echo NWRP ?>><?php echo 'Key'?></th>
				<th width="15%" <?php echo NWRP ?>><?php echo 'Limite'?></th>
				<th width="3%" <?php echo NWRP ?>><?php echo TX_ACTV ?></th>
				<th width="1%" <?php echo NWRP ?>></th>
			</tr>
			<?php do {

                $__ls_json[] = $___Ls->ls->rw['autotp_enc'];


                $___id = $___Ls->ls->rw[$___Ls->ino];
                $___mnu[$___id] = [
					'id'=>$___id,
					'enc'=>ctjTx($___Ls->ls->rw['autotp_enc'],'in'),
                    'nm'=>ctjTx($___Ls->ls->rw['autotp_nm'],'in'),
                    'key'=>ctjTx($___Ls->ls->rw['autotp_key'],'in'),
					'prnt'=>ctjTx($___Ls->ls->rw['autotp_prnt'],'in'),
					'lmt'=>ctjTx($___Ls->ls->rw['autotp_lmt_rg'],'in'),
                    'est'=>ctjTx($___Ls->ls->rw['autotp_e'],'in'),
                    'btn'=>[
                        'edt'=>$___Ls->_btn([ 't'=>'mod' ])
                    ]
                ];


            } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc());


            $__row = _bTree( $___mnu, '', 'a');

            function _BldLs($p=NULL, $lvl_set='', $_parent_sub=''){

			if($lvl_set != NULL){ $lvl=$lvl_set; }else{ /*$lvl=0;*/ } $lvl=$lvl+1;

			foreach($p as $mn_v){

				$__tt_btn = $mn_v['nm'];
				$__id_prnt = $mn_v['prnt'];

				if($lvl==1){ $NmNw = 2; }

				$__html_b .= '<tr auto-id-no="'.$mn_v['enc'].'" '.cl($mn_v['trlnk'],$Nm,'','','','ok').'>';

				for($i=1; $i<$lvl;$i++){ if($lvl>$i && $__id_prnt != $_parent){ $__li_sub .= '—— '; } }
				if($mn_v['sis']=='ok'){ $_nm_sis='_sis'; }else{ $_nm_sis=''; }

				$__rel_sub = $mn_v['rel'];

				if(!isN($mn_v['rel_sub'])){ $__rel_sub .= ' - '.$mn_v['rel_sub']; }else{ $__rel_sub .= ''; }
				if(!isN($mn_v['rel_tp'])){ $__rel_sub .= ' - '.$mn_v['rel_tp']; }else{ $__rel_sub .= ''; }

				$__html_b .= '
					<td width="1%" '.NWRP.'>'.Spn($mn_v['id'],'','_nmr '.$_nm_sis,'').'</td>
				    <td width="50%" align="left" '.NWRP.' style="text-align:left !important;">'.

				    	$__li_sub.
				    	$__tt_btn.'</br>'.

					'</td>
					<td class="___cl" width="5%" align="left" '.NWRP.'>'.bdiv([ 'cls'=>'bx_dc', 'c'=>'-' ]).'</td>
					<td width="5%" align="left" '.NWRP.'>'.$mn_v['key'].'</td>
					<td width="5%" align="left" '.NWRP.'>'.$mn_v['lmt'].'</td>
					<td width="3%" align="left" '.NWRP.'>'.OLD_HTML_chck('autotp_e_'.$mn_v['enc'], '', $mn_v['est'], 'in', [ 'c'=>'chck_act', 'attr'=>[ 'rel'=> $mn_v['enc'] ] ]).'</td>
					<td width="1%" align="left" '.NWRP.' class="_btn">'.$mn_v['btn']['edt'].'</td>

				';

				if($mn_v['sub'] != NULL){
					$__chld = _BldLs($mn_v['sub'], $lvl, $__id_prnt);
					$__html_b .= $__chld;
				}

				$_parent = $mn_v['prnt'];
				$__html_b .= '</tr>';

			}

			return $__html_b;
		}

            $__html = _BldLs($__row);

			echo $__html;

        ?>
		</table>
        <?php

            $CntJV .=	"

                function __getOrgJs(){

					$.post('".Fl_Rnd(FL_JSON_GN.__t('auto_tp_ext',true))."', { auto_tp:'".implode(',', $__ls_json)."' },

					function(d, status){
						if(d.e == 'ok'){
							if( d.total > 0 ){
								$.each(d.l, function(_k, _v) {
									if(!isN(_v.cl)){
										var li = '';
										$('tr[auto-id-no='+_v.id+'] .bx_dc').html('');

										$.each(_v.cl, function(_k_cl, _v_cl) {

												li += '<li style=\"background-image:url(".DMN_FLE_CL_TH."'+_v_cl.img+');\" alt=\"'+_v_cl.nm+'\"> </li>';

										});

										$('tr[auto-id-no='+_v.id+'] .bx_dc').html( li );
									}
								});
							}
						}
					});
				}

				var __sclacc_bx_form_itm = $('.___cl');

				__sclacc_bx_form_itm.off('click').click(function(e){
					var __vl = $(this).parent().attr('auto-id-no');
					_ldCnt({
						u:'".FL_LS_GN.__t('auto_cl',true).ADM_LNK_DT."' + __vl+'&Rnd='+Math.random(),
						pop:'ok',
						pnl:{
							e:'ok',
							s: 'l',
							tp:'h',
						},
						trs:true
					});
				});

            ";

			$CntWb .= " setTimeout(function(){ __getOrgJs(); ".$__grph_shw." }, 1000); ";


			$CntJV .= "

				$('.chck_act').click(function() {

					if($(this).is(':checked')) { var est = '1'; } else { var est = '2'; }
					var id_chck = $(this).attr('rel');

					_Rqu({
						t:'auto_tp',
						f:'prc',
						MM_update_est: 'EdAutoTp',
						autotp_e: est,
						autotp_enc: id_chck,
						_bs:function(){ $('.__slc_ok').addClass('_prc_ld'); },
						_cm:function(){ $('.__slc_ok').removeClass('_prc_ld'); },
						_cl:function(_r){
							if(!isN(_r)){

							}
						}
					});
				});
			";

        $___Ls->_bld_l_pgs();

        ?>

	<?php } ?>
	<?php $___Ls->_h_ls_nr(); ?>
<?php } ?>
<?php if($___Ls->fm->chk=='ok'){ ?>

	<div class="FmTb">
	  <div id="<?php  echo DV_GNR_FM ?>">

	    <form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>" >
	      <?php $___Ls->_bld_f_hdr(); ?>
		  <div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?> app_dashboard">
	        <div class="ln_1">

  				<div>
					<div class="col_1">
						<?php echo HTML_inp_tx('autotp_nm', TX_NM, ctjTx($___Ls->dt->rw['autotp_nm'],'in')); ?>
						<?php echo HTML_inp_tx('autotp_key', TX_KEY, ctjTx($___Ls->dt->rw['autotp_key'],'in')); ?>
						<?php echo HTML_inp_tx('autotp_lmt_rg', 'Limite de registros', ctjTx($___Ls->dt->rw['autotp_lmt_rg'],'in')); ?>


		          	</div>
		          	<div class="col_2">
						<?php echo LsAutoTp([ 'id'=>'autotp_prnt', 'v'=>'id_autotp', 'va'=>$___Ls->dt->rw['autotp_prnt'] , 'ph'=>'Id superior', 'rq'=>2 ]); $CntWb .= JQ_Ls('autotp_prnt'); ?>
						<?php echo OLD_HTML_chck('autotp_e', TX_ACTV, $___Ls->dt->rw['autotp_e'], 'in'); ?>
					</div>
	          	</div>
			</div>
	      </div>
	    </form>
	  </div>
	</div>
<?php } ?>
<?php } ?>

<style>
	.bx_dc li{ border: 1px solid #c8c8c8;display: inline-block;vertical-align: top;border-radius: 200px;-moz-border-radius: 200px;-webkit-border-radius: 200px;width: 20px;height: 20px;background-size: 100% auto;margin-right: 5px;margin-top: -4px;background-repeat: no-repeat;background-position: center;}
	._prc_ld {pointer-events: none;opacity: 0.5;}
</style>