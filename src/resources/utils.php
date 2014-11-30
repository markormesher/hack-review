<?php

class Utils {

	public static function hashPassword($input) {
		// double hashed with salt
		return sha1('}[\cT{JqI%G~<Iwc4LFS' . sha1($input));
	}

	public static function getStarString($value) {
		$output = '';
		$base = floor($value);
		$point = $value - $base;
		$remain = 5 - $base - ceil($point);
		for ($i = 0; $i < $base; ++$i) {
			$output .= '<i class="fa fa-star"></i>&nbsp;&nbsp;';
		}
		if ($point != 0) {
			if ($point >= 0.5) {
				$output .= '<i class="fa fa-star"></i>&nbsp;&nbsp;';
			} else {
				$output .= '<i class="fa fa-star-half-full"></i>&nbsp;&nbsp;';
			}
		}
		for ($i = 0; $i < $remain; ++$i) {
			$output .= '<i class="fa fa-star-o"></i>&nbsp;&nbsp;';
		}
		return $output;
	}

}