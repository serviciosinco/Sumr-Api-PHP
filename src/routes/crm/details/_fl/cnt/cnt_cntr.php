<?php 

	
	
	$Ls_Pro_Qry  = " 
						SELECT * FROM ".TB_CNT_CNTR."
						WHERE id_cntcntr != '' AND cntcntr_enc = '$__i'
						ORDER BY id_cntcntr DESC 
					";
					
		  
	$Ls_Pro = $__cnx->_qry($Ls_Pro_Qry);
	$row_Ls_Pro = $Ls_Pro->fetch_assoc(); 
	$Tot_Ls_Pro = $Ls_Pro->num_rows;						

	 
?>

<div class="ln_1">
	<ul class="ls_1" id="dtll2">
		<?php
			
			if(!isN($row_Ls_Pro['cntcntr_1'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Nombres y Apellidos ", '', true).ctjTx($row_Ls_Pro['cntcntr_1'], 'in'); ?></li><?php } /* -B- 1 */
			if(!isN($row_Ls_Pro['cntcntr_2'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Tipo sangre ", '', true).ctjTx($row_Ls_Pro['cntcntr_2'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_3'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Edad ", '', true).ctjTx($row_Ls_Pro['cntcntr_3'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_4'])){ ?><li class="" id="_li_nm"><?php echo Strn(" CC ", '', true).ctjTx($row_Ls_Pro['cntcntr_4'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_5'])){ ?><li class="" id="_li_nm"><?php echo Strn(" TI ", '', true).ctjTx($row_Ls_Pro['cntcntr_5'], 'in'); ?></li><?php }
				
			if(!isN($row_Ls_Pro['cntcntr_6'])){ ?><li class="" id="_li_nm"><?php echo Strn(" CE ", '', true).ctjTx($row_Ls_Pro['cntcntr_6'], 'in'); ?></li><?php } /* -B- 2 */
			if(!isN($row_Ls_Pro['cntcntr_7'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Pasap. ", '', true).ctjTx($row_Ls_Pro['cntcntr_7'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_8'])){ ?><li class="" id="_li_nm"><?php echo Strn(" No. ", '', true).ctjTx($row_Ls_Pro['cntcntr_8'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_9'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Nacionalidad ", '', true).ctjTx($row_Ls_Pro['cntcntr_9'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_10'])){ ?><li class="" id="_li_nm"><?php echo Strn(" D ", '', true).ctjTx($row_Ls_Pro['cntcntr_10'], 'in'); ?></li><?php }
				
			if(!isN($row_Ls_Pro['cntcntr_11'])){ ?><li class="" id="_li_nm"><?php echo Strn(" M ", '', true).ctjTx($row_Ls_Pro['cntcntr_11'], 'in'); ?></li><?php } /* -B- 3 */
			if(!isN($row_Ls_Pro['cntcntr_12'])){ ?><li class="" id="_li_nm"><?php echo Strn(" A ", '', true).ctjTx($row_Ls_Pro['cntcntr_12'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_13'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Lugar de nacimiento ", '', true).ctjTx($row_Ls_Pro['cntcntr_13'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_14'])){ ?><li class="" id="_li_nm"><?php echo Strn(" M ", '', true).ctjTx($row_Ls_Pro['cntcntr_14'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_15'])){ ?><li class="" id="_li_nm"><?php echo Strn(" F ", '', true).ctjTx($row_Ls_Pro['cntcntr_15'], 'in'); ?></li><?php }
				
			if(!isN($row_Ls_Pro['cntcntr_16'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Ciudad donde reside ", '', true).ctjTx($row_Ls_Pro['cntcntr_16'], 'in'); ?></li><?php } /* -B- 4 */
			if(!isN($row_Ls_Pro['cntcntr_17'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Direccion (Corresp.) ", '', true).ctjTx($row_Ls_Pro['cntcntr_17'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_18'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Email ", '', true).ctjTx($row_Ls_Pro['cntcntr_18'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_19'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Telefono ", '', true).ctjTx($row_Ls_Pro['cntcntr_19'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_20'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Celular ", '', true).ctjTx($row_Ls_Pro['cntcntr_20'], 'in'); ?></li><?php }
				
			if(!isN($row_Ls_Pro['cntcntr_21'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Colegio / Universidad donde estudia ", '', true).ctjTx($row_Ls_Pro['cntcntr_21'], 'in'); ?></li><?php } /* -B- 5 */
			if(!isN($row_Ls_Pro['cntcntr_22'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Curso ", '', true).ctjTx($row_Ls_Pro['cntcntr_22'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_23'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Ciudad ", '', true).ctjTx($row_Ls_Pro['cntcntr_23'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_24'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Universidad donde (va a) estudiar ", '', true).ctjTx($row_Ls_Pro['cntcntr_24'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_25'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Carrera ", '', true).ctjTx($row_Ls_Pro['cntcntr_25'], 'in'); ?></li><?php }
				
			if(!isN($row_Ls_Pro['cntcntr_26'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Pregrado ", '', true).ctjTx($row_Ls_Pro['cntcntr_26'], 'in'); ?></li><?php } /* -B- 6 */
			if(!isN($row_Ls_Pro['cntcntr_27'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Semestre ", '', true).ctjTx($row_Ls_Pro['cntcntr_27'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_28'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Postgrado ", '', true).ctjTx($row_Ls_Pro['cntcntr_28'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_29'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Practicas ", '', true).ctjTx($row_Ls_Pro['cntcntr_29'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_30'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Especializacion ", '', true).ctjTx($row_Ls_Pro['cntcntr_30'], 'in'); ?></li><?php }
				
			if(!isN($row_Ls_Pro['cntcntr_31'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Docente ", '', true).ctjTx($row_Ls_Pro['cntcntr_31'], 'in'); ?></li><?php } /* -B- 7 */
			if(!isN($row_Ls_Pro['cntcntr_32'])){ ?><li class="" id="_li_nm"><?php echo Strn(" 1 ", '', true).ctjTx($row_Ls_Pro['cntcntr_32'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_33'])){ ?><li class="" id="_li_nm"><?php echo Strn(" 2 ", '', true).ctjTx($row_Ls_Pro['cntcntr_33'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_34'])){ ?><li class="" id="_li_nm"><?php echo Strn(" 3 ", '', true).ctjTx($row_Ls_Pro['cntcntr_34'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_35'])){ ?><li class="" id="_li_nm"><?php echo Strn(" 4 ", '', true).ctjTx($row_Ls_Pro['cntcntr_35'], 'in'); ?></li><?php }
				
			if(!isN($row_Ls_Pro['cntcntr_36'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Primera vez en city u ", '', true).ctjTx($row_Ls_Pro['cntcntr_36'], 'in'); ?></li><?php } /* -B- 8 */
			if(!isN($row_Ls_Pro['cntcntr_37'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Tienes roommates con los que desees mudarte ", '', true).ctjTx($row_Ls_Pro['cntcntr_37'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_38'])){ ?><li class="" id="_li_nm"><?php echo Strn(" 1 ", '', true).ctjTx($row_Ls_Pro['cntcntr_38'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_39'])){ ?><li class="" id="_li_nm"><?php echo Strn(" 2 ", '', true).ctjTx($row_Ls_Pro['cntcntr_39'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_40'])){ ?><li class="" id="_li_nm"><?php echo Strn(" 3 ", '', true).ctjTx($row_Ls_Pro['cntcntr_40'], 'in'); ?></li><?php }
				
			if(!isN($row_Ls_Pro['cntcntr_41'])){ ?><li class="" id="_li_nm"><?php echo Strn(" 4 ", '', true).ctjTx($row_Ls_Pro['cntcntr_41'], 'in'); ?></li><?php } /* -B- 9 */
			if(!isN($row_Ls_Pro['cntcntr_42'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Tienes roommates con los que no desees mudarte ", '', true).ctjTx($row_Ls_Pro['cntcntr_42'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_43'])){ ?><li class="" id="_li_nm"><?php echo Strn(" 1 ", '', true).ctjTx($row_Ls_Pro['cntcntr_43'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_44'])){ ?><li class="" id="_li_nm"><?php echo Strn(" 2 ", '', true).ctjTx($row_Ls_Pro['cntcntr_44'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_45'])){ ?><li class="" id="_li_nm"><?php echo Strn(" 3 ", '', true).ctjTx($row_Ls_Pro['cntcntr_45'], 'in'); ?></li><?php }
				
			if(!isN($row_Ls_Pro['cntcntr_46'])){ ?><li class="" id="_li_nm"><?php echo Strn(" 4 ", '', true).ctjTx($row_Ls_Pro['cntcntr_46'], 'in'); ?></li><?php } /* -B- 10 */
			if(!isN($row_Ls_Pro['cntcntr_47'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Tabaco ", '', true).ctjTx($row_Ls_Pro['cntcntr_47'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_48'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Alcohol ", '', true).ctjTx($row_Ls_Pro['cntcntr_48'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_49'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Ruido ", '', true).ctjTx($row_Ls_Pro['cntcntr_49'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_50'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Desorden ", '', true).ctjTx($row_Ls_Pro['cntcntr_50'], 'in'); ?></li><?php }
				
			if(!isN($row_Ls_Pro['cntcntr_51'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Otro ", '', true).ctjTx($row_Ls_Pro['cntcntr_51'], 'in'); ?></li><?php } /* -B- 11 */
			if(!isN($row_Ls_Pro['cntcntr_52'])){ ?><li class="" id="_li_nm"><?php echo Strn(" EPS ", '', true).ctjTx($row_Ls_Pro['cntcntr_52'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_53'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Medinica Prepagada ", '', true).ctjTx($row_Ls_Pro['cntcntr_53'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_54'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Texto Aquí ", '', true).ctjTx($row_Ls_Pro['cntcntr_54'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_55'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Texto Aquí ", '', true).ctjTx($row_Ls_Pro['cntcntr_55'], 'in'); ?></li><?php }
				
			if(!isN($row_Ls_Pro['cntcntr_56'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Nombres y Apellidos", '', true).ctjTx($row_Ls_Pro['cntcntr_56'], 'in'); ?></li><?php } /* -B- 12 */
			if(!isN($row_Ls_Pro['cntcntr_57'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Texto Aquí ", '', true).ctjTx($row_Ls_Pro['cntcntr_57'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_58'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Texto Aquí ", '', true).ctjTx($row_Ls_Pro['cntcntr_58'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_59'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Texto Aquí ", '', true).ctjTx($row_Ls_Pro['cntcntr_59'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_60'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Texto Aquí ", '', true).ctjTx($row_Ls_Pro['cntcntr_60'], 'in'); ?></li><?php }
				
			if(!isN($row_Ls_Pro['cntcntr_61'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Nombres y Apellidos", '', true).ctjTx($row_Ls_Pro['cntcntr_61'], 'in'); ?></li><?php } /* -B- 13 */
			if(!isN($row_Ls_Pro['cntcntr_62'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Texto Aquí ", '', true).ctjTx($row_Ls_Pro['cntcntr_62'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_63'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Texto Aquí ", '', true).ctjTx($row_Ls_Pro['cntcntr_63'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_64'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Texto Aquí ", '', true).ctjTx($row_Ls_Pro['cntcntr_64'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_65'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Texto Aquí ", '', true).ctjTx($row_Ls_Pro['cntcntr_65'], 'in'); ?></li><?php }
				
			if(!isN($row_Ls_Pro['cntcntr_66'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Nombres y Apellidos", '', true).ctjTx($row_Ls_Pro['cntcntr_66'], 'in'); ?></li><?php } /* -B- 14 */
			if(!isN($row_Ls_Pro['cntcntr_67'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Texto Aquí ", '', true).ctjTx($row_Ls_Pro['cntcntr_67'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_68'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Texto Aquí ", '', true).ctjTx($row_Ls_Pro['cntcntr_68'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_69'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Texto Aquí ", '', true).ctjTx($row_Ls_Pro['cntcntr_69'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_70'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Texto Aquí ", '', true).ctjTx($row_Ls_Pro['cntcntr_70'], 'in'); ?></li><?php }
				
			if(!isN($row_Ls_Pro['cntcntr_71'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Nombres y Apellidos", '', true).ctjTx($row_Ls_Pro['cntcntr_71'], 'in'); ?></li><?php } /* -B- 15 */
			if(!isN($row_Ls_Pro['cntcntr_72'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Texto Aquí ", '', true).ctjTx($row_Ls_Pro['cntcntr_72'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_73'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Texto Aquí ", '', true).ctjTx($row_Ls_Pro['cntcntr_73'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_74'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Texto Aquí ", '', true).ctjTx($row_Ls_Pro['cntcntr_74'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_75'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Texto Aquí ", '', true).ctjTx($row_Ls_Pro['cntcntr_75'], 'in'); ?></li><?php }
				
			if(!isN($row_Ls_Pro['cntcntr_76'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Nombres y Apellidos", '', true).ctjTx($row_Ls_Pro['cntcntr_76'], 'in'); ?></li><?php } /* -B- 16 */
			if(!isN($row_Ls_Pro['cntcntr_77'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Texto Aquí ", '', true).ctjTx($row_Ls_Pro['cntcntr_77'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_78'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Texto Aquí ", '', true).ctjTx($row_Ls_Pro['cntcntr_78'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_79'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Texto Aquí ", '', true).ctjTx($row_Ls_Pro['cntcntr_79'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_80'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Texto Aquí ", '', true).ctjTx($row_Ls_Pro['cntcntr_80'], 'in'); ?></li><?php }
				
			if(!isN($row_Ls_Pro['cntcntr_81'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Nombres y Apellidos", '', true).ctjTx($row_Ls_Pro['cntcntr_81'], 'in'); ?></li><?php } /* -B- 17 */
			if(!isN($row_Ls_Pro['cntcntr_82'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Texto Aquí ", '', true).ctjTx($row_Ls_Pro['cntcntr_82'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_83'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Texto Aquí ", '', true).ctjTx($row_Ls_Pro['cntcntr_83'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_84'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Texto Aquí ", '', true).ctjTx($row_Ls_Pro['cntcntr_84'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_85'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Texto Aquí ", '', true).ctjTx($row_Ls_Pro['cntcntr_85'], 'in'); ?></li><?php }
				
			if(!isN($row_Ls_Pro['cntcntr_86'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Nombres y Apellidos", '', true).ctjTx($row_Ls_Pro['cntcntr_86'], 'in'); ?></li><?php } /* -B- 18 */
			if(!isN($row_Ls_Pro['cntcntr_87'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Texto Aquí ", '', true).ctjTx($row_Ls_Pro['cntcntr_87'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_88'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Texto Aquí ", '', true).ctjTx($row_Ls_Pro['cntcntr_88'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_89'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Texto Aquí ", '', true).ctjTx($row_Ls_Pro['cntcntr_89'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_90'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Texto Aquí ", '', true).ctjTx($row_Ls_Pro['cntcntr_90'], 'in'); ?></li><?php }
				
			if(!isN($row_Ls_Pro['cntcntr_91'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Nombres y Apellidos", '', true).ctjTx($row_Ls_Pro['cntcntr_91'], 'in'); ?></li><?php } /* -B- 19 */
			if(!isN($row_Ls_Pro['cntcntr_92'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Texto Aquí ", '', true).ctjTx($row_Ls_Pro['cntcntr_92'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_93'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Texto Aquí ", '', true).ctjTx($row_Ls_Pro['cntcntr_93'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_94'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Texto Aquí ", '', true).ctjTx($row_Ls_Pro['cntcntr_94'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_95'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Texto Aquí ", '', true).ctjTx($row_Ls_Pro['cntcntr_95'], 'in'); ?></li><?php }
				
			if(!isN($row_Ls_Pro['cntcntr_96'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Nombres y Apellidos", '', true).ctjTx($row_Ls_Pro['cntcntr_96'], 'in'); ?></li><?php } /* -B- 20 */
			if(!isN($row_Ls_Pro['cntcntr_97'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Texto Aquí ", '', true).ctjTx($row_Ls_Pro['cntcntr_97'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_98'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Texto Aquí ", '', true).ctjTx($row_Ls_Pro['cntcntr_98'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_99'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Texto Aquí ", '', true).ctjTx($row_Ls_Pro['cntcntr_99'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_100'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Texto Aquí ", '', true).ctjTx($row_Ls_Pro['cntcntr_100'], 'in'); ?></li><?php }
				
			if(!isN($row_Ls_Pro['cntcntr_101'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Nombres y Apellidos", '', true).ctjTx($row_Ls_Pro['cntcntr_101'], 'in'); ?></li><?php } /* -B- 21 */
			if(!isN($row_Ls_Pro['cntcntr_102'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Texto Aquí ", '', true).ctjTx($row_Ls_Pro['cntcntr_102'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_103'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Texto Aquí ", '', true).ctjTx($row_Ls_Pro['cntcntr_103'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_104'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Texto Aquí ", '', true).ctjTx($row_Ls_Pro['cntcntr_104'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_105'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Texto Aquí ", '', true).ctjTx($row_Ls_Pro['cntcntr_105'], 'in'); ?></li><?php }
				
			if(!isN($row_Ls_Pro['cntcntr_106'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Nombres y Apellidos", '', true).ctjTx($row_Ls_Pro['cntcntr_106'], 'in'); ?></li><?php } /* -B- 22 */
			if(!isN($row_Ls_Pro['cntcntr_107'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Texto Aquí ", '', true).ctjTx($row_Ls_Pro['cntcntr_107'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_108'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Texto Aquí ", '', true).ctjTx($row_Ls_Pro['cntcntr_108'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_109'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Texto Aquí ", '', true).ctjTx($row_Ls_Pro['cntcntr_109'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_110'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Texto Aquí ", '', true).ctjTx($row_Ls_Pro['cntcntr_110'], 'in'); ?></li><?php }
				
			if(!isN($row_Ls_Pro['cntcntr_111'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Nombres y Apellidos", '', true).ctjTx($row_Ls_Pro['cntcntr_111'], 'in'); ?></li><?php } /* -B- 23 */
			if(!isN($row_Ls_Pro['cntcntr_112'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Texto Aquí ", '', true).ctjTx($row_Ls_Pro['cntcntr_112'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_113'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Texto Aquí ", '', true).ctjTx($row_Ls_Pro['cntcntr_113'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_114'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Texto Aquí ", '', true).ctjTx($row_Ls_Pro['cntcntr_114'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_115'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Texto Aquí ", '', true).ctjTx($row_Ls_Pro['cntcntr_115'], 'in'); ?></li><?php }
				
			if(!isN($row_Ls_Pro['cntcntr_116'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Nombres y Apellidos", '', true).ctjTx($row_Ls_Pro['cntcntr_116'], 'in'); ?></li><?php } /* -B- 24 */
			if(!isN($row_Ls_Pro['cntcntr_117'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Texto Aquí ", '', true).ctjTx($row_Ls_Pro['cntcntr_117'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_118'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Texto Aquí ", '', true).ctjTx($row_Ls_Pro['cntcntr_118'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_119'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Texto Aquí ", '', true).ctjTx($row_Ls_Pro['cntcntr_119'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_120'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Texto Aquí ", '', true).ctjTx($row_Ls_Pro['cntcntr_120'], 'in'); ?></li><?php }
				
			if(!isN($row_Ls_Pro['cntcntr_121'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Nombres y Apellidos", '', true).ctjTx($row_Ls_Pro['cntcntr_121'], 'in'); ?></li><?php } /* -B- 25 */
			if(!isN($row_Ls_Pro['cntcntr_122'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Texto Aquí ", '', true).ctjTx($row_Ls_Pro['cntcntr_122'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_123'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Texto Aquí ", '', true).ctjTx($row_Ls_Pro['cntcntr_123'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_124'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Texto Aquí ", '', true).ctjTx($row_Ls_Pro['cntcntr_124'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_125'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Texto Aquí ", '', true).ctjTx($row_Ls_Pro['cntcntr_125'], 'in'); ?></li><?php }
				
			if(!isN($row_Ls_Pro['cntcntr_126'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Nombres y Apellidos", '', true).ctjTx($row_Ls_Pro['cntcntr_126'], 'in'); ?></li><?php } /* -B- 26 */
			if(!isN($row_Ls_Pro['cntcntr_127'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Texto Aquí ", '', true).ctjTx($row_Ls_Pro['cntcntr_127'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_128'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Texto Aquí ", '', true).ctjTx($row_Ls_Pro['cntcntr_128'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_129'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Texto Aquí ", '', true).ctjTx($row_Ls_Pro['cntcntr_129'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_130'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Texto Aquí ", '', true).ctjTx($row_Ls_Pro['cntcntr_130'], 'in'); ?></li><?php }
				
			if(!isN($row_Ls_Pro['cntcntr_131'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Nombres y Apellidos", '', true).ctjTx($row_Ls_Pro['cntcntr_131'], 'in'); ?></li><?php } /* -B- 27 */
			if(!isN($row_Ls_Pro['cntcntr_132'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Texto Aquí ", '', true).ctjTx($row_Ls_Pro['cntcntr_132'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_133'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Texto Aquí ", '', true).ctjTx($row_Ls_Pro['cntcntr_133'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_134'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Texto Aquí ", '', true).ctjTx($row_Ls_Pro['cntcntr_134'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_135'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Texto Aquí ", '', true).ctjTx($row_Ls_Pro['cntcntr_135'], 'in'); ?></li><?php }
				
			if(!isN($row_Ls_Pro['cntcntr_136'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Nombres y Apellidos", '', true).ctjTx($row_Ls_Pro['cntcntr_136'], 'in'); ?></li><?php } /* -B- 28 */
			if(!isN($row_Ls_Pro['cntcntr_137'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Texto Aquí ", '', true).ctjTx($row_Ls_Pro['cntcntr_137'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_138'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Texto Aquí ", '', true).ctjTx($row_Ls_Pro['cntcntr_138'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_139'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Texto Aquí ", '', true).ctjTx($row_Ls_Pro['cntcntr_139'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_140'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Texto Aquí ", '', true).ctjTx($row_Ls_Pro['cntcntr_140'], 'in'); ?></li><?php }
				
			if(!isN($row_Ls_Pro['cntcntr_141'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Nombres y Apellidos", '', true).ctjTx($row_Ls_Pro['cntcntr_141'], 'in'); ?></li><?php } /* -B- 29 */
			if(!isN($row_Ls_Pro['cntcntr_142'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Texto Aquí ", '', true).ctjTx($row_Ls_Pro['cntcntr_412'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_143'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Texto Aquí ", '', true).ctjTx($row_Ls_Pro['cntcntr_143'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_144'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Texto Aquí ", '', true).ctjTx($row_Ls_Pro['cntcntr_144'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_145'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Texto Aquí ", '', true).ctjTx($row_Ls_Pro['cntcntr_145'], 'in'); ?></li><?php }
				
			if(!isN($row_Ls_Pro['cntcntr_146'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Nombres y Apellidos", '', true).ctjTx($row_Ls_Pro['cntcntr_146'], 'in'); ?></li><?php } /* -B- 30 */
			if(!isN($row_Ls_Pro['cntcntr_147'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Texto Aquí ", '', true).ctjTx($row_Ls_Pro['cntcntr_147'], 'in'); ?></li><?php }
			if(!isN($row_Ls_Pro['cntcntr_148'])){ ?><li class="" id="_li_nm"><?php echo Strn(" Texto Aquí ", '', true).ctjTx($row_Ls_Pro['cntcntr_148'], 'in'); ?></li><?php }
				
		?>
	</ul>
</div>

<?php  ?>