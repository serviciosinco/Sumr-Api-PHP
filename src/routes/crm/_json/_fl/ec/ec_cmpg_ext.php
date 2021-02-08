<?php

	if(ChckSESS_superadm() || SISUS_ID != 612){

		$_eccmpg = $_POST['eccmpg'];

		$_ls_eccmpg = explode(',', $_eccmpg);

		if(!isN($_ls_eccmpg)){

			foreach($_ls_eccmpg as $_ls_k=>$_ls_v){

				$__cmpg_dt = GtEcCmpgDt([ 't'=>'enc', 'id'=>$_ls_v, 'q_tot'=>'ok', 'q_btch'=>'ok' ]);

				$ldd = (($__cmpg_dt->btch->l*100) / $__cmpg_dt->tot->lds);
				$op = (($__cmpg_dt->_tot_op*100) / $__cmpg_dt->_tot_snd);
				$err = (($__cmpg_dt->_tot_err*100) / $__cmpg_dt->_tot_snd);
				$trck = (($__cmpg_dt->_tot_trck*100) / $__cmpg_dt->_tot_snd);
				$rstn = ((($__cmpg_dt->_tot_snd-($__cmpg_dt->_tot_op+$__cmpg_dt->_tot_err)) * 100) / $__cmpg_dt->_tot_snd);

				$_id = $__cmpg_dt->enc;

				$rsp['l'][$_id]['id'] = $_id;

				$rsp['l'][$_id]['btch']['l']['v'] = $__cmpg_dt->btch->l;
				$rsp['l'][$_id]['btch']['l']['p'] = round($ldd)."%";
				$rsp['l'][$_id]['btch']['snd']['v'] = $__cmpg_dt->btch->snd;
				$rsp['l'][$_id]['btch']['p']['v'] = $__cmpg_dt->btch->p;
				$rsp['l'][$_id]['tot']['op']['v'] = $__cmpg_dt->_tot_op;
				$rsp['l'][$_id]['tot']['op']['p'] = round($op)."%";
				$rsp['l'][$_id]['tot']['trck']['v'] = $__cmpg_dt->_tot_trck;
				$rsp['l'][$_id]['tot']['trck']['p'] = round($trck)."%";
				$rsp['l'][$_id]['tot']['err']['v'] = $__cmpg_dt->_tot_err;
				$rsp['l'][$_id]['tot']['err']['p'] = round($err)."%";

			}

		}

	}

?>