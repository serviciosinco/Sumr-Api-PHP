<?php 

	if($_fld_v->attr->key->vl == 'prd_req_tv'){ 
							
		$__key_go = '____ext_'.$__id_rnd.''.$vl;
	
		$_CntJQ_S2 .= "
	
			$('input[name=\'____ext_".$__id_rnd."[appl][".$_fld_v->attr->key->vl."]\']').addClass('hde');
	
			$('input:radio[name=\'____ext_".$__id_rnd."[appl][alq_tv]\']').change(function(){
				if($(this).val() == '"._CId('ID_SISSINO_SI')."'){
					$('input[name=\'____ext_".$__id_rnd."[appl][".$_fld_v->attr->key->vl."]\']').removeClass('hde');
				}else{
					$('input[name=\'____ext_".$__id_rnd."[appl][".$_fld_v->attr->key->vl."]\']').addClass('hde');  
					$( '.__prd_tv_add' ).remove();  
				}
			});
	
			$('input[name=\'____ext_".$__id_rnd."[appl][".$_fld_v->attr->key->vl."]\']').on('input', function () { 
				this.value = this.value.replace(/[^0-9]/g,'');
	
				if(!isN(this.value)){
					var vl = $(this).val();
					if(vl > 5){
						swal('Error', 'Solo se pueden solicitar 5 periodos.', 'error'); 
					}else{
						var _id = $(this).parent().parent().parent().attr('id');
	
						$( '.__prd_tv_add' ).remove();
	
						for (var i=1; i<= vl; i++) {
							var _rnd = Math.random().toString(15).substr(2);
	
							var fst_div = '<div class=\'_blq _c _c1\'><div class=\'_fd\'><span>Periodo '+((vl-i)+1)+'</span></div></div>';
							var scd_div = '<div class=\'_blq _c _c2\'><div class=\'_fd\'>".SlDt([ 'a'=>'ok', 'id'=>"date_tv_in_'+_rnd+'", 'rq'=>'no', 'n'=>''.$__key_go.'[fch_ini_tv_prd_\'+((vl-i)+1)+\']', 'ph'=>'Fecha Inicio Tv Periodo \'+((vl-i)+1)+\'', 'mth'=>'ok', 'yr'=>'ok','lmt'=>'no', 'cls'=>CLS_CLND ])->html."</div></div>';
							var thr_div = '<div class=\'_blq _c _c3\'><div class=\'_fd\'>".SlDt([ 'a'=>'ok', 'id'=>"date_tv_out_'+_rnd+'", 'rq'=>'no', 'n'=>''.$__key_go.'[fch_fin_tv_prd_\'+((vl-i)+1)+\']', 'ph'=>'Fecha fin Tv Periodo \'+((vl-i)+1)+\'', 'mth'=>'ok', 'yr'=>'ok','lmt'=>'no', 'cls'=>CLS_CLND ])->html."</div></div>';
							val_slc = '';
							$('#'+_id).after('<div class=\'__prd_tv_add _ln cx6 mdl\' id=\''+_rnd+'\'>'+fst_div+' '+scd_div+' '+thr_div); 	 
	
							$('#date_tv_in_'+_rnd).datepicker({ closeText:'Borrar', showButtonPanel:true, dateFormat:'yy-mm-dd' , minDate: '+0m',
	
							onSelect: function(selectedDate) { 
	
							var rnd = $(this).parent().parent().parent().parent().attr('id');
							
							var date = new Date(selectedDate);
							var month = date.getMonth() + 4;
							var day = date.getDate();
							var year = date.getFullYear();
							
							if(month > 12){ var y = year + 1; }else{ var y = year; }
							if(month > 12){ var m = month - 12; }else{ var m = month; }

							$('#date_tv_out_'+rnd).datepicker('destroy');
							$('#date_tv_out_'+rnd).val('');

							$('#date_tv_out_'+rnd).datepicker({
								closeText:'Borrar', showButtonPanel:true, dateFormat:'yy-mm-dd', minDate: new Date( y, m - 1 , day ), onClose:function (dateText,inst){ if($(window.event.srcElement).hasClass('ui-datepicker-close')) { document.getElementById(this.id).value=''; } }, changeYear:true,changeMonth:true });

							},
							onClose:function (dateText,inst){ if($(window.event.srcElement).hasClass('ui-datepicker-close')) { document.getElementById(this.id).value=''; } }, changeYear:true,changeMonth:true });
	
						}
					}		
				}
			});
		";
	}	
	
	if($_fld_v->attr->key->vl == 'prd_req_nvr'){ 
	
		$__key_go = '____ext_'.$__id_rnd.''.$vl;
	
		$_CntJQ_S2 .= "
	
			$('input[name=\'____ext_".$__id_rnd."[appl][".$_fld_v->attr->key->vl."]\']').addClass('hde');
			
			$('input:radio[name=\'____ext_".$__id_rnd."[appl][alq_mini_nev]\']').change(function(){
				if($(this).val() == '"._CId('ID_SISSINO_SI')."'){
					$('input[name=\'____ext_".$__id_rnd."[appl][".$_fld_v->attr->key->vl."]\']').removeClass('hde');
				}else{
					$('input[name=\'____ext_".$__id_rnd."[appl][".$_fld_v->attr->key->vl."]\']').addClass('hde');  
					$( '.__prd__nvr_add' ).remove();  
				}
			});
	
			$('input[name=\'____ext_".$__id_rnd."[appl][".$_fld_v->attr->key->vl."]\']').on('input', function () { 
				this.value = this.value.replace(/[^0-9]/g,'');
	
				if(!isN(this.value)){
					var vl = $(this).val();
					if(vl > 5){	
						swal('Error', 'Solo se pueden solicitar 5 periodos.', 'error'); 
					}else{
						var _id = $(this).parent().parent().parent().attr('id');
	
						$( '.__prd__nvr_add' ).remove();
	
						for (var i=1; i<= vl; i++) {
							var _rnd = Math.random().toString(15).substr(2);
							var fst_div = '<div class=\'_blq _c _c1\'><div class=\'_fd\'><span>Periodo '+((vl-i)+1)+'</span></div></div>';
							var scd_div = '<div class=\'_blq _c _c2\'><div class=\'_fd\'>".SlDt([ 'a'=>'ok', 'id'=>"date_nvr_in_'+_rnd+'", 'rq'=>'no', 'n'=>''.$__key_go.'[fch_ini_nvr_prd_\'+((vl-i)+1)+\']', 'ph'=>'Fecha Inicio Nevera Periodo \'+((vl-i)+1)+\'', 'mth'=>'ok', 'yr'=>'ok','lmt'=>'no', 'cls'=>CLS_CLND ])->html."</div></div>';
							var thr_div = '<div class=\'_blq _c _c3\'><div class=\'_fd\'>".SlDt([ 'a'=>'ok', 'id'=>"date_nvr_out_'+_rnd+'", 'rq'=>'no', 'n'=>''.$__key_go.'[fch_fin_nvr_prd_\'+((vl-i)+1)+\']', 'ph'=>'Fecha fin Nevera Periodo \'+((vl-i)+1)+\'', 'mth'=>'ok', 'yr'=>'ok','lmt'=>'no', 'cls'=>CLS_CLND ])->html."</div></div>';
							$('#'+_id).after('<div class=\'__prd__nvr_add _ln cx6 mdl\' id=\''+_rnd+'\'>'+fst_div+' '+scd_div+' '+thr_div); 	 
						
							$('#date_nvr_in_'+_rnd).datepicker({ closeText:'Borrar', showButtonPanel:true, dateFormat:'yy-mm-dd' , minDate: '+0m',
						
								onSelect: function(selectedDate) { 
						
								var rnd = $(this).parent().parent().parent().parent().attr('id');
								
								var date = new Date(selectedDate);
								var month = date.getMonth() + 4;
								var day = date.getDate();
								var year = date.getFullYear();
								
								if(month > 12){ var y = year + 1; }else{ var y = year; }
								if(month > 12){ var m = month - 12; }else{ var m = month; }
								
								$('#date_nvr_out_'+rnd).datepicker('destroy');
								$('#date_nvr_out_'+rnd).val('');
						
								$('#date_nvr_out_'+rnd).datepicker({
								closeText:'Borrar', showButtonPanel:true, dateFormat:'yy-mm-dd', minDate: new Date( y, m - 1 , day ), onClose:function (dateText,inst){ if($(window.event.srcElement).hasClass('ui-datepicker-close')) { document.getElementById(this.id).value=''; } }, changeYear:true,changeMonth:true });
						
							},
							onClose:function (dateText,inst){ if($(window.event.srcElement).hasClass('ui-datepicker-close')) { document.getElementById(this.id).value=''; } }, changeYear:true,changeMonth:true });
	
						}
					}		
				}
			});
		";
	
	}
	
	if($_fld_v->attr->key->vl  == 'tp_vnc_uni'){
		$_CntJQ_S2 .= "
			$('#Lssmt".$__id_rnd."').addClass('hde');
			$('#".$__f_id."').on('change', function() {
				$('#Lssmt".$__id_rnd."').addClass('hde').val('');
				var option = $('option:selected', this).attr('data');
			
				if(option != 'cprt' && option != 'dct' && option != 'fnc'){
					$('#Lssmt".$__id_rnd."').removeClass('hde');	
				}		
			});	
		";	
	}
	
	if($_fld_v->attr->key->vl  == 'idm_dmo'){
		$_CntJQ_S2 .= '
			$(".hvr").off("click").click(function(e){
			
				var rel = $(this).attr("rel");
				var id = $(this).attr("id");
			
				if($(this).hasClass("ok")){
					$(this).removeClass("ok");
					$("#"+id+" input").val("");		
				}else{
					$(this).addClass("ok");	
					$("#"+id+" input").val(rel);
				}
			});';	
	}	
	
	if(!isN($_fld_v->attr->opc_oth->vl) && $_fld_v->attr->opc_oth->vl == 1) { 
		$_CntJQ_S2 .= "	
		
			function __clr".$__id_rnd."() { console.clear(); }
			
			$('#$__f__id').change(function() {
				var _t__v = $(this).val();
			
				if( _t__v != '-oth-'){
			
				}else{ 
					$('#Ls".$__f__id."').fadeOut();
					$('#bx_ls_1_".$__f__id."').fadeIn();		
				}
			});
			
			$('#Opc_Oth".$__f__id."').change(function() {
				var _t__v = $(this).val();
				if(_t__v == '-wrt-'){
					$('#bx_ls_1_".$__f__id."').fadeOut();
					$('#bx_ls_2_".$__f__id."').fadeIn();
				}
			});
			
			$('#Opc_Oth".$__f__id."').select2({
				placeholder: ' - escribe el nombre de la ciudad -',
				minimumInputLength: 3,
				ajax: {
					url:'/json/lista_o.json',
					dataType: 'json',
					delay: 250,
					method:'POST',
					data: function (params) {
				
						$('#OthWrt{$__f__id}').val(params.term);
					
						return {
							__t: 'prg',
							__q: params.term
						};
					},
					processResults: function (d) {
						__clr".$__id_rnd."();
						return { results: d.items };
					},
					cache: true
				}	
			});			
		"; 
	}
	
	if($_fld_v->attr->key->vl == 'slt_romt' && $__cntr_fm->romt == 1){
		$_CntJQ_S2 .= '
								
			function __DomFnc_'.$__rnd.'(){
				$("button.otro").off("click").click(function(e){
				
					e.preventDefault();
					
					if(e.target != this){
						e.stopPropagation();
						return;
					}else{
						__BldHtml'.$__rnd.'(); 
					} 
				}); 
				
				$("button.ok").off("click").click(function(e){
					e.preventDefault();
				
					if(e.target != this){
						e.stopPropagation();
						return;
					}else{
						var rel = $(this).attr("rel");
						var div = $(this).parent().attr("id");
						$("#"+div+" input[type=hidden]").val(1);	
						$("#"+div+" button").removeClass("chck");
						$(this).addClass("chck");
					} 
				}); 
				$("button.no").off("click").click(function(e){
					e.preventDefault();
					
					if(e.target != this){
						e.stopPropagation();
						return;
					}else{
						var rel = $(this).attr("rel");
						var div = $(this).parent().attr("id");
						$("#"+div+" input[type=hidden]").val(2);	
						$("#"+div+" button").removeClass("chck");
						$(this).addClass("chck");	 
					} 
				}); 
			} 
			function __BldHtml'.$__rnd.'(){
			
				var __unq_id = Math.random().toString(36).substr(2);
				var __rnd_bx = \'romt_'.$__rnd.'_opt_\'+__unq_id;
				$("#romt_'.$__rnd.'").append(\'<div id="\'+__rnd_bx+\'"></div>\');
				var __bxnw_id = $(\'#\'+__rnd_bx);
				__bxnw_id.append("'._HTML_Input("romt_cnt[\"+__unq_id+\"][cnt]", $__f_ph, $__f_v, $__f_rq, $__f_tp).'");
				__bxnw_id.append(\''.HTML_inp_hd("romt_cnt['+__unq_id+'][tp]",'').'\');
				__bxnw_id.append(\'<button data-tooltip="Roommate con el que deseo mudarme." rel="\'+__unq_id+\'" class="ok _anm">Bueno</button><button data-tooltip="Roommate con el que no deseo mudarme." rel="\'+__unq_id+\'" class="no _anm">Malo</button>\');
				__DomFnc_'.$__rnd.'();  
			}
			
			__BldHtml'.$__rnd.'(); 
		
		';	
	}
	
	if($_fld_v->attr->key->vl == 'prd_drc_cntr'){
		$_CntJQ_S2 .= " 
								
			$('#prd__".$__f_id."').on('input', function () { 
				this.value = this.value.replace(/[^0-9]/g,'');
		
				if(!isN(this.value)){
					var vl = $(this).val();
					if(vl > 5){	
						swal('Error', 'Solo se pueden solicitar 5 periodos.', 'error'); 
					}else{
						var _id = $(this).parent().parent().parent().attr('id');
						$( '.__prd_add' ).remove();
		
						for (var i=1; i<= vl; i++) {
							var _rnd = Math.random().toString(15).substr(2);
							var fst_div = '<div class=\'_blq _c _c1\'><div class=\'_fd\'><span>Periodo '+((vl-i)+1)+'</span></div></div>';
							var scd_div = '<div class=\'_blq _c _c2\'><div class=\'_fd\'>".SlDt([ 'a'=>'ok', 'id'=>"date_in_'+_rnd+'", 'rq'=>'no', 'n'=>''.$__key_go.'[fch_ini_prd_\'+((vl-i)+1)+\']', 'ph'=>'Fecha Inicio Periodo \'+((vl-i)+1)+\'', 'mth'=>'ok', 'yr'=>'ok','lmt'=>'no', 'cls'=>CLS_CLND ])->html."</div></div>';
							var thr_div = '<div class=\'_blq _c _c3\'><div class=\'_fd\'>".SlDt(['a'=>'ok','id'=>"date_out_'+_rnd+'",'rq'=>'no','n'=>''.$__key_go.'[fch_fin_prd_\'+((vl-i)+1)+\']', 'ph'=>'Fecha fin Periodo \'+((vl-i)+1)+\'', 'mth'=>'ok', 'yr'=>'ok','lmt'=>'no', 'cls'=>CLS_CLND ])->html."</div></div>';
							$('#'+_id).after('<div class=\'__prd_add _ln cx6 mdl\' id=\''+_rnd+'\'>'+fst_div+' '+scd_div+' '+thr_div); 	 
		
							$('#date_in_'+_rnd).datepicker({ closeText:'Borrar', showButtonPanel:true, dateFormat:'yy-mm-dd' , minDate: '+0m',
		
							onSelect: function(selectedDate) { 
		
								var rnd = $(this).parent().parent().parent().parent().attr('id');
		
								var date = new Date(selectedDate);
								var month = date.getMonth() + 2;
								var day = date.getDate();
								var year = date.getFullYear();
		
								if(month > 12){ var y = year + 1; }else{ var y = year; }
								if(month > 12){ var m = month - 12; }else{ var m = month; }
		
								$('#date_nvr_out_'+_rnd).datepicker('destroy');
		
								$('#date_out_'+rnd).datepicker({
								closeText:'Borrar', showButtonPanel:true, dateFormat:'yy-mm-dd', minDate: new Date( y, m - 1 , day ), onClose:function (dateText,inst){ if($(window.event.srcElement).hasClass('ui-datepicker-close')) { document.getElementById(this.id).value=''; } }, changeYear:true,changeMonth:true });
		
							},onClose:function (dateText,inst){ if($(window.event.srcElement).hasClass('ui-datepicker-close')) { document.getElementById(this.id).value=''; } }, changeYear:true,changeMonth:true });
		
						}
					}		
				}
			});
		";
	}
	
	if($_fld_v->attr->key->vl == 'cs_no_tlr'){ 
		
		$_CntJQ_S2 .= ' 
								
			$("li.opc").off("click").click(function(e){
		
				var rel = $(this).attr("rel");
				var data = $(this).attr("data");
				
				$(this).toggleClass("ok");
				if($(this).hasClass("ok")){
					$("#vl_"+rel).val("1");		
				}else{
					$("#vl_"+rel).val("");		
				}
				
				var _rnd = Math.random().toString(15).substr(2);
				
				if(data == "oth" && $(this).hasClass("ok")){
					var __id = $(this).parent().attr("id");
					$("#"+__id).append("<li class=\"item_tpc_oth\" id=\"i_"+_rnd+"\"><input type=\"text\" name=\"____ext__10ea4f1c39104fa2a079[appl][oth_tpc]\" id=\"oth_tpc_10ea4f1c39104fa2a079\" style=\"\" placeholder=\"\" value=\"\" autocomplete=\"email\"></li>");	
				
					$("#i_"+_rnd+" input").attr("name", "____ext__10ea4f1c39104fa2a079[appl][oth_tpc]["+rel+"]");
				}else if(data == "oth" && !$(this).hasClass("ok")){
					$(".item_tpc_oth").remove();	
				}
			}); 
		';
		
	}
	
	if($_fld_v->attr->key->vl == 'cnt_fn'){
		$_CntJQ .= "								
			$('#".$__f_id."').on('change', function () {
				var dob = $(this).datepicker('getDate');
				var age = GetAge(dob);
				$('#edad".$__id_rnd."').val(age).attr('readonly', 'readonly');
				
				function GetAge(birthDate) {
					var today = new Date();
					var age = today.getFullYear() - birthDate.getFullYear();
					var m = today.getMonth() - birthDate.getMonth();
					if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {  age--; }
					return age;    
				}
			});			
		";
	}
	
?>