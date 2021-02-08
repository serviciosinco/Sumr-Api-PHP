<?php 

    $_org_dt = GtOrgSdsArrDt([ 'i'=>$__i, 't'=>'orgsds_enc' ]);

    echo SlDt([ 'id'=>'orgsdsarrsls_f', 'va'=>$__t_s_e, 'rq'=>'ok', 'ph'=>'Fecha' ]);

    echo HTML_inp_hd('orgsdsarrsls_f_hd', $__t_s_e ); 

    if($_org_dt->mnt == 1){

        $CntWb .= "
            var sls = $('#orgsdsarrsls_vl').val();

            if(sls > 0){ $('#orgsdsarrsls_vl').show(); }else{ $('#orgsdsarrsls_vl').hide(); }
            
            $('#orgsdsarrsls_f').on('change',function(){

                var date_slc = $(this).val();

                var date = new Date(date_slc);
                var ultimoDia = new Date(date.getFullYear(), date.getMonth()+1, 0);

                var dia  = ultimoDia.getDate();

                var dates = new Date(date_slc);
                dates = dates.getDate() + 1;

                if(dates == dia){ $('#orgsdsarrsls_vl').show(); }else{ $('#orgsdsarrsls_vl').hide().val(0);	}
            });
        ";

    }
    
    echo HTML_inp_tx('orgsdsarrsls_vl', "Ventas" , $__t_s_i, FMRQD_NM);

    $CntWb .= "
        try{
            $('#orgsdsarrsls_vl').keyup(function(p){
                if( !isN($(this).val()) ){
                    if( isNaN($(this).val()) ){
                        $('.__orgsdsarrsls_vl ._vl').html('Numero no valido');
                        $('.__orgsdsarrsls_vl ._vl').addClass('_err');
                    }else{
                        $('.__orgsdsarrsls_vl ._vl').removeClass('_err');
                        let _num_frmt = $(this).val().replace(/\./g,'');
                        _num_frmt = _num_frmt.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
                        _num_frmt = _num_frmt.split('').reverse().join('').replace(/^[\.]/,'');
                        $('.__orgsdsarrsls_vl ._vl').html(_num_frmt);
                    }
                }else{
                    $('.__orgsdsarrsls_vl ._vl').html(0);
                }
            });

        }catch(e){
            SUMR_Main.log.f({ t:'Error en div __orgsdsarrsls_vl:', m:e });
        }
    ";

?>