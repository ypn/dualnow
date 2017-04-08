<?php 
	namespace App\Helpers;
	use App\Entities\Users;

	/**
	* 
	*/
	class Utilities 
	{
		
		public static function slug($name,$table){
			switch ($table) {
				case 'users':
					$slug = str_slug($name);
					$obj = new Users();
					$i = 0;
	                while (1) {
	                    if ($i == 0) {
	                        $check = $obj->where('alias', $slug)->count();
	                    } else {
	                        $check = $obj->where('alias', $slug . '-' . $i)->count();
	                    }
	                    if ($check == 0 && $i != 0) {
	                        return $slug . '-' . $i;
	                    } elseif ($check == 0 && $i == 0) {
	                        return $slug;
	                    }
	                    $i++;
	                }
					break;				
				default:
					$slug = str_slug($name);
					break;
			}

			return $slug;
		}
	}

 ?>