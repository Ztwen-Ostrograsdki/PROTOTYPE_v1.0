<?php

namespace App;

use App\Models\Classe;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Model;

class ClasseAndSubjectJoiner extends Model
{

	protected $serie;

	protected $classe;


    public function __construct(Model $classe)
    {
    	$this->classe = $classe;
    	$identify = $classe->name;

    	if (preg_match_all('/Sixi|Cinqui/', $identify)) {
    		$this->serie = 'serie-65';
    	}
    	elseif (preg_match_all('/Quatr|Trois/', $identify)) {
    		$this->serie = 'serie-43';
    	}
    	elseif (preg_match_all('/-D/', $identify)) {
    		$this->serie = 'serie-D';
    	}
        elseif (preg_match_all('/-A1/', $identify)) {
            $this->serie = 'serie-A1';
        }
        elseif (preg_match_all('/-A2/', $identify)) {
            $this->serie = 'serie-A2';
        }
    	elseif (preg_match_all('/-A/', $identify)) {
    		$this->serie = 'serie-A';
    	}
    	elseif (preg_match_all('/-AB/', $identify)) {
    		$this->serie = 'serie-AB';
    	}
    	elseif (preg_match_all('/-G/', $identify)) {
    		$this->serie = 'serie-G';
    	}
    	elseif (preg_match_all('/-F/', $identify)) {
    		$this->serie = 'serie-F';
    	}
    	elseif (preg_match_all('/-C/', $identify)) {
    		$this->serie = 'serie-C';
    	}
    	elseif (preg_match_all('/-B/', $identify)) {
    		$this->serie = 'serie-B';
    	}
        elseif (preg_match_all('/Seconde/', $identify) && !preg_match_all('/-/', $identify)) {
            $this->serie = 'serie-ABCD';
        }
    }

    public function getSerie()
    {
        $serie = $this->serie;
        return $serie;

    }


    public function seriesSubjects($serie):?array
    {
    	$depedences = [

    		'serie-65' => ['Français', 'Anglais', 'Histoire-Géographie', 'Mathématiques', 'Physique-Chimie-Technologie', 'Biologie', 'Informatique', 'Sport'],

    		'serie-43' => ['Français', 'Anglais', 'LV-2', 'Histoire-Géographie', 'Mathématiques', 'Physique-Chimie-Technologie', 'Biologie', 'Informatique', 'Sport'],

            'serie-A' => ['Français', 'Anglais', 'LV-2', 'Histoire-Géographie', 'Philosophie', 'Mathématiques', 'Biologie', 'Informatique', 'Sport'],

            'serie-A1' => ['Français', 'Anglais', 'LV-2', 'Histoire-Géographie', 'Philosophie', 'Mathématiques', 'Biologie', 'Informatique', 'Sport', 'Economie'],

    		'serie-A2' => ['Français', 'Anglais', 'LV-2', 'Histoire-Géographie', 'Philosophie', 'Mathématiques', 'Biologie', 'Informatique', 'Sport', 'Economie'],

    		'serie-AB' => ['Français', 'Anglais', 'LV-2', 'Histoire-Géographie', 'Philosophie', 'Mathématiques', 'Biologie', 'Informatique', 'Sport', 'Economie'],

    		'serie-B' => ['Français', 'Anglais', 'Histoire-Géographie', 'Philosophie', 'Mathématiques', 'Economie', 'Biologie', 'Informatique', 'Sport'],

    		'serie-G' => ['Français', 'Anglais', 'Histoire-Géographie', 'Philosophie', 'Mathématiques', 'Comptabilité', 'Biologie', 'Informatique', 'Sport'],

    		'serie-C' => ['Français', 'Anglais', 'Histoire-Géographie', 'Philosophie', 'Physique-Chimie-Technologie', 'Mathématiques', 'Biologie', 'Informatique', 'Sport'],

    		'serie-D' => ['Français', 'Anglais', 'Histoire-Géographie', 'Philosophie', 'Physique-Chimie-Technologie', 'Mathématiques', 'Biologie', 'Informatique', 'Sport'],

            'serie-ABCD' => ['Français', 'Anglais', 'Histoire-Géographie', 'Philosophie', 'Physique-Chimie-Technologie', 'LV-2']

    	];
    	return $depedences[$serie];
    }


    public function joinedSubjectsNow(Classe $classe)
    {
    	$subjectsOnDatabase = [];
    	$subjectsCollections = Subject::whereLevel('secondary')->get();

    	foreach ($subjectsCollections as $subjectsCollection) {
    		$subjectsOnDatabase[$subjectsCollection->id] = $subjectsCollection->name;
    	}

    	$subjectsOnDatabaseTrans = array_flip($subjectsOnDatabase); //transposed

    	$subjects = $this->seriesSubjects($this->serie);

    	foreach ($subjects as $subject) {
    		if (in_array($subject, $subjectsOnDatabase)) {
    			$classe->subjects()->attach($subjectsOnDatabaseTrans[$subject]);
    		}
    	}
    }


    public function getCoefiscientOfSubject($subject)
    {
        $name = $this->classe->name;

        if (preg_match_all('/Sixième|Cinquième/', $name) || $subject->name == 'Sport'|| $this->classe->level == 'primary') {
            return 1;
        }
        else{

            if (preg_match_all('/Quatri|Troisi/', $name)) {
                if ($subject->name == "Sport") {
                    return 1;
                }
                else{
                    return 2;
                }
            }
            if (preg_match_all('/Seconde/', $name)) {
                if ($this->serie == "serie-A") {
                    if (preg_match_all('/Math|Physi|Biologie/', $subject->name)) {
                        return 1;
                    }
                    else{
                        return 3;
                    }
                }
                if ($this->serie == "serie-D") {
                    if (preg_match_all('/Math|Physi|Biologie/', $subject->name)) {
                        return 3;
                    }
                    else{
                        return 2;
                    }
                }
                return 2;
                
            }
            return rand(1, 5);
        }
    }
}
