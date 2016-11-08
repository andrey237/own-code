<?php

class Unit
{
	public static $etalonOld = 30;

	public $skill;
	public $feature;
	public $weapon;
	public $place;
	public $position;
	public $sex;
	public $weight;
	public $deductionWeight = 0;
	public $proportion = 100;
	public $old;
	public $health = 1000;

	public function __construct()
	{
		$this->skill	= $_POST['skill'];
		$this->feature	= $_POST['feature'];
		$this->weapon	= $_POST['weapon'];
		$this->place	= $_POST['place'];
		$this->position	= $_POST['position'];
		$this->sex		= $_POST['sex'];
		$this->weight	= $_POST['weight'];
		$this->old		= $_POST['old'];
		$this->health	= $_POST['health'];
	}

	public function calculateBonus()
	{
		$result = $this->skill + $this->feature + $this->weapon + $this->place + $this->position;

		/*if ($this->sex == 'male')
		{
			$this->proportion = 100;
			$this->deductionWeight = 0;
		}
		elseif ($this->sex == 'female')
		{
			$this->proportion = 110;
			$this->deductionWeight = 5;
		}

		$normalWeight = $this->height - $proportion;
		$diffWeight = abs($normalWeight - $this->weight - $deductionWeight);

		$topBorder = Unit::$etalonOld*2;
		$diffOld = $this->old <= Unit::$etalonOld ? $this->old : $topBorder - $this->old;

		$result += $diffOld - $diffWeight;*/

		return $result;
	}
}