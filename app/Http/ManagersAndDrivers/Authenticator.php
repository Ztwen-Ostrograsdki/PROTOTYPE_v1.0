<?php


namespace App\Http\ManagersAndDrivers;

use Illuminate\Database\Eloquent\Model;

class Authenticator{


	public static function __AUTH_TOKEN($getToken, $TOKEN = null)
	{
		$TOKEN = csrf_token();
		if ($TOKEN !== $getToken) {
			$data = ['invalidInputs' => ['token' =>['La requête est corrompue, veuillez vérifier vos données ou contacter le service de maintenance du site']]];
		}
		else{
			$data = [];
		}

		return $data;
	}


	public static function __GET_MODELS_IF_EXISTS_BY_NAME_OR_EMAIL($classeMapping, $name = null, $email = null)
	{
		$targets = null;

		if ($name !== null && $email !== null) {
			$targeted = $classeMapping::withTrashed('deleted_at')->where('name', $name)->orWhere('email', $email)->get();
		}
		else{
			if ($email == null) {
				$targeted = $classeMapping::withTrashed('deleted_at')->where('name', $name)->get();
			}
			else{
				$targeted = $classeMapping::withTrashed('deleted_at')->where('email', $email)->get();
			}
		}

		if (count($targeted) > 0) {
			$targets = $targeted[0];
		}
		
		return $targets;
	}



}