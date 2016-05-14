<?php
/**
 * User level
 *
 * AnsPress reputation based user level system
 *
 * @package answerbox
 */

function ab_get_levels(){
	$levels = array(
		array(
			'slug' => 'newbie',
			'name' => __('Newbie', 'ab'),
			'reputation' => 0,
		),
		array(
			'slug' => 'amateur',
			'name' => __('Amateur', 'ab'),
			'reputation' => 5,
		),
		array(
			'slug' => 'enthusiast',
			'name' => __('Enthusiast', 'ab'),
			'reputation' => 10,
		),
		array(
			'slug' => 'layman',
			'name' => __('Layman', 'ab'),
			'reputation' => 20,
		),
		array(
			'slug' => 'acolyte',
			'name' => __('Acolyte', 'ab'),
			'reputation' => 30,
		),
		array(
			'slug' => 'journeyman',
			'name' => __('Journeyman', 'ab'),
			'reputation' => 40,
		),
		array(
			'slug' => 'master',
			'name' => __('Master', 'ab'),
			'reputation' => 50,
		),
		array(
			'slug' => 'guru',
			'name' => __('Guru', 'ab'),
			'reputation' => 60,
		),
		array(
			'slug' => 'super_guru',
			'name' => __('Super Guru', 'ab'),
			'reputation' => 100,
		),
	);

	$levels = ab_sort_levels_by_reputation(apply_filters( 'ab_user_levels', $levels ));

	return $levels;
}

function ab_sort_levels_by_reputation($array){
	$new_array = array();
	if(!empty($array) && is_array($array) ){
		$group = array();
		foreach($array as $k => $a){
			$reputation = $a['reputation'];
			$group[$reputation][] = $a;
			$group[$reputation]['reputation'] = $reputation;
		}
		
		usort($group, function($a, $b) {
			return $a['reputation'] - $b['reputation'];
		});

		foreach($group as $a){
			foreach($a as $k => $newa){
				if($k !== 'reputation')
					$new_array[] = $newa;
			}
		}

		return $new_array;
	}
}

function ab_get_level($levels){
	$levels = ab_get_levels();

	if(isset($levels[$levels]))
		return $levels[$levels];

	return false;
}

function ab_get_user_level($user_id){
	$reputation = ap_get_reputation($user_id, false);
	return ab_get_level_by_repuation($reputation);
}

function ab_get_level_by_repuation($reputation){
	$levels = ab_get_levels();

	$prev = null;
	$i = 0;
	foreach($levels as $k => $level){

		if($reputation < $level['reputation'] && !empty($prev)){
			$prev['next_reputation'] = $level['reputation'];
			$prev['next_name'] = $level['name'];
			$prev['next_slug'] = $k;

			return $prev;
			break;
		}elseif($reputation == $level['reputation'] || (count($levels)) == $i+1){
			$values = array_values($levels);

			if(isset($values[$i+1]))
				$next = $values[$i+1];
			else
				$next = $level;

			$level['next_reputation'] = $next['reputation'];
			$level['next_name'] = $next['name'];
			$level['next_slug'] = $next['slug'];

			return $level;
			break;
		}

		$prev = $level;
		$i++;
	}
}

function ab_user_level_name($user_id){
	echo ab_get_user_level_name($user_id);
}

	function ab_get_user_level_name($user_id){	
		$reputation = ap_get_reputation($user_id, false);
		$level = ab_get_level_by_repuation($reputation);
		if(isset($level))
			return $level['name'];

		return false;
	}

function ab_user_percentage_to_next_level($user_id = false){
	echo ab_get_user_percentage_to_next_level($user_id);
}

	function ab_get_user_percentage_to_next_level($user_id = false){
		if($user_id === false)
			$user_id = bp_displayed_user_id();

		$reputation = ap_get_reputation($user_id, false);
		
		$level = ab_get_level_by_repuation($reputation);
		$percent = (int)round(($reputation/$level['next_reputation'])*100);

		return $percent > 100 ? 100 : $percent;
	}

function ab_reputation_badge($user_id, $stroke_color = '#18c6ff', $stroke_width = 3){
	$reputation = ap_get_reputation($user_id, false);
	$level = ab_get_level_by_repuation($reputation);

	echo '<div data-width="'.$stroke_width.'" data-color="'.$stroke_color.'" class="reputation-badge circle-progress" data-pct="'.ab_get_user_percentage_to_next_level($user_id).'"><span>'.ap_get_reputation($user_id, true).'<i>'.$level['name'].'</i></span></div>';
}

function ab_get_next_levels($user_id = false){
	if($user_id === false)
		$user_id = bp_displayed_user_id();

	$current = ab_get_user_level($user_id);
	$levels = ab_get_levels();

	$current_pointer = false;

	$next_levels = array();
	$prev = null;
	$i = 1;
	$start = false;
	foreach($levels as $k => $level){
		if($current_pointer)
			$start = true;

		if(($level['slug'] == $current['slug'] || $current_pointer) && empty($prev))
			$current_pointer = true;			

		if(!empty($prev)){
			if($current_pointer && count($levels) == $i && $start ){
				$next_levels[$k-1]['next_reputation'] = $prev['reputation'];
				$next_levels[$k-1]['next_name'] = $prev['name'];
				$next_levels[$k-1]['next_slug'] = $prev['slug'];
				$next_levels[$k] = $level;
			}elseif($current_pointer && $start){
				$next_levels[$k] = $prev;
				$next_levels[$k]['next_reputation'] = $level['reputation'];
				$next_levels[$k]['next_name'] = $level['name'];
				$next_levels[$k]['next_slug'] = $level['slug'];		
			}
		}
		
		if($current_pointer && $start)
			$prev = $level;

		$i++;
		
	}

	return $next_levels;
}

function ab_get_next_level_name($user_id = false){
	if($user_id === false)
		$user_id = bp_displayed_user_id();

	$level = ab_get_user_level($user_id);

	if($level['next_reputation'] == $level['reputation'])
		return false;

	return $level['next_name'];
}

function ab_reputation_required_for_next_level($user_id = false){
	if($user_id === false)
		$user_id = bp_displayed_user_id();

	$reputation = ap_get_reputation($user_id, false);
	$level = ab_get_user_level($user_id);

	return (int) $level['next_reputation'] - $reputation;
}

function ab_get_current_level_key($user_id = false){
	if($user_id === false)
		$user_id = bp_displayed_user_id();

	$level = ab_get_user_level($user_id);

	foreach(ab_get_levels() as $k => $v)
		if($v['slug'] == $level['slug']){
			return $k+1;
			break;
		}
}