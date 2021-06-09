<?php

namespace App\Models;

use App\Models\Parentable;
use App\Models\Pupil;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Parentor extends Model
{
    use Notifiable;
	use SoftDeletes;

    protected $fillable = ['name', 'email', 'contact', 'sexe', 'residence', 'birth', 'year','month', 'firstName', 'surname', 'creator', 'editor', 'authorized', 'works'
		];

	public static function getParentWithThesePupils()
	{
		$table = [];
		$parents = Parentor::withTrashed('deleted_at')->orderBy('name', 'asc')->get();
		foreach ($parents as $parent) {
			$pupils = $parent->children();
			$table[] = [
				'parent' => $parent,
				'pupils' => $pupils,
			];
		}

		return $table;
	}

	public function children()
    {
        $children = [];
        $parenters = Parentable::where('parentor_id', $this->id)->get();
        if (count($parenters) > 0) {
            foreach ($parenters as $parenter) {
                $children[] = [
                    'child' => Pupil::withTrashed('deleted_at')->where('id', $parenter->pupil_id)->first(),
                    'relation' => $parenter->relation
                ];
            }
        }
        return $children;
    }



}
