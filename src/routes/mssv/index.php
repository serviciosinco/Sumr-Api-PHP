<?php

	try{

		include("../../includes/inc.php");


		define('MSV_HST', 'massive-db1.cd437whamugk.us-east-1.rds.amazonaws.com');
		define('MSV_DB', 'nmgrid');
		define('MSV_PORT', '5432');
		define('MSV_DB_US', 'massivespaceappl');
		define('MSV_DB_US_PSS', 'massivespacepl2018');
		define('MSV_URL_MEDIA', 'https://server.massivespace.rocks/media/');


		function PG_CnRdi($p=NULL){
			$_cn = new PDO("pgsql:dbname=".MSV_DB.";host=".MSV_HST.";port=".MSV_PORT."", MSV_DB_US, MSV_DB_US_PSS); return($_cn);
		}


		$cnx = PG_CnRdi();

		$_qry = '	SELECT *,
							NOW() AS _d_now,

							(
								SELECT COUNT(DISTINCT _inout.phone_origin)
								FROM int_message_inout_t AS _inout
								WHERE _inout.account_id = _acc.id
									  AND _inout.inout = \'I\'
									  AND _inout.channel_id IS NULL
							) AS _tot_chnl_queu,

							(
								SELECT COUNT(DISTINCT _inout.phone_origin)
								FROM int_message_inout_t AS _inout
								WHERE _inout.account_id = _acc.id
									  AND _inout.inout = \'I\'
									  /*AND _inout.channel_id IS NULL*/
							) AS _tot_chnl_no,

							(
								SELECT COUNT(DISTINCT _inout.phone_origin)
								FROM int_message_inout_t AS _inout
								WHERE _inout.account_id = _acc.id
									  AND _inout.inout = \'I\'
									  AND _inout.channel_id IS NOT NULL
							) AS _tot_chnl_ok

					FROM int_accounts_t AS _acc
						 INNER JOIN int_companies_t ON _acc.company_id = int_companies_t.id
					WHERE _acc.is_enabled = \'t\'
					ORDER BY name ASC
				';

		//echo $_qry;


		$Ls_RgC = $cnx->prepare($_qry);

	}catch(Exception $e){

		echo 'Exception Error:'.$e->getMessage();

	}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin - MassiveSpace</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="css/all.css">
</head>

<body>
	<section class="main_box">
		<figure class="logo"></figure>


		<?php if($Ls_RgC->execute()){ ?>
			<?php

				$row_Ls_RgC = $Ls_RgC->fetchAll(PDO::FETCH_ASSOC);
				$Tot_Ls_RgC = Pdo_Fix_RwTot($Ls_RgC);

			?>
			<?php if($Tot_Ls_RgC > 0){ ?>

			<div class="accounts">
				<?php foreach ($row_Ls_RgC as $rC){ ?>

					<?php


						$__d_le = new DateTime($rC['last_execution'], new DateTimeZone('UTC'));
						$__d_le->setTimezone(new DateTimeZone('America/Bogota'));

						$__d_nw = new DateTime($rC['_d_now'], new DateTimeZone('UTC'));
						$__d_nw->setTimezone(new DateTimeZone('America/Bogota'));


						$__lcl_d = $__d_le->format('Y-m-d h:i:s a');
						$__lcl_now = $__d_nw->format('Y-m-d h:i:s a');

						$__intrv = $__d_le->diff($__d_nw);

						$__down = '';

						echo '<ul style="background-image:url('.MSV_URL_MEDIA.$rC['logo'].');">';

							echo li($rC['name'], 'name');
							echo li($rC['username'], 'phone');
							if(!isN($__lcl_d)){ echo li($__lcl_d, 'last_executed'); }
							if(!isN($rC['connection_fail'])){ echo li($rC['connection_fail'], 'cnx_fail'); }


							if(!isN($rC['_tot_chnl_no'])){ echo li('Clientes '.Strn('('.$rC['_tot_chnl_no'].')'), 'chnl'); }
							if(!isN($rC['_tot_chnl_ok'])){ echo li('Conversaciones '.Strn('('.$rC['_tot_chnl_ok'].')'), 'chnl'); }
							if(!isN($rC['_tot_chnl_queu'])){ echo li('Clientes sin Atender '.Strn('('.$rC['_tot_chnl_queu'].')'), 'chnl'); }

							if(!isN($__intrv->format('%h')) || !isN($__intrv->format('%i'))){

								if(!isN($__intrv->format('%h'))){ $__down = li($__intrv->format('%h').' horas', 'hours'); }
								if(!isN($__intrv->format('%i'))){ $__down .= li($__intrv->format('%i').' minutos', 'minutes'); }

								echo li( '<ul>'.$__down.'</ul>' , '__down' );

							}




						echo '</ul>';


					?>
				<?php } ?>

			</div>

			<?php

				}else{

					echo '0 Records';
				}

			?>

		<?php

			}else{

				echo 'Problem on Execute';

			}

		?>


		<button id="exc_cnct" class="exc">Restaurar Líneas</button>

		<button id="exc_vnc" class="exc">Iniciar VNC</button>


	</section>
</body>
</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="https://js.sumr.cloud/sweetalert.js?_etag=<?php echo E_TAG ?>"></script>
<script type="text/javascript">


	$(document).ready(function() {

		var ___btn_kill = $('#exc_cnct');
		var ___btn_vnc = $('#exc_vnc');

		___btn_kill.click(function() {

			$.ajax({
				type: 'POST',
				dataType: 'json',
				url:'account_restart.php',
				beforeSend: function() {
					___btn_kill.addClass('_on');
				},
				success: function(d) {

				    if(d.e == 'ok'){

					 	swal({
						    title:'Exitoso',
						    text:'Se ejecuta comando, espera 5 minutos',
						    type:'success'
						});

				    }else{

					    swal({
						    title:'Problemas',
						    text:'No se ejecuta comando',
						    type:'error'
						});

				    }

				},
				complete: function(){
					___btn_kill.removeClass('_on');
				}
			});
		});




		___btn_vnc.click(function() {

			$.ajax({
				type: 'POST',
				dataType: 'json',
				url:'server_vnc.php',
				beforeSend: function() {
					___btn_vnc.addClass('_on');
				},
				success: function(d) {



				    if(d.e == 'ok'){

					 	swal({
						    title:'Exitoso',
						    text:'Se ejecuta comando, espera 5 minutos',
						    type:'success'
						});

				    }else{

					    swal({
						    title:'Problemas',
						    text:d.m,
						    type:'error'
						});

				    }

				},
				complete: function(){
					___btn_vnc.removeClass('_on');
				}
			});
		});



	});

</script>