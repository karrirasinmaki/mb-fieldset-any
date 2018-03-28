<?php

if ( class_exists( 'RWMB_Field' ) ) :

/**
 * Meta Box plugin extension.
 *
 * New field type "fieldset_any".
 *
 * Usage (example: multiple key->value pairs):

 'fields' => array(
   array(
     'id' => '',
     'type' => 'fieldset_any',
     'clone' => true,
     'options' => array(
       array(
	 'id' => 'key',
	 'name' => __('Key'),
	 'type' => 'text',
       ),
       array(
	 'id' => 'value',
	 'name' => __('Value'),
	 'type' => 'text',
       ),
     )
   ),
 )

 *
 * @package Meta Box
 */

/**
 * Fieldset text class.
 */
class RWMB_Fieldset_Any_Field extends RWMB_Field {

	/**
	 * Get field HTML.
	 *
	 * @param mixed $meta  Meta value.
	 * @param array $field Field parameters.
	 *
	 * @return string
	 */
	public static function html( $meta, $field ) {
		$html = array();
		$tpl  = '<label>%s %s</label>';

		foreach ( $field['options'] as $child_field ) {
			$key = $child_field['id'];
			$value                       = isset( $meta[ $key ] ) ? $meta[ $key ] : '';
			$child_field				 = self::call( $child_field, 'normalize' );
			$child_field['attributes']['id']	= false;
			$child_field['attributes']['name']	= $field['field_name'] . "[{$key}]";
			$field_html					 = self::call( $child_field, 'html', $value );
			//$field_html = self::filter( 'html', $field_html, $child_field, $value );
			//$field_html = self::show( $child_field, $value ? true : false );
			$html[]                      = sprintf( $tpl, $child_field['name'], $field_html );
		}

		$out = '<fieldset><legend>' . $field['desc'] . '</legend>' . implode( ' ', $html ) . '</fieldset>';

		return $out;
	}

	/**
	 * Do not show field description.
	 *
	 * @param array $field Field parameters.
	 * @return string
	 */
	public static function input_description( $field ) {
		return '';
	}

	/**
	 * Do not show field description.
	 *
	 * @param array $field Field parameters.
	 * @return string
	 */
	public static function label_description( $field ) {
		return '';
	}

	/**
	 * Normalize parameters for field.
	 *
	 * @param array $field Field parameters.
	 *
	 * @return array
	 */
	public static function normalize( $field ) {
		$field                       = parent::normalize( $field );
		$field['multiple']           = false;
		$field['attributes']['id']   = false;
		$field['attributes']['type'] = 'text';
		return $field;
	}

	/**
	 * Format value for the helper functions.
	 *
	 * @param array        $field   Field parameters.
	 * @param string|array $value   The field meta value.
	 * @param array        $args    Additional arguments. Rarely used. See specific fields for details.
	 * @param int|null     $post_id Post ID. null for current post. Optional.
	 *
	 * @return string
	 */
	public static function format_value( $field, $value, $args=array(), $post_id=null ) {
		$output = '<table><thead><tr>';
		foreach ( $field['options'] as $label ) {
			$output .= "<th>$label</th>";
		}
		$output .= '<tr>';

		if ( ! $field['clone'] ) {
			$output .= self::format_single_value( $field, $value );
		} else {
			foreach ( $value as $subvalue ) {
				$output .= self::format_single_value( $field, $subvalue );
			}
		}
		$output .= '</tbody></table>';
		return $output;
	}

	/**
	 * Format a single value for the helper functions. Sub-fields should overwrite this method if necessary.
	 *
	 * @param array    $field   Field parameters.
	 * @param string   $value   The value.
	 * @param array    $args    Additional arguments. Rarely used. See specific fields for details.
	 * @param int|null $post_id Post ID. null for current post. Optional.
	 *
	 * @return string
	 */
	public static function format_single_value( $field, $value, $args=array(), $post_id=null ) {
		$output = '<tr>';
		foreach ( $value as $subvalue ) {
			$output .= "<td>$subvalue</td>";
		}
		$output .= '</tr>';
		return $output;
	}
}

endif;

