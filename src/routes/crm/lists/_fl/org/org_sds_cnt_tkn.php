    <?php if(class_exists('CRM_Cnx')){

        $__id_fm = 'BxFm'.$___Ls->rnd;

        $__sds = Php_Ls_Cln($_GET['_sds']);

        $Ls_Qry = "SELECT 
                        orgsdscntpss_enc, orgsdscntpss_orgsdscnt, orgsdscntpss_orgsds, orgsdscntpss_eml, 
                        AES_DECRYPT(orgsdscntpss_pss, '".ENCRYPT_PASSPHRASE."' ) as pss, orgsdscntpss_est
                    FROM 
                        ".TB_ORG_SDS_CNT_PSS."
                        INNER JOIN ".TB_ORG_SDS_CNT." ON id_orgsdscnt = orgsdscntpss_orgsdscnt
                    WHERE 
                        id_orgsdscntpss != '' AND orgsdscnt_enc = '".$__i."' ";

        $Ls = $__cnx->_qry($Ls_Qry); 
        $row_Ls = $Ls->fetch_assoc(); 
        $Tot_Ls = $Ls->num_rows;

        if($Tot_Ls == 1){
            $cnt = GtOrgSdsCntDt([ 'id' => $row_Ls['orgsdscntpss_orgsdscnt'], 'tpro'=>ID_ORGTP_MARKS, 'orgsds'=> $__sds ]);
            $tt = '';
            $cls = 'ok';
        }else{
            $cnt = GtOrgSdsCntDt([ 'id' => $__i, 'tpro'=> ID_ORGTP_MARKS, 't' => 'enc', 'orgsds'=> $__sds ]);  
            $tt = 'No tiene token';
            $cls = 'no';
        }
        
            $CntWb .= "
    
                        $('.add_tkn').off('click').click(function(e){         
                            $('.no_tkn').addClass('no');
                            $('.cmp_tkn').addClass('ok');    
                        });

                        $('#sve_tkn').off('click').click(function(e){         
                            e.preventDefault();
								
                            if(e.target != this){ 
                                e.stopPropagation(); 
                                return false;
                            }else{
                                if( $('#{$__id_fm}').valid() ){
                                    swal({
                                        title: '".TX_ETSGR."',
                                        text: '".TX_SWAL_SVE."',
                                        type: 'info',
                                        showCancelButton: true,
                                        confirmButtonColor: '#64b764',
                                        confirmButtonText:'".TX_ACPT."',
                                        cancelButtonText: '".TX_CNCLR."'
                                    },
                                    function(){
                                        $.ajax({
                                            type: 'POST',
                                            dataType: 'json',
                                            url: '".Fl_Rnd(PRC_GN.__t('org_sds_cnt_tkn',true))."',
                                            data: $('#{$__id_fm}').serialize(),
                                            beforeSend: function() {
                                                $('#{$__id_fm}_ld').fadeIn();
                                                $('#{$__id_fm}_flds').fadeOut();
                                            },
                                            success: function(d){ 
                                                if(d.e == 'ok'){
                                                    SUMR_Main.pnl.f.shw();
                                                }
                                            }
                                        })
                                    });
                                }
                            }    
                        });
                    ";
        ?>
        
            <div class="sec_tkn">
                <div class="logo"></div>
                <div class="no_tkn">
                    <div class="tt"><?php echo h1($tt); ?></div>
                    <div class="add_tkn <?php echo $cls; ?>"></div>           
                </div>

                <div class="FmTb">
                    <div id="<?php echo $___Ls->fm->bx->id ?>" class="<?php echo DV_GNR_FM_BX ?>" >
                        <form method="POST" name="<?php echo $__id_fm; ?>" target="_self" id="<?php echo $__id_fm; ?>">    
                            <div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
                                <div class="ln_1">
                                    <div class="cmp_tkn <?php echo $cls; ?>">
                                        <?php if($Tot_Ls == 1){
                                            echo HTML_inp_hd('MM_update', 'EdOrgSdsCntTkn');
                                            echo HTML_inp_hd('orgsdscntpss_enc', $row_Ls['orgsdscntpss_enc']);
                                            echo h1($row_Ls['orgsdscntpss_eml']);
                                            echo HTML_inp_tx('orgsdscntpss_pss', TX_PSS, $row_Ls['pss'], FMRQD);     
                                            echo OLD_HTML_chck('orgsdscntpss_est', 'Estado', $row_Ls['orgsdscntpss_est'], 'in'); 

                                        }else{    
                                            echo HTML_inp_hd('MM_insert', 'EdOrgSdsCntTkn');
                                            echo HTML_inp_hd('orgsdscntpss_orgsdscnt', $cnt->id);
                                            echo HTML_inp_hd('orgsdscntpss_orgsds', $__sds);
                                            echo LsCntEml([ 'cnt'=>$cnt->cnt->id, 'id'=>'orgsdscntpss_eml', 'v'=>'cnteml_enc', 'va'=>'', 'rq'=>'ok' ]); 
                                            $CntWb .= JQ_Ls('orgsdscntpss_eml', ''); 
                                            echo HTML_inp_tx('orgsdscntpss_pss', TX_PSS, '', FMRQD); ?>     
                                            
                                        <?php } ?>  
                                        <button id="sve_tkn" class="btn_sve_tkn"></button>                        
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php } ?>

    <style>
        .sec_tkn{border:2px dashed #dadada;padding:30px 60px 0px 60px;border-radius:12px;position:absolute;left:50%;top:50%;transform:translate(-50%,-50%);-webkit-transform:translate(-50%,-50%)}
        .sec_tkn .logo{width:130px;display:block;margin:0 auto;height:130px;border:1px solid #171717;border-radius:50%;opacity:.5;background-position:center;background-repeat:no-repeat;background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>plcy_icn.svg);background-size:60% auto}
        .cmp_tkn h1, .tt h1{text-align:center;color:gray;font-family:Economica;font-size:20px;padding:0!important;margin:10px 0!important;border:0!important}
        .sec_tkn .add_tkn{width:50px;height:50px;margin:0 auto;cursor:pointer;background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>addi.svg)}
        
        .no_tkn{display:block}
        .cmp_tkn{display:none;}
        .no_tkn.no{display:none}
        .cmp_tkn.ok{display:block;}
        .btn_sve_tkn{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>diskette.svg);width: 40px;height: 40px;margin: 15px auto 0;display: block;border: 0;background-size: 55% auto;background-color: #45B39C;background-repeat: no-repeat;background-position: center;border-radius: 50%;}
        .add_tkn.no{display:block}
        .add_tkn.ok{display:none}
    </style>