
<div id="sort1" class="DshTraMntr">
    <div class="cols col1">
        <div id="c1" class="rows bxt1 __col_1" >
            <div class="_cols">
                
                <div class="ads">
                    <?php echo SlDt([ 'id'=>'grph_fi', 'va'=>'', 'rq'=>'no', 'ph'=>'Fecha Inicial', 'lmt'=>'no' ]); ?> 
                    <?php echo SlDt([ 'id'=>'grph_ff', 'va'=>'', 'rq'=>'no', 'ph'=>'Fecha Final', 'lmt'=>'no' ]); ?>     
                    <button class="flt_grph"></button>    
                </div>
                <div id="grph1"></div>
            </div>
        </div>
        <div id="c4" class="rows bxt1">
            <div id="grph_us" class="_cols" style="width:100%;height:400px;"></div>  
        </div>
        <div id="c2" class="rows bxt1">
           
        </div>
        <div id="c3" class="rows bxt1 __col_2">
            <div id="grph2" class="_cols"></div>
            <div id="grph3" class="_cols"></div>
            <div id="grph_tags" class="_cols"></div>
        </div>
    </div>
    <div class="cols col2">
        <div id="c4" class="rows bxt2 __col_2">
            <div id="grph4" class="_cols"></div>
            <div id="grph5" class="_cols"></div>
        </div>   
        <div id="c5" class="rows __col_1">
            <div class="_cols">
                <h2>Tickets Urgentes</h2>
                <ul id="lstd_mdlcnt"></ul>
            </div>
        </div> 
        <div id="c6" class="rows __col_1">
            <div class="_cols">
                <h2>Asignaciones</h2>
                <ul id="lst_rspus"></ul>
            </div>
        </div> 
        <div id="c7" class="rows __col_1">
            <div id="grph_colus" class="_cols"></div>
        </div>
    </div>
</div>
<style>
    .ads .___txar{ display:inline-block; }
    .flt_grph{display: inline-block;vertical-align: top;background-color: #eaebed;border: 0;width: 25px;height: 25px;margin-top: 5px;margin-left: 7px;border-radius: 12px;background-size: 56%;background-repeat: no-repeat;background-position: center;background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>filtro.svg);}    
    .flt_grph:hover{ background-color: #e0e0e0; }
</style>