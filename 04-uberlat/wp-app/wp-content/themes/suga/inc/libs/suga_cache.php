<?php
if (!class_exists('suga_cache')) {
    class suga_cache {
        
        static $cache_name_format = '{group}-{ID}';
        
        static function suga_get_cache_name( $cache_key, $cache_group = '' ) {

    		$cache_group = self::suga_sanitize_group_name( $cache_group );
    
    		$replacement = array(
    			'{ID}'    => $cache_key,
    			'{group}' => $cache_group,
    		);
    
    		return str_replace( array_keys( $replacement ), array_values( $replacement ), self::$cache_name_format );
    	}
        
        static function suga_get_cache( $cache_key, $cache_group = 'default' ) {

    		$transient_name = self::suga_get_cache_name( $cache_key, $cache_group );
    
    		if ( $group_cached = get_transient( $transient_name ) ) {
    			if ( isset( $group_cached[ $cache_group ] ) ) {
    				return $group_cached[ $cache_group ];
    			}
    		}
    
    		return FALSE;
    	}
        
        static function suga_set_cache( $cache_key, $data2cache, $cache_group = 'default', $expiration = NULL ) {
    
    		$transient_name = self::suga_get_cache_name( $cache_key, $cache_group );
    
    		if ( ! is_int( $expiration ) || ! $expiration ) {
    			$expiration = apply_filters( 'bk-playlist/cache-time', HOUR_IN_SECONDS * 6 );
    		}
    
    		$current_data = get_transient( $transient_name );
    		if ( ! $current_data ) {
    			$current_data = array();
    		}
    		$current_data = (array) $current_data;
    
    		$new_data                 = &$current_data;
    		$new_data[ $cache_group ] = $data2cache;
    
    		return set_transient( $transient_name, $new_data, $expiration );
    	}
        
        static function suga_sanitize_group_name( $cache_key, $cache_group = '' ) {

    		if ( ! empty( $cache_group ) || ! is_string( $cache_group ) ) {
    			return $cache_group;
    		}
    
    		return FALSE;
    	}
        
    }
}