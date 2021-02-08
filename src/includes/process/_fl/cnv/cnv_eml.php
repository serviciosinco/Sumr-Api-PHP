<?php
    
// Ingreso de Registro

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdCnvTmlne")) { 
    
    $__prcall = 'ok';
    $__snd = new API_CRM_SndMail();
    $__eml = new CRM_Eml();

    $__eml_sndr = Php_Ls_Cln($_POST['emlsnd_sndr']);
    $__eml_cnt = Php_Ls_Cln($_POST['emlsnd_eml']);
    $__eml_sbj = Php_Ls_Cln($_POST['emlsnd_sbj']);
    $__eml_text = Php_Ls_Cln($_POST['emlsnd_text']);
    $__mdl_cnt =  Php_Ls_Cln($_POST['mdlcntcnv_mdlcnt']);

    $__cnv_rplyto = Php_Ls_Cln($_POST['mdlcntcnv_rply_to']);

    //------- From - To / Data -------//

        $__from_dt = GtEmlDt([ 'id'=>$__eml_sndr, 't'=>'enc', 'pss'=>'ok' ]);
        $__to_dt = GtCntEmlDt(['id'=>$__eml_cnt, 'tp'=>'enc' ]);

    //------- If it is a reply on Conversation -------//

        if(!isN($__cnv_rplyto)){ 
            $__cnv_rplyto_dt = $__eml->EmlMsgDt([ 't'=>'enc', 'id'=>$__cnv_rplyto ]);
        }

        if(!isN($__cnv_rplyto_dt->id)){
            if(!isN($__cnv_rplyto_dt->cid)){
                $__snd->in_reply_to = $__cnv_rplyto_dt->cid;
            }
        }else{
            $__mdlcnt_dt = GtMdlCntDt([ 'id'=> $__mdl_cnt, 't'=>'enc' ]);
        }

    //------- Lets process send -------//

    if(!isN($__from_dt->id)){                        

        $__snd->cl->id = DB_CL_ID;
        $__snd->from_n = $__from_dt->nm;
        $__snd->us_as = $__eml_sbj;
        $__snd->us_to = $__to_dt->eml;
        $__snd->us_msj = $__eml_text;
        $__snd->sndr_e = $__from_dt->id;
        $__snd->sndr->id = 'sumr';
        $__snd->iscnv = 'ok';
        $__snd->cnv->eml = $__from_dt->id;
        $__snd->cnv->mdlcnt = $__mdlcnt_dt->id;
        $__snd->cnv->sbj = $__eml_sbj;
        
        if($__from_dt->tp->id == _CId('ID_SISEML_IMAP')){
            $__snd->sndr->srv = 'imap';
            $__imap_s = 'ok';
        }

        $_rsl_snd = $__snd->__SndMl([ 'imap'=>$__imap_s ]);

        if($_rsl_snd->sve->e == 'ok' && (!isN($_rsl_snd->sve->id) || !isN($__cnv_rplyto_dt->id))){ 
            $rsp['e'] = 'ok';
            $rsp['id'] = $_rsl_snd->sve->id;
            $rsp['tmp'] = $_rsl_snd->sve;
        }else{
            $rsp['w'] = $_rsl_snd;
        }

    }else{

        $rsp['w'][] = 'No from dt data';

    }
		
}

?>