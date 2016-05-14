<?php

function ab_sort_pre_user_query($query){
	if(isset($query->query_vars['ap_query']) && $query->query_vars['ap_query'] == 'sort_points'){

		global $wpdb;
		$query->query_orderby = 'ORDER BY CAST('.$wpdb->usermeta.'.meta_value as DECIMAL) DESC';
	}
}
add_action( 'pre_user_query', 'ab_sort_pre_user_query' );


