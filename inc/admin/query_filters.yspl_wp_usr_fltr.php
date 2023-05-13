<?php
    include( YSPL_WP_USR_FLTR_DIR . '/inc/admin/query_get_paras.'. YSPL_WP_USR_FLTR_PREFIX .'.php' );
    //if( ! $filtr_sbmt ) return $query;
    // order by ascending descending
    if( $ordr_by == "1" ) $query->set( 'order' , 'ASC'  ); else $query->set( 'order' , 'DESC'  );
    // sort by multiple column names
    if( $usr_sort !== "" ){
        switch ($usr_sort ) { 
            case 'f-nm': // sort by first name
                $query->set( 'meta_key' , 'first_name'  );
                $query->set( 'orderby' , 'meta_value ID'  ); 
                break;
            case 'l-nm': // sort by first name
                $query->set( 'meta_key' , 'last_name'  );
                $query->set( 'orderby' , 'meta_value ID'  ); 
                break;
            case 'usr-id':
                $query->set( 'orderby' , 'ID'  ); 
                break;
            case 'usr-lgn':
                $query->set( 'orderby' , 'user_login'  ); 
                break;
            case 'dis-nm':
                $query->set( 'orderby' , 'display_name ID'  ); 
                break;
            case 'reg-dt':
                $query->set( 'orderby' , 'registered ID'  ); 
                break;
            case 'pst-cnt':
                $query->set( 'orderby' , 'post_count  ID'  ); 
                break;
        }
    }
    // prevent particular roles
    if( ! empty( $exlude_roles ) ){
        $query->set( 'role__not_in' , $exlude_roles  );
    }
    // prevent id to be displayed in the user listing - Number and "-" are allowed 
    if( $excl_ids && is_array( $excl_ids ) ) $query->set( 'exclude' , $excl_ids  );
    $date_args = array(
        "relation"  => "OR",
    );
    if( $one_date ){
        $date_args[] =  array('year' =>  date('Y', strtotime($one_date)) , 'month' => date('m', strtotime($one_date)), 'day' => date('d', strtotime($one_date)) );
        $query->set( 'date_query' ,  $date_args );
    }
    if( $cstm_dt ){
        $date_args[] =  array('after' =>  $cstm_dt , 'inclusive' => true )   ;
        $query->set( 'date_query' ,  $date_args );
    }
    if( ! empty( $multi_from_date ) && ! empty( $multi_to_date )   ){
        foreach( $multi_from_date as $index => $single_val ){
            if( ! empty( $multi_to_date[$index] ) &&   ! empty( $multi_from_date[$index] ) ){
                $multi_dates = array(
                    "before" => array('year' =>  date('Y', strtotime($multi_to_date[$index])) , 'month' => date('m', strtotime($multi_to_date[$index])), 'day' => date('d', strtotime($multi_to_date[$index])) ),
                    "after" =>  array('year' =>  date('Y', strtotime($multi_from_date[$index])) , 'month' => date('m', strtotime($multi_from_date[$index])), 'day' => date('d', strtotime($multi_from_date[$index])) ),
                    "inclusive" => true
                );         
                $date_args[] = $multi_dates; 
            }
        }
        if( ! empty( $date_args ) ){
            $query->set( 'date_query' ,  $date_args );
        }
    }
    if(  ! empty($meta_keys)  && ! empty($meta_vals) && ! empty( $meta_ops )   ){
        $meta_query_args = array(
            'relation' => ( $relation === "or" ) ? "OR" : "AND" 
        );
        $cnt_len = ( ! empty( $meta_ops ) && is_array( $meta_ops ) ) ? count( $meta_ops )   :  false; 
        if( $cnt_len !== false  ){
             for ($i=0; $i < $cnt_len  ; $i++) { 
                $meta_query_args[$i]['key']  = $meta_keys[$i];
                $meta_query_args[$i]['value'] = ( $meta_vals[$i] === 'empty' || empty(  trim($meta_vals[$i]) )  ) ? "" : $meta_vals[$i];
                $meta_query_args[$i]['compare']  = $meta_ops[$i];
                $meta_query_args[$i]['type']    = $meta_tp[$i];
             }
        }
        $query->set( 'meta_query' ,  $meta_query_args );
    }
    
    //debug date
    //echo  "<pre>" ; print_r( $date_args ) ; echo  "</pre>"; exit;
   // debug query 
   // echo  "<pre>" ; print_r( $query ) ; echo  "</pre>"; exit;
   $is_export  = ( isset( $_GET['exp-csv'] ) && $_GET['exp-csv'] === '1'  ) ? true : false;
   $queried_variables = $query->query_vars;
   $queried_variables['number'] = "-1";
   $user_query = new WP_User_Query( $queried_variables  );
   // debug export csv query 
   //echo  "<pre>" ; print_r( $user_query->request ) ; echo  "</pre>"; exit;
   $data_array = object_to_array($user_query->results);
   if( $is_export === true ){
        $column_nm  = array("User ID","User Login","User Email","User Nicename","Display Name","User Role", "Registration Date");
        $user_array = [];
        if( ! empty( $data_array )  ){
            $user_array[] = ( ! empty( $meta_keys ) ) ? array_merge($column_nm, $meta_keys ) : $column_nm;
            foreach( $data_array  as $single_user ){
                $su_data = $single_user["data"];
                $main_data =  array( 
                    $su_data['ID'], $su_data['user_login'],$su_data['user_email'], 
                    $su_data['user_nicename'], $su_data['display_name'],
                    $single_user["roles"][0],$su_data['user_registered']
                );
                if( ! empty ($meta_keys) ){
                    $user_meta_vals  = [];
                    foreach( $meta_keys as $single_key ){
                        $m_val = get_user_meta( $su_data['ID'], $single_key, true ); 
                        $m_val =  ( is_array($m_val)  ) ? serialize( $m_val ) : $m_val;
                        $user_meta_vals[] = $m_val;
                    }
                }
                $user_array[] = ( ! empty( $meta_keys ) ) ? array_merge( $main_data,$user_meta_vals ) : $main_data ;
            }
        }else{
            $user_array[] = $data_array;
        }
        array_to_csv_download($user_array);
        //echo  "<pre>" ; print_r( object_to_array($user_query->results) ) ; echo  "</pre>"; exit;
   }
   function object_to_array($data){
        $result = [];
        if (is_array($data) || is_object($data) || ! empty( $data ) ) {
            foreach ($data as $key => $value)
                $result[$key] = (is_array($value) || is_object($value)) ? object_to_array($value) : $value;
            return $result;
        }else{
            $result["empty_data"] = "empty_data";
        }
        return $data;
    }
   function array_to_csv_download($query_array = array(  array( "maybe an issue!" )  ), $filename = "export_users.csv", $delimiter=",") {
        // open raw memory as file so no temp files needed, you might run out of memory though
        $f = fopen('php://memory', 'w'); 
        // loop over the input array
        foreach ($query_array as $line) { 
            fputcsv($f, $line, $delimiter); 
        }
        // reset the file pointer to the start of the file
        fseek($f, 0);
        // tell the browser it's going to be a csv file
        header('Content-Type: text/csv');
        // tell the browser we want to save it instead of displaying it
        header('Content-Disposition: attachment; filename="'.$filename.'";');
        // make php send the generated csv lines to the browser
        fpassthru($f);
        fclose($f);
        exit;
    }
    return $query;