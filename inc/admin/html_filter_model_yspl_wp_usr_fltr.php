<?php 
    include( YSPL_WP_USR_FLTR_DIR . '/inc/admin/query_get_paras.'. YSPL_WP_USR_FLTR_PREFIX .'.php' );
    function yspl_wp_usr_filter( $frm_date, $to_date ){ ob_start(); if( empty(  trim(  $frm_date  ) ) ||  empty(  trim(   $to_date ) ) ) return ob_get_clean(); ?>
        <div class="pad-top-10 date_wrapper" > 
            <input type="date" name="mlt-f-dt[]" <?php echo ( $frm_date ) ? " value='$frm_date'" : ""; ?>  >
            <span><?php _e("to","wp-users-filter"); ?></span>
            <input type="date" name="mlt-t-dt[]" <?php echo ( $to_date ) ? " value='$to_date'" : ""; ?>  >
            <button type="button" class="button remov_date" > X </button>
        </div>
    <?php return ob_get_clean(); }
    function meta_multiple_vals( $m_key, $m_val, $m_op, $m_type ){ 
            ob_start();
            //echo "m_key : " . $m_key . "m_val : " . $m_val . "m_op  :" . $m_op ;
            if(  empty( trim(  $m_key ) )  ||  empty( trim(  $m_op ) ) ) return ob_get_clean();
            $compatible_compares = array( '=', "!=" , 'IN', 'BETWEEN', 'LIKE', 'REGEXP', 'RLIKE', '>', '>=', '<', '<=', 'NOT EXISTS', 'NOT REGEXP' );  ?>
            <div class="pad-top-10 meta_wrapper" > 
                <input type="text" name="mta-ky[]" value="<?php echo $m_key; ?>" placeholder="Add meta key like: monthly_salary" >
                <label> <?php _e("Select operator","wp-users-filter"); ?> : </label>
                <select name="mta-op[]" >
                    <?php  
                        foreach( $compatible_compares as $single_op )
                            echo "<option value='$single_op'". ( $single_op === $m_op  ?  " selected " : "" )  . " >$single_op</option>";
                    ?>
                </select>
                <label> <?php _e("Type","wp-users-filter"); ?> : </label>
                <select name="mta-tp[]" >
                    <?php  
                        $compatible_type = array( "CHAR","NUMERIC", "BINARY", "DATE", "DATETIME", "DECIMAL", "SIGNED", "UNSIGNED", "TIME" );
                        foreach( $compatible_type as $single_tp )
                            echo "<option value='$single_tp'". ( $single_tp ==  $m_type  ?  " selected " : "" )  . " >$single_tp</option>";
                    ?>
                </select>
                <input type="text" name="mta-vl[]" value="<?php echo  empty (trim(  $m_val )) ? "empty" : $m_val; ?>" >
                <button type="button" class="button remov_meta" > X </button>
            </div>
    <?php return ob_get_clean(); }
?>
<div class="alignleft actions">
    <button id="yspl_wp_usr_fltr_pop_up_btn" class="button yswp__usr_fltr_animated-btn" type="button"><?php _e("Filter Users","wp-users-filter"); ?>
        <span class="button-primary abc_snake" > </span>
        <span class="button-primary abc_snake" > </span>
        <span class="button-primary abc_snake"> </span>
        <span class="button-primary abc_snake"> </span>
    </button>
</div>
<!-- Trigger/Open The Modal -->

<!-- The Modal -->
<div id="yspl_wp_usr_fltr_model_options" class="yspl_wp_usr_fltr_modal" >

  <!-- Modal content -->
  <div class="yspl_wp_usr_fltr_modal-content">
        <div class="close-popup-btn" >
            <span class="yspl_wp_usr_fltr_model_close">&times;</span>
        </div>
    <div>
        <div class="yspl_wp_usr_fltr-tabs">
            <button type="button" class="tablinks set-active" data-id="yspl_wp_usr_fltr-general-settings" ><?php _e("General","wp-users-filter"); ?></button>
            <button type="button" class="tablinks" data-id="yspl_wp_usr_fltr-date-filter-settings"><?php _e("Date Filters","wp-users-filter"); ?></button>
            <button type="button" class="tablinks" data-id="yspl_wp_usr_fltr-advanced-settings"><?php _e("Advanced","wp-users-filter"); ?></button>
            <button type="button" class="tablinks" data-id="yspl_wp_usr_fltr-export-settings"><?php _e("Export","wp-users-filter"); ?></button>
        </div>
        <!-- tab content of genral setting -->
        <div id="yspl_wp_usr_fltr-general-settings" class="yspl_wp_usr_fltr-tabcontent yspl_us_general" style="display:block;" >
            <div class="stng-title"><h2><?php _e("General Filters","wp-users-filter"); ?></h2></div>
            <div class="parent-col" >
                <div class="child-col">
                    <div class="form-field pad-top-40" >
                        <label><b><?php _e("Sort By :","wp-users-filter") ?></b></label>
                        <select name="usr_srt">
                            <option value="" <?php echo ($usr_sort === "" ) ? " selected" : ""; ?> ><?php _e("Select option...","wp-users-filter"); ?></option>
                            <option value="f-nm" <?php echo ($usr_sort === "f-nm" ) ? " selected" : ""; ?> ><?php _e("Firstname","wp-users-filter"); ?></option>
                            <option value="l-nm" <?php echo ($usr_sort === "l-nm" ) ? " selected" : ""; ?>><?php _e("Lastname","wp-users-filter"); ?></option>
                            <option value="usr-id" <?php echo ($usr_sort === "usr-id" ) ? " selected" : ""; ?>><?php _e("User ID","wp-users-filter"); ?></option>
                            <option value="usr-lgn" <?php echo ($usr_sort === "usr-lgn" ) ? " selected" : ""; ?>><?php _e("User Login","wp-users-filter"); ?></option>
                            <option value="dis-nm" <?php echo ($usr_sort === "dis-nm" ) ? " selected" : ""; ?>><?php _e("Display Name","wp-users-filter"); ?></option>
                            <option value="reg-dt" <?php echo ($usr_sort === "reg-dt" ) ? " selected" : ""; ?>><?php _e("Registered Date","wp-users-filter"); ?></option>
                            <option value="pst-cnt" <?php echo ($usr_sort === "pst-cnt" ) ? " selected" : ""; ?>><?php _e("Post Count","wp-users-filter"); ?></option>
                        </select>
                    </div>
                    <div class="form-field pad-top-40 ordr-by-fields" >
                        <label><b><?php _e("Order By:","wp-users-filter"); ?></b></label> 
                        <div class="form-order" >
                            <label class="fancy-radio" >
                                <input type="radio" name="ordr-by" value="1" <?php echo ( $ordr_by ===  "1" || $ordr_by == "" ) ? " checked" : ""; ?> ><?php _e("ASCENDING","wp-users-filter"); echo "    "; ?>
                                <span class="fancy-select button-primary" ></span>
                            </label> <br> <br>
                            <label class="fancy-radio">
                                <input type="radio" name="ordr-by" value="0" <?php echo ( $ordr_by === "0"  ) ? " checked" : ""; ?> ><?php _e("DESCENDING","wp-users-filter"); ?> 
                                <span class="fancy-select button-primary" ></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-field pad-top-40" >
                        <label><b><?php _e("Exclude Users Id/s:","wp-users-filter"); ?></b></label>
                        <div class="tooltip"> ?
                            <span class="tooltiptext"><?php _e('Use "-" between numbers to exclude multiple ids.',"wp-users-filter"); ?></span>
                        </div>
                        <div class="pad-top-10" >
                            <input value="<?php echo ( $excl_ids && is_array( $excl_ids ) ) ? implode('-',$excl_ids ) : ""; ?>" type="text" pattern="^[0-9\-]+$" name="excl-ids" placeholder='Only "numbers" and "-" are allowed.' >
                        </div>
                    </div>
                </div>
                <div class="child-col between-two-dates">
                    <div class="form-field  pad-top-40" >
                        <label><b><?php _e("Filter users by date : ","wp-users-filter") ?></b></label>
                        <div class="pad-top-10">
                            <input type="date" name="one-dt" <?php echo ( $one_date ) ? " value='$one_date'" : ""; ?>>
                            <button type="button" class="button rst_single_dt" > <?php _e("Reset","wp-users-filter"); ?> </button>
                        </div>
                    </div>
                    <div class="form-field  pad-top-40" >
                        <label><b><?php _e('Write something like  "12 Hours ago" : ',"wp-users-filter") ?></b></label>
                        <div class="tooltip"> ?
                            <span class="tooltiptext"><?php _e("Find registered users with <br/>(E.g. 12 hours ago, <br/> 1 month ago): ","wp-users-filter"); ?></span>
                        </div>
                        <div class="pad-top-10">
                            <input placeholder="E.g. 12 Hours ago" type="text" name="cstm-dt" <?php echo ( $cstm_dt ) ? " value='$cstm_dt'" : ""; ?>>
                        </div>
                    </div>
                </div>
                <div class="child-col">
                    <div class="form-field pad-top-40" >
                        <label><b><?php _e("Exclude roles:","wp-users-filter") ?></b></label>
                        <div class="exclude-roles pad-top-10" >
                            <?php foreach( $roles as $role_slug => $role_name ): ?>
                                <label class="fancy-check" >
                                    <input type="checkbox" name="rl-excld[]" value="<?php echo $role_slug; ?>" <?php echo ( in_array( $role_slug, $exlude_roles ) ) ? " checked":""; ?> > <?php echo $role_name; ?>
                                    <span class="fancy-checkmark button"></span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- tab content of genral setting ends -->
        <!-- tab content of date setting starts -->
        <div id="yspl_wp_usr_fltr-date-filter-settings" class="yspl_wp_usr_fltr-tabcontent yspl_us_dates" style="display:none;">
          <div class="txt-center" ><h3><?php _e("MULTIPLE DATE FILTER","wp-users-filter"); ?></h3></div>
            <div class="form-field pad-top-40" >
                <label><b><?php _e("Filter users between two dates:","wp-users-filter") ?></b></label>
                <div class="tooltip"> ?
                    <span class="tooltiptext"><?php _e("This filter will filter users based on registration date.","wp-users-filter"); ?></span>
                </div>
                <button class="click_to_append button button-primary add_multi_date" type="button" id="yspl_wp_usr_fltr_add_multi_date" ><?php _e("Add date","wp-users-filter"); ?></button>
                <table  class="meta_filter_table yspl_wp_user_fltr_meta_append_content"  >
                    <tbody >
                        <tr>
                            <th>From Date</th>
                            <th>To Date</th>
                        </tr>
                    </tbody>
                </table>
                <template id="yspl_wp_user_fltr_dt_copy_content" >
                    <div class="pad-top-10 date_wrapper" > 
                        <input type="date" name="mlt-f-dt[]"  >
                            <span><?php _e("to","wp-users-filter") ?></span>
                            <input type="date" name="mlt-t-dt[]" >
                        <button type="button" class="button remov_date" > X </button>
                    </div>
                </template>
                <div id="yspl_wp_user_fltr_dt_append_content" class="pad-top-10">
                    <?php if( ! empty( $multi_from_date ) && ! empty( $multi_to_date )   ){
                        foreach( $multi_from_date as $index => $single_val )
                            echo yspl_wp_usr_filter( $multi_from_date[$index], $multi_to_date[$index] );
                    } ?>
                </div>
            </div>
        </div>
        <!-- tab content of date setting ends -->
        <!-- tab content of advanced setting starts -->
        <div id="yspl_wp_usr_fltr-advanced-settings" class="yspl_wp_usr_fltr-tabcontent yspl_us_advance" style="display:none;">
            <div id="LETS-make-POST-Form" class="stng-title"><h2><?php _e("Advanced Filters","wp-users-filter") ?></h2></div>
            <div>
                <div>
                    <div class="txt-center" ><h3><?php _e("META FILTER","wp-users-filter"); ?> </h3></div>
                    <div class="form-field pad-top-40" >
                        <label><b><?php _e("Filter users using meta key/value:","wp-users-filter") ?></b></label>
                        <div class="tooltip"> ?
                            <span class="tooltiptext"><?php _e("1) Add meta key.  2) Select Operator.  3) Enter value. ","wp-users-filter"); ?></span>
                        </div>
                        <button class="click_to_append button button-primary add_multi_meta_query" type="button" id="yspl_wp_usr_fltr_add_meta_query" ><?php _e("ADD META FILTER","wp-users-filter"); ?></button>
                        <label class="relation"> Relation: </label>
                        <select name="rltn">
                            <option value="nd" <?php echo ( $relation == 'nd' ) ? " selected" : ""; ?> >AND</option>
                            <option value="or" <?php echo ( $relation == 'or' ) ? " selected" : ""; ?> >OR</option>
                        </select>
                        <template id="yspl_wp_user_fltr_meta_copy_content" >
                            <tr> 
                                <td>
                                    <input type="text" name="mta-ky[]" placeholder="Add meta key like: monthly_salary" >
                                </td>
                                <td>
                                    <select name="mta-op[]" >
                                        <?php  
                                            foreach( $compatible_compares as $single_op )
                                                echo "<option value='$single_op' >$single_op</option>";
                                        ?>
                                    </select>
                                </td>
                                <td>
                                    <select name="mta-tp[]" >
                                        <?php  
                                            $compatible_type = array( "CHAR","NUMERIC", "BINARY", "DATE", "DATETIME", "DECIMAL", "SIGNED", "UNSIGNED", "TIME" );
                                            foreach( $compatible_type as $single_tp )
                                                echo "<option value='$single_tp'". ( $single_tp === $m_type  ?  " selected " : "" )  . " >$single_tp</option>";
                                        ?>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" name="mta-vl[]" >
                                    <button type="button" class="button remov_meta" > X </button>
                                </td>
                            </tr>
                        </template>
                        <div  class="pad-top-10 ">
                        <table class="yspl_table_append meta_filter_table yspl_wp_user_fltr_meta_append_content"  >
                            <tbody id="advnce_append_content" >
                                <tr>
                                    <th>Meta key</th>
                                    <th>Operator</th>
                                    <th>Type</th>
                                    <th>Value</th>
                                </tr>
                            </tbody>
                        </table>
                            <?php if( $meta_keys ) {
                                //echo "<pre>";print_r( $meta_keys );echo "</pre>";
                                foreach($meta_keys as $index => $single_val )
                                    echo meta_multiple_vals( $meta_keys[$index], $meta_vals[$index], $meta_ops[$index], $meta_tp[$index] ); 
                            } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- tab content of advanced setting ends-->
        <!-- tab content of export setting starts -->
        <div id="yspl_wp_usr_fltr-export-settings" class="yspl_wp_usr_fltr-tabcontent yspl_us_export" style="display:none;">
           <div class="txt-center export-btn" >
                <p class="big_p_bold"><b><?php _e("The export file will include following things.","wp-users-filter"); ?></b></p>
                <p class="big_p" >
                    <?php _e("User ID, User Login, User Email, User Nicename, Display Name, User Role.","wp-users-filter"); ?>  <br>
                        <mark><?php _e("Note: If filtered with meta key/s, meta value/s will include.", "wp-users-filter"); ?> </mark>
                    </p>
                <br>
               <button  id="yswp_EXP-csv-BTN" class="button glow-on-hover" name="exp-csv"  type="button"><?php _e("CLICK HERE TO EXPORT CSV &#8681;","wp-users-filter"); ?></button>
           </div>
        </div>
        <!-- tab content of export setting ends -->
        <div class="pop-up-footer" >
            <div style="display: inline-block;">
                <p> Made with <span class="heart"></span> By <a target="_blank" style="color: #5dacec;" href="https://www.yudiz.com/">Yudiz</a>   </p>
                <p> Need more plugins customiation? <a href="https://www.yudiz.com/get-in-touch/" target="_blank" style="color: #5dacec;" >Contact our team</a>  &#128104;&#8205;&#128187;</p>
            </div>
            <div class="txt-right yspl-sbmit-actions" >
                <a href="<?php global $pagenow; echo $pagenow; ?>" class="button button-primary" ><?php _e("Clear Filters","wp-users-filter"); ?></a>
                <button class="button button-primary" type="submit"     name="fltr-sbmt" value="1"><?php _e("Filter Users","wp-users-filter"); ?></button>
            </div>
            <div id="pop-pop"></div>
        </div>
        <!-- tab content of advanced setting ends -->
    </div>
  </div>

</div>