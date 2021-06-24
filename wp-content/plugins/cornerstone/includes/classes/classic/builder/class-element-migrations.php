<?php

/**
 * Access to Cornerstone data
 */
class Cornerstone_Element_Migrations  extends Cornerstone_Plugin_Component {

	public function migrate( $elements ) {

		if ( !is_array( $elements ) ) {
			return $elements;
		}
		
		$this->plugin->component( 'Element_Orchestrator' )->load_elements();

		foreach ($elements as $key => $element) {
			$is_classic = ! isset( $element['_type'] ) || ('section' === $element['_type'] && isset( $element['elements'] ) );
			$elements[$key] = $this->migrate_element( $is_classic ? $this->migrate_classic_element( $element ) : $element );
		}
		
		return $elements;
	}

	/**
	 * This will migrate an elements base values.
	 * We do not have logic at this time to migrate component values so component values should not change between versions
	 */
	public function apply_base_migrations( $element, $base_migrations, $base_values ) {

		if ( ! isset( $element['_m'] ) ) {
			$element['_m'] = [];
		}

		if ( ! isset( $element['_m']['e'] ) ) {
			$element['_m']['e'] = 0;
		}

		$start = $element['_m']['e'];
		$latest = $start;

		$value_stack = [];
		
		foreach ($base_migrations as $index => $migration ) {
			$latest = $index + 1;
			foreach($migration as $key => $value) {
				if ( !isset($value_stack[$key]) ) {
					$value_stack[$key] = [];
					$value_stack[$key][0] = $base_values[$key][0];
				}
				$value_stack[$key][$index + 1] = $value;
			}
		}

		if ($latest > $start) {
			$element['_m']['e'] = $latest;
			foreach ($value_stack as $key => $keyed_migrations) {
				$current_default = $keyed_migrations[$start];
				$new_default = $keyed_migrations[$latest];
				

				if ( ! isset( $element[$key] ) ) {
					$element[$key] = $current_default; // pre migration default value
				}

				if ( isset( $element[$key] ) && $element[$key] === $new_default ) {
					unset( $element[$key] );
				}
			}
		}
		
		return $element;
		
	}

	public function migrate_element( $element ) {
		
		$def = cs_get_element( $element['_type'] );
		
		$base_migrations = $def->get_migrations();
		if ( count( $base_migrations ) > 0 ) {
			$element = $this->apply_base_migrations( $element, $base_migrations, $def->get_base_values() );
		}
		
		if ( isset( $element['_modules'] ) ) {
			foreach ( $element['_modules'] as $index => $child ) {
				$element['_modules'][$index] = $this->migrate_element( $child );
			}
		}

		return $element;
	}

	public function migrate_classic_element( $element ) {

		// Ensure '_type' is set
		if ( isset( $element['elType'] ) ) {
			$element['_type'] = $element['elType'];
			unset($element['elType']);
		}

		if ( !isset( $element['_type'] ) ) {
			$element['_type'] = 'classic:undefined';
		}

		if ( false === strpos($element['_type'], 'classic:' ) ) {
			$element['_type'] = 'classic:' . $element['_type'];
		}
		
		if ( isset( $element['title'] ) && ! isset( $element['_label'] ) ) {
			$element['_label'] = $element['title'];
			unset( $element['title'] );
		}
		
		// Assign '_type' per element for children, and remove parent 'childType'
		if ( isset( $element['childType'] ) ) {
			if ( $element['childType'] != 'any' && isset( $element['elements'] ) ) {
				foreach ( $element['elements'] as $index => $child ) {
					$element['elements'][$index]['_type'] = $element['childType'];
				}
			}
			unset( $element['childType'] );
		}

		// Some quick inline layout migrations instead of checking the version for every individual element
		if ( 'classic:row' == $element['_type'] && isset( $element['columnLayout'] ) ) {
			unset($element['columnLayout']);
		}

		if ( 'classic:column' == $element['_type'] && isset( $element['active'] ) ) {
			$element['_active'] = $element['active'];
			unset($element['active']);
		}

		if ( isset( $element['custom_id'] ) ) {
			$element['id'] = $element['custom_id'];
			unset($element['custom_id']);
		}

		if ( isset( $element['border'] ) ) {
			if ( !isset( $element['border_width'] ) ) {
				$element['border_width'] = $element['border'];
			}
			unset( $element['border'] );
		}

		// Remap old visibility
		if ( isset( $element['visibility'] ) && is_array( $element['visibility'] ) ) {
			foreach ( $element['visibility'] as $key => $value) {
				$element['visibility'][$key] = str_replace( 'x-hide-', '', $value );
			}
		}

		// Remap old text align
		if ( isset( $element['text_align'] ) ) {
			$ta_migrate = array( 'left-text' => 'l', 'center-text' => 'c', 'right-text' => 'r', 'justify-text' => 'j' );
			if ( isset( $ta_migrate[ $element['text_align'] ] ) ) {
				$element['text_align'] = $ta_migrate[ $element['text_align'] ];
			}
		}

		if ( isset( $element['elements'] ) ) {
      $element['_modules'] = array();
			foreach ( $element['elements'] as $index => $child ) {
				$element['_modules'][$index] = $this->migrate_classic_element( $child );
			}
      unset($element['elements']);
		}

		return $element;

	}

}
