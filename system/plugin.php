<?
/*************************************************************************************************************************
*
* Free Reprintables Article Directory System
* Copyright (C) 2014  Glenn Prialde

* This program is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.

* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.

* You should have received a copy of the GNU General Public License
* along with this program.  If not, see <http://www.gnu.org/licenses/>.
* 
* Author: Glenn Prialde
* Contact: admin@freecontentarticles.com
* Mobile: +639473473247	
*
* Website: http://freereprintables.com 
* Website: http://www.freecontentarticles.com 
*
*************************************************************************************************************************/
	
/**
 *
 * Forked from wordpress/wp-includes/plugin.php
 *
 */
	
function add_filter($tag, $function_to_add, $priority = 20, $accepted_args = 1) {
	$idx = _afr_filter_build_unique_id($tag, $function_to_add, $priority);
	$GLOBALS['afr_filter'][$tag][$priority][$idx] = array('function' => $function_to_add, 'accepted_args' => $accepted_args);
	unset( $GLOBALS['merged_filters'][ $tag ] );
	return true;
}

function has_filter($tag, $function_to_check = false) {
	$has = !empty($GLOBALS['afr_filter'][$tag]);
	if ( false === $function_to_check || false == $has )
		return $has;

	if ( !$idx = _afr_filter_build_unique_id($tag, $function_to_check, false) )
		return false;

	foreach ( (array) array_keys($GLOBALS['afr_filter'][$tag]) as $priority ) {
		if ( isset($GLOBALS['afr_filter'][$tag][$priority][$idx]) )
			return $priority;
	}

	return false;
}

function apply_filters($tag, $value) {
	$args = array();

	// Do 'all' actions first
	if ( isset($GLOBALS['afr_filter']['all']) ) {
		$GLOBALS['afr_current_filter'][] = $tag;
		$args = func_get_args();
		_afr_call_all_hook($args);
	}

	if ( !isset($GLOBALS['afr_filter'][$tag]) ) {
		if ( isset($GLOBALS['afr_filter']['all']) )
			array_pop($GLOBALS['afr_current_filter']);
		return $value;
	}

	if ( !isset($GLOBALS['afr_filter']['all']) )
		$GLOBALS['afr_current_filter'][] = $tag;

	// Sort
	if ( !isset( $GLOBALS['merged_filters'][ $tag ] ) ) {
		ksort($GLOBALS['afr_filter'][$tag]);
		$GLOBALS['merged_filters'][ $tag ] = true;
	}

	reset( $GLOBALS['afr_filter'][ $tag ] );

	if ( empty($args) )
		$args = func_get_args();

	do {
		foreach( (array) current($GLOBALS['afr_filter'][$tag]) as $the_ )
			if ( !is_null($the_['function']) ){
				$args[1] = $value;
				$value = call_user_func_array($the_['function'], array_slice($args, 1, (int) $the_['accepted_args']));
			}

	} while ( next($GLOBALS['afr_filter'][$tag]) !== false );

	array_pop( $GLOBALS['afr_current_filter'] );

	return $value;
}

function apply_filters_ref_array($tag, $args) {
	// Do 'all' actions first
	if ( isset($GLOBALS['afr_filter']['all']) ) {
		$GLOBALS['afr_current_filter'][] = $tag;
		$all_args = func_get_args();
		_afr_call_all_hook($all_args);
	}

	if ( !isset($GLOBALS['afr_filter'][$tag]) ) {
		if ( isset($GLOBALS['afr_filter']['all']) )
			array_pop($GLOBALS['afr_current_filter']);
		return $args[0];
	}

	if ( !isset($GLOBALS['afr_filter']['all']) )
		$GLOBALS['afr_current_filter'][] = $tag;

	// Sort
	if ( !isset( $GLOBALS['merged_filters'][ $tag ] ) ) {
		ksort($GLOBALS['afr_filter'][$tag]);
		$GLOBALS['merged_filters'][ $tag ] = true;
	}

	reset( $GLOBALS['afr_filter'][ $tag ] );

	do {
		foreach( (array) current($GLOBALS['afr_filter'][$tag]) as $the_ )
			if ( !is_null($the_['function']) )
				$args[0] = call_user_func_array($the_['function'], array_slice($args, 0, (int) $the_['accepted_args']));

	} while ( next($GLOBALS['afr_filter'][$tag]) !== false );

	array_pop( $GLOBALS['afr_current_filter'] );

	return $args[0];
}

function remove_filter( $tag, $function_to_remove, $priority = 10 ) {
	$function_to_remove = _afr_filter_build_unique_id($tag, $function_to_remove, $priority);

	$r = isset($GLOBALS['afr_filter'][$tag][$priority][$function_to_remove]);

	if ( true === $r) {
		unset($GLOBALS['afr_filter'][$tag][$priority][$function_to_remove]);
		if ( empty($GLOBALS['afr_filter'][$tag][$priority]) )
			unset($GLOBALS['afr_filter'][$tag][$priority]);
		unset($GLOBALS['merged_filters'][$tag]);
	}

	return $r;
}

function remove_all_filters($tag, $priority = false) {
	if( isset($GLOBALS['afr_filter'][$tag]) ) {
		if( false !== $priority && isset($GLOBALS['afr_filter'][$tag][$priority]) )
			unset($GLOBALS['afr_filter'][$tag][$priority]);
		else
			unset($GLOBALS['afr_filter'][$tag]);
	}

	if( isset($GLOBALS['merged_filters'][$tag]) )
		unset($GLOBALS['merged_filters'][$tag]);

	return true;
}

function current_filter() {
	return end( $GLOBALS['afr_current_filter'] );
}

function add_action($tag, $function_to_add, $priority = 10, $accepted_args = 1) {
	return add_filter($tag, $function_to_add, $priority, $accepted_args);
}

function do_action($tag, $arg = '') {
	if ( ! isset($GLOBALS['afr_actions']) )
		$GLOBALS['afr_actions'] = array();

	if ( ! isset($GLOBALS['afr_actions'][$tag]) )
		$GLOBALS['afr_actions'][$tag] = 1;
	else
		++$GLOBALS['afr_actions'][$tag];

	// Do 'all' actions first
	if ( isset($GLOBALS['afr_filter']['all']) ) {
		$GLOBALS['afr_current_filter'][] = $tag;
		$all_args = func_get_args();
		_afr_call_all_hook($all_args);
	}

	if ( !isset($GLOBALS['afr_filter'][$tag]) ) {
		if ( isset($GLOBALS['afr_filter']['all']) )
			array_pop($GLOBALS['afr_current_filter']);
		return;
	}

	if ( !isset($GLOBALS['afr_filter']['all']) )
		$GLOBALS['afr_current_filter'][] = $tag;

	$args = array();
	if ( is_array($arg) && 1 == count($arg) && isset($arg[0]) && is_object($arg[0]) ) // array(&$this)
		$args[] =& $arg[0];
	else
		$args[] = $arg;
	for ( $a = 2; $a < func_num_args(); $a++ )
		$args[] = func_get_arg($a);

	// Sort
	if ( !isset( $GLOBALS['merged_filters'][ $tag ] ) ) {
		ksort($GLOBALS['afr_filter'][$tag]);
		$GLOBALS['merged_filters'][ $tag ] = true;
	}

	reset( $GLOBALS['afr_filter'][ $tag ] );

	do {
		foreach ( (array) current($GLOBALS['afr_filter'][$tag]) as $the_ )
			if ( !is_null($the_['function']) )
				call_user_func_array($the_['function'], array_slice($args, 0, (int) $the_['accepted_args']));

	} while ( next($GLOBALS['afr_filter'][$tag]) !== false );

	array_pop($GLOBALS['afr_current_filter']);
}

function did_action($tag) {
	if ( ! isset( $GLOBALS['afr_actions'] ) || ! isset( $GLOBALS['afr_actions'][$tag] ) )
		return 0;

	return $GLOBALS['afr_actions'][$tag];
}

function do_action_ref_array($tag, $args) {
	if ( ! isset($GLOBALS['afr_actions']) )
		$GLOBALS['afr_actions'] = array();

	if ( ! isset($GLOBALS['afr_actions'][$tag]) )
		$GLOBALS['afr_actions'][$tag] = 1;
	else
		++$GLOBALS['afr_actions'][$tag];

	// Do 'all' actions first
	if ( isset($GLOBALS['afr_filter']['all']) ) {
		$GLOBALS['afr_current_filter'][] = $tag;
		$all_args = func_get_args();
		_afr_call_all_hook($all_args);
	}

	if ( !isset($GLOBALS['afr_filter'][$tag]) ) {
		if ( isset($GLOBALS['afr_filter']['all']) )
			array_pop($GLOBALS['afr_current_filter']);
		return;
	}

	if ( !isset($GLOBALS['afr_filter']['all']) )
		$GLOBALS['afr_current_filter'][] = $tag;

	// Sort
	if ( !isset( $GLOBALS['merged_filters'][ $tag ] ) ) {
		ksort($GLOBALS['afr_filter'][$tag]);
		$GLOBALS['merged_filters'][ $tag ] = true;
	}

	reset( $GLOBALS['afr_filter'][ $tag ] );

	do {
		foreach( (array) current($GLOBALS['afr_filter'][$tag]) as $the_ )
			if ( !is_null($the_['function']) )
				call_user_func_array($the_['function'], array_slice($args, 0, (int) $the_['accepted_args']));

	} while ( next($GLOBALS['afr_filter'][$tag]) !== false );

	array_pop($GLOBALS['afr_current_filter']);
}

function has_action($tag, $function_to_check = false) {
	return has_filter($tag, $function_to_check);
}

function remove_action( $tag, $function_to_remove, $priority = 10 ) {
	return remove_filter( $tag, $function_to_remove, $priority );
}

function remove_all_actions($tag, $priority = false) {
	return remove_all_filters($tag, $priority);
}

function plugin_dir_path( $file ) {
	return trailingslashit( dirname( $file ) );
}

function plugin_dir_url( $file ) {
	return trailingslashit( plugins_url( '', $file ) );
}

function register_activation_hook($file, $function) {
	$file = plugin_basename($file);
	add_action('activate_' . $file, $function);
}

function register_deactivation_hook($file, $function) {
	$file = plugin_basename($file);
	add_action('deactivate_' . $file, $function);
}

function register_uninstall_hook( $file, $callback ) {
	if ( is_array( $callback ) && is_object( $callback[0] ) ) {
		_doing_it_wrong( __FUNCTION__, __( 'Only a static class method or function can be used in an uninstall hook.' ), '3.1' );
		return;
	}

	$uninstallable_plugins = (array) get_option('uninstall_plugins');
	$uninstallable_plugins[plugin_basename($file)] = $callback;
	update_option('uninstall_plugins', $uninstallable_plugins);
}

function _afr_call_all_hook($args) {
	reset( $GLOBALS['afr_filter']['all'] );
	do {
		foreach( (array) current($GLOBALS['afr_filter']['all']) as $the_ )
			if ( !is_null($the_['function']) )
				call_user_func_array($the_['function'], $args);

	} while ( next($GLOBALS['afr_filter']['all']) !== false );
}

function _afr_filter_build_unique_id($tag, $function, $priority) {
	static $filter_id_count = 0;

	if ( is_string($function) )
		return $function;

	if ( is_object($function) ) {
		// Closures are currently implemented as objects
		$function = array( $function, '' );
	} else {
		$function = (array) $function;
	}

	if (is_object($function[0]) ) {
		// Object Class Calling
		if ( function_exists('spl_object_hash') ) {
			return spl_object_hash($function[0]) . $function[1];
		} else {
			$obj_idx = get_class($function[0]).$function[1];
			if ( !isset($function[0]->afr_filter_id) ) {
				if ( false === $priority )
					return false;
				$obj_idx .= isset($GLOBALS['afr_filter'][$tag][$priority]) ? count((array)$GLOBALS['afr_filter'][$tag][$priority]) : $filter_id_count;
				$function[0]->afr_filter_id = $filter_id_count;
				++$filter_id_count;
			} else {
				$obj_idx .= $function[0]->afr_filter_id;
			}

			return $obj_idx;
		}
	} else if ( is_string($function[0]) ) {
		// Static Calling
		return $function[0].$function[1];
	}
}
