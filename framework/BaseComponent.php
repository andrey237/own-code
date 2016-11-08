<?php

//	Базовый компонент. От него наследуются все классы приложения, кроме GMS.
//	В нём должна быть прописана базовая обработка сеттеров и геттеров.
class BaseComponent
{
	/*
	public function __get($name)
	{
		$getter = 'get' . ucfirst($name);
		
		if (method_exists($this, $getter))
			return $this->$getter($value);

		$privateName = '_' . $name;

		if (property_exists($this, $privateName))
			return $this->$privateName;
	}

	public function __set($name, $value)
	{
		$setter = 'set' . ucfirst($name);

		if (method_exists($this, $setter))
			$this->$setter($value);

		$privateName = '_' . $name;
		//var_dump($this);
		echo "Установка '$privateName' в '$value'\n";
		var_dump(isset($this->$privateName));
		if (property_exists($this, $privateName))
		{
			$this->$privateName = $value;
			var_dump($this->$privateName);
		}
		else
			echo "Переменная '$privateName' не установлена в '$value'\n";
	}
	*/
}