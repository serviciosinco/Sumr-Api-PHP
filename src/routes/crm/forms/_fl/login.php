<?php

	$__us = new CRM_Us();

	if($_GET['_rcnct'] == 'ok'){ $_mrpth = '../../'; $_rcnct='ok'; $_rcnct_cls='_rcnct'; }
	if($_GET['_inc'] == 'ok'){ $_rt= $_mrpth.'../'; $Rt = $_mrpth.'../includes/'; /*$Rstr = 'adm';*/ include($Rt.'inc.php'); }

	$__inc = Php_Ls_Cln($_GET['_inc']);
	$__id_rnd = Php_Ls_Cln($_GET['_key']);
	$__fP = Php_Ls_Cln($_GET['_fP']);

	if(!isN($__fP)){
		$__fP_d = $__us->UsFrgtChk([ 't'=>'enc', 'id'=>$__fP ]);
		if($__fP_d->hb=='ok'){
			$_new_bx_cls='rg_npss';
			$_CntJV .= "$('#BxFmOpt').addClass('gpss');";
		}else{
			$_CntJV .= "

				swal(
					'Link Vencido',
					'Intenta solicitar un nuevo link',
					'error'
				);

				SUMR_Main.url_r();
			";
		}
	}
?>
<?php if($_rcnct=='ok'){ ob_start("cmpr_fm"); }?>
<?php if($_rcnct=='ok'){ ?><div id="ldr_lgin" class="ldr <?php echo $_rcnct_cls; ?>"></div><?php } ?>

<?php if($_rcnct != 'ok'){ ?>
<div id="login_logo" class="login_logo <?php echo $_rcnct_cls; ?>">
	<div class="_w">
		<div class="cl_logo"></div>
	</div>
</div>
<?php } ?>

<div class="login _anm <?php echo $_rcnct_cls; ?>" id="bx_login">
	<div class="intro_wrp">
        <div class="col_1 bx _anm <?php echo $_new_bx_cls; ?>" id="BxFm" style="display:none;">
			<?php if(defined('DB_CL_ON') && DB_CL_ON == 'ok'){ ?>
				<form action="javascript:void(0);" class="__lgnus _anm" name="FrLogIn<?php echo $__id_rnd; ?>" id="FrLogIn<?php echo $__id_rnd ?>" autocomplete="off">
					<input id="____key" name="____key" type="hidden" value="<?php echo $__id_rnd ?>" />
					<input id="____dvc" name="____dvc" type="hidden" value="" />
					<input id="____kp" name="____kp" style="display:none;" type="password" value="" />
					<div id="LgInFm_Cm<?php echo $__id_rnd; ?>">
						<div id="LgInFm_Cm_Ld<?php echo $__id_rnd; ?>"></div>
						<div><button id="LgInFm_Btn<?php echo $__id_rnd; ?>" class="btndo _anm" type="button">entrar</button></div>
					</div>
					<div id="Ldr"></div>
					<div id="Rsl"></div>
				</form>

				<?php if($_rcnct != 'ok'){ ?>
				<form action="javascript:void(0);" class="__gpss _anm">
					<div class="sumr-eml _anm">
						<input id="____r_email_frgpss" name="____r_email_frgpss" autocomplete="off" type="email" placeholder="Correo Electrónico" value="" class="eml _anm" />
						<span class="icn _anm"></span>
					</div>
					<div id="____r_send_frgpss" class="_anm"><?php echo TX_SND ?></div>
				</form>
				<form action="javascript:void(0);" class="__gpss_new _anm" style="<?php echo $__gpss_chk; ?>">
					<div class="sumr-nwpss _anm">
						<input id="____gpss_pass_new" name="____gpss_pass_new" autocomplete="off" type="password" placeholder="Nueva clave" value="" />
						<span class="icn _anm"></span>
					</div>
					<div class="sumr-nwpssc _anm">
						<input id="____gpss_pass_new_chk" name="____gpss_pass_new_chk" autocomplete="off" type="password" placeholder="Confirmar clave" value="" />
						<span class="icn _anm"></span>
					</div>
					<div id="____r_send_frgpss_new" class="_anm"><?php echo TX_SND ?></div>
				</form>
				<?php } ?>

			<?php }else{ ?>
				<div class="cl_off"><h1>Cuenta<h2>deshabilitada</h2></h1></div>
			<?php } ?>
		</div>
		<?php if($_rcnct != 'ok'){ ?>
			<div class="_opts _anm" id="BxFmOpt">
				<ul class="_wrp _anm">
					<li class="frg _anm">
						<button id="_frgpss" class="_frg _anm"><?php echo TX_RCPCLV ?></button>
					</li>
					<li class="bck _anm">
						<button id="lgin_bck" class="_bck _anm"><?php echo 'Volver' ?></button>
					</li>
				</ul>
			</div>
			<div class="sis_brand <?php if(!isN($__dt_cl->rsllr) && $__dt_cl->rsllr->e == 'ok'){ echo 'rsllr'; } ?>">
            	<div class="sumr_logo"></div>
            	<div class="rsllr_logo" style="background-image:url(<?php echo $__dt_cl->rsllr->lgo->rsllr->big; ?>);"></div>
            </div>
        <?php } ?>
  	</div>
</div>

<?php if($_rcnct != 'ok'){ ?>
	<div id="fot_lgin" style="display:none;">
	<?php include(DIR_INC_ESTR.'footer.php'); ?>
<?php } ?>

</div>
<?php
	if($_rcnct=='ok'){
		//$_CntJQ .= "SUMR_Frnt.login.form();";
	}
?>
<?php if($__inc == 'ok'){ ?>
<script type="text/javascript">
	<?php echo $_CntJV ?>
	$(function() {
		<?php echo $_CntJQ.$_CntJQLgin.$_CntJQ_Vld ?>
	});
</script>
<?php if($_rcnct=='ok'){ ob_end_flush(); }?>
<?php } ?>