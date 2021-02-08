<?php $Rt = '../../includes/'; $__tme_s = microtime(true); $__fbsrc = 'ok'; include($Rt.'inc.php'); ob_start("cmpr_fm"); Hdr_HTML();


	//---------------------- GROUP LIST ----------------------//

		define('GL', __f());
		define('GL_DWN', __f('dwn'));


	//---------------------- VARIABLES GET ----------------------//

		$___Ls = new CRM_Ls();

		$__i = Php_Ls_Cln($_POST['_i']);
		$__t = Php_Ls_Cln($_GET['_t']);
		$__t2 = Php_Ls_Cln($_GET['_t2']);
		$__tp = Php_Ls_Cln($_GET['_tp']);
		$__prfx = _Fx_Prx(['v'=>$__t]);

	//---------------------- INCLUSIÓN DE ARCHIVOS ----------------------//


		if($__t =='mdl_cnt'){

            $_bt_inf = 'ok';
            $___to_inc = GL_DWN.'mdl_cnt.php';

        }elseif($__t =='cnt_appl'){

            $_bt_inf = 'ok';
            $___to_inc = GL_DWN.'cnt_appl.php';

        }


		if($___to_inc != ''){ include($___to_inc); }


?>

	<script type="text/javascript">

		try{

			<?php echo /*$___Fm->jv.*/$_CntJV; ?>
			$('#__Ldr_Sis').addClass('_inf_ldr');

			$('#__opn').off('click').click(function() {

				if( $( "#cboxContent" ).hasClass('_cls_tb') ){
					$( "#cboxContent" ).removeClass('_cls_tb');
				}else{
					$( "#cboxContent" ).addClass('_cls_tb');
				}
			});

		}catch(e){
			console.log( 'Error:', e );
		}


        $(function() {

            try{
				SUMR_Main.ld.f.upl( function(){
					try{
						$('._inf').fadeIn('fast');
						$('#__Ldr_Sis').removeClass('_inf_ldr');
						<?php echo $_bldr->js.$CntWb ?>
					}catch(e){
						console.log( 'Error:', e );
					}
				});
			}catch(e){
				console.log( 'Error:', e );
			}

        });

    </script>

<?php ob_end_flush(); ?>