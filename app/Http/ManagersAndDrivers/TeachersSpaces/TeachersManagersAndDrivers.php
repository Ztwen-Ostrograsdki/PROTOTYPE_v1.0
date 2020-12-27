<?php

namespace App\Http\ManagersAndDrivers\TeachersSpaces;

use App\Http\Controllers\Master\TeachersController;
use App\Http\ValidatorsSpaces\TeachersValidators;
use App\Models\Teacher;

//__DRM => DRIVERS and MANAGERS

class TeachersManagersAndDrivers{

	use TeachersValidators;

	private $teacher;

	public function __construct(Teacher $teacher){
		$this->teacher = $teacher;
	}


    /**
     * [__DRM_TO_EDIT_TEACHER description]
     * @param  [type] $tag     [description]
     * @param  [type] $request [description]
     * @return [type]          [description]
     */
    public function __DRM_TO_EDIT_TEACHER($tag, $request)
    {
        $teacher = $this->teacher;
        
        return (new TeachersController())->teachersDataSender();
    }









}