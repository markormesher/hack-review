<?php

class Utils {

	public static function hashPassword($input) {
		// double hashed with salt
		return sha1('}[\cT{JqI%G~<Iwc4LFS' . sha1($input));
	}

}