<?php

// Exit if accessed directly
if(!defined( 'ABSPATH' )) exit;

/**
 * Utils
 * @author No3x
 * @since 1.6.0
 */
class WPML_Utils {
	/**
	 * Ensure value is subset of given set
	 * @since 1.6.0
	 * @param $value expected value
	 * @param array $allowed_values allowed values
	 * @param string $default_value default value ()
	 * @return mixed
	 */
	public static function sanitize_expected_value( $value, $allowed_values, $default_value = null ) {
		$allowed_values = (is_array( $allowed_values) ) ? $allowed_values : array( $allowed_values );
		if($value && in_array( $value, $allowed_values))
			return $value;
		if(null != $default_value)
			return $default_value;
		return false;
	}

    /**
     * Multilevel array_search
     * @since 1.3
     * @see array_search()
     */
    public static function recursive_array_search( $needle, $haystack ) {
        foreach( $haystack as $key => $value ) {
            $current_key = $key;
            if($needle === $value OR ( is_array($value) && self::recursive_array_search( $needle, $value ) !== false ) ) {
                return $current_key;
            }
        }
        return false;
    }

    /**
     * Determines appropirate fa icon for a file
     * @sine 1.3
     * @param string $path
     * @return Ambigous <boolean, string> Returns the most suitable icon or false if not possible.
     */
    public static function determine_fa_icon( $path ) {
        $supported = array(
            'archive' => array (
                'application/zip',
                'application/x-rar-compressed',
                'application/x-rar',
                'application/x-gzip',
                'application/x-msdownload',
                'application/x-msdownload',
                'application/vnd.ms-cab-compressed'
            ),
            'audio',
            'code' => array(
                'text/x-c',
                'text/x-c++'
            ),
            'excel' => array( 'application/vnd.ms-excel'
            ),
            'image', 'text', 'movie', 'pdf', 'photo', 'picture',
            'powerpoint' => array(
                'application/vnd.ms-powerpoint'
            ), 'sound', 'video', 'word' => array(
                'application/msword'
            ), 'zip'
        );

        $mime = mime_content_type( $path );
        $mime_parts = explode( '/', $mime );
        $attribute = $mime_parts[0];
        $type = $mime_parts[1];

        $fa_icon = false;
        if( ($key = self::recursive_array_search( $mime, $supported ) ) !== FALSE ) {
            // search for specific mime first
            $fa_icon = $key;
        } elseif( in_array( $attribute, $supported ) ) {
            // generic file icons
            $fa_icon = $attribute;
        }

        if( $fa_icon === FALSE ) {
            return '<i class="fa fa-file-o"></i>';
        } else {
            return '<i class="fa fa-file-' . $fa_icon . '-o"></i>';
        }
    }

    /**
     * Find appropriate fa icon from file path
     * @since 1.3
     * @param string $attachment_path
     * @return string
     */
    public static function generate_attachment_icon( $path ) {
        return self::determine_fa_icon( $path );
    }
}
