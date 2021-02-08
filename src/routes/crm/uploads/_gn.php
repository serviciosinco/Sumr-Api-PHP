<?php

	$Rt = '../../includes/';
	$_cls_xls = 'ok';
	$Rstr = 'adm';
	include($Rt.'inc.php');

	ob_start("cmpr_fm");
	Hdr_HTML();
	$__id_unq = Gn_Rnd(5);

	$___Ls = new CRM_Ls();

	$__w = Php_Ls_Cln($_GET['_w']);
?>
<?php /*if(($_GET['_pop']=='ok')){ $_bxpop = 'ok'; ?>
    <div class="pop_cnt">
    <?php echo bdiv(['id'=>ICN_LDR_POP]); ?>
<?php }*/ ?>

<?php

	$__t = Php_Ls_Cln($_GET['_t']);
	$_i = Php_Ls_Cln($_GET['_i']);
	$__i = Php_Ls_Cln($_GET['__i']);
 	$__prfx = _Fx_Prx(['v'=>$__t]);

?>

<div class="___UpGn">

<?php if($_i != ''){ ?>

	<?php $__fm_dt = GtUpDt([ 'id'=>$_i, 't'=>'enc' ]); ?>

	<div class="__w_edt _anm" id="__w_edt<?php echo $__id_unq ?>">
		<div class="__bx _anm">
				<a href="<?php echo Void(); ?>" class="_x" onclick="__w_edt();"></a>
				<div class="__flds">
					<form action="" method="POST" target="_self" name="Sve<?php echo $__id_unq ?>" id="Sve<?php echo $__id_unq ?>">
						<?php echo HTML_inp_tx('up_nm', TX_NM, $__fm_dt->nm); ?>
						<?php echo HTML_inp_tx('up_tp', TX_TP, $__fm_dt->tp); ?>
						<?php echo HTML_inp_tx('up_ext', TX_EXT, $__fm_dt->ext); ?>
						<?php echo HTML_inp_tx('up_row', TX_ROWS, $__fm_dt->row); ?>
						<?php echo HTML_inp_tx('up_col', TX_COLS, $__fm_dt->col); ?>
						<?php echo HTML_BR; //echo HTML_inp_tx('up_est', TX_EST, $__fm_dt->est); ?>
						<?php $l = __Ls([ 'k'=>'up_est', 'id'=>'up_est', 'va'=>$___Ls->dt->rw['up_est'], 'ph'=>TX_ETD ]); echo $l->html; $CntWb .= $l->js; ?>


						<?php if($__t == 'ec_lsts_up'){ ?>
							<input id="__ec_lsts_rlc" name="__ec_lsts_rlc" type="hidden" value="<?php echo $__i ?>" />
						<?php }elseif($__t == 'sms_cmpg_up'){ ?>
							<input id="__sms_cmpg_rlc" name="__sms_cmpg_rlc" type="hidden" value="<?php echo $__i ?>" />
						<?php }elseif($__t == 'act_cnt_up'){ ?>
							<input id="__act_rlc" name="__act_rlc" type="hidden" value="<?php echo $__i ?>" />
						<?php } ?> ?>


						<input id="MM_update" name="MM_update" type="hidden" value="EdUp" />
						<input id="id_up" name="id_up" type="hidden" value="<?php echo $__fm_dt->id ?>" />

					</form>
				</div>
				<div><input name="BtnSve<?php echo $__id_unq ?>" id="BtnSve<?php echo $__id_unq ?>" type="button" class="n"  value="<?php echo TXBT_GRDR ?>"></div>
		</div>
	</div>


	<section id="__bar<?php echo $__id_unq ?>" class="__up_btn _anm">

		<div id="__edt<?php echo $__id_unq ?>" class="__up_edt _anm"></div>


		<div id="__ldr<?php echo $__id_unq ?>" class="__ldr _anm" style="display:none;"><?php echo TX_LDING ?></div>
		<div id="__rsl<?php echo $__id_unq ?>" class="__rsl _anm" style="display:none;"></div>

		<?php /* ?>
		<div class="_in_icn">
			<div class="_in_ok"><span></span> Ingresado</div>
			<div class="_in_no"><span></span> No Ingresado</div>
			<div class="_in_exs"><span></span> Ya Existe</div>
		</div>
		<?php */ ?>
		<?php if($__fm_dt->est == _CId('ID_UPEST_LD') || $__fm_dt->est == _CId('ID_UPEST_COLS')){ ?>
		<input id="__import<?php echo $__id_unq ?>" name="__import<?php echo $__id_unq ?>" class="_in_btn" type="button" value="Importar Datos"/>
		<?php } ?>
	</section>

	<div id="__ovr<?php echo $__id_unq ?>" class="__ovr" style="display:none;"></div>

<?php } ?>
<?php

	if($__t == 'cnt' || $__t == 'mdl_cnt' || $__t == 'mdl_cnt_tra' || $__t == 'snd_ec_lsts_up' || $__t == 'dnc' || $__t == 'sms_cmpg_up' || $__t == 'sms_cmpg' || $__t == 'act_cnt_up'){
		include('a_cnt.php');
	}

	$CntWb .= "$('.chosen-select').chosen({ width: '100%', allow_single_deselect:true });";


	if(!isN($__id_fm)){

		$_CntJV .= "

			var _ldr = $('#__ldr".$__id_unq."');
			var _fm = $('#".$__id_fm."');
			var _fmrsl = $('#__rsl".$__id_unq."');
			var _bar = $('#__bar".$__id_unq."');
			var _ovr = $('#__ovr".$__id_unq."');
			var _db = $('#_db_exc');

			function Data_ShLodSndCnt(_cl) {
				_ldr.fadeIn('slow', function(){
						_bar.addClass('_prc');
						_ovr.fadeIn('slow', function(){
								if(_cl!='' && _cl!='undefined' && _cl!=null){
									_cl();
								}
						});
				});

			}


			function Sve_ShLodSndCnt(_cl) {
				_ldr.fadeIn('slow', function(){
					_bar.addClass('_prc');
					_ovr.fadeIn('slow', function(){
						if(_cl!='' && _cl!='undefined' && _cl!=null){
							_cl();
						}
					});
				});

			}


			function Data_GetRsl(_r){
				_ldr.fadeOut('slow', function(){
					_ovr.fadeOut('slow', function(){
						_bar.removeClass('_prc');
						if (_r.e == 'ok') {
							_db.addClass('_db_up_prc');
							_fm.fadeOut('slow', function(){
								_db.fadeIn('fast');
							});
						}
					});
				});
			}


			function Sve_GetRsl(_r){
				_ldr.fadeOut('slow', function(){
					_ovr.fadeOut('slow', function(){

						_ovr.fadeOut('fast');
						_bar.removeClass('_prc');
						_ldr.fadeOut('fast');

						if(_r.e == 'ok'){
							Cll".$__id_unq.".closeAllPanels();
						}

					});
				});
			}



		";

		$_CntJV .= "

			function __w_edt(_p){

				var _w = $('#__w_edt{$__id_unq}');

				if(_p == undefined){ _p = ''; }

				if( !_w.hasClass('_opn') || _p.o == 'ok' ){
					_w.addClass('_opn');
				}else{
					_w.removeClass('_opn');
				}

			}


			$('#__exec".$__id_unq."').click(function(){ __w_exc({ o:'ok' }); });
			$('#__edt".$__id_unq."').click(function(){ __w_edt({ o:'ok' }); });


			$('#BtnSve".$__id_unq."').click(function(){
				Sve_ShLodSndCnt( function(){
					$.ajax({
							type: 'POST',
							url: '".PRC_GN."?_t=up',
							dataType: 'json',
							data: $('#Sve".$__id_unq."').serialize(),
							async: false,
							success: function(_r){
										Sve_GetRsl(_r);
							}
					});
				});
			});


			$('#__import".$__id_unq."').click(function(){
				Data_ShLodSndCnt( function(){
					$.ajax({
							type: 'POST',
							url: '".PRC_UPLD_GN."?_t=".$___tp_up."',
							dataType: 'json',
							data: $('#".$__id_fm."').serialize(),
							async: false,
							success: function(_r){
								/*Data_GetRsl(_r);*/
								$.colorbox.close();
							}
					});
				});
			});

		";

	}

?>
<script type="text/javascript">
	<?php echo $_CntJV; ?>
	$(function(){ <?php echo $CntWb ?> });
</script>
</div>
<?php ob_end_flush(); ?>