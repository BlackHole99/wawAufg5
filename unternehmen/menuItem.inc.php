<?php
	class menuItem {
		public $ID;
		public $name;
		public $content;
		public $parent;
		public $head;
		public $menuID;
	
		public function __construct($ID, $name, $content, $parent, $head, $menuID) {
			$this->ID = $ID;
			$this->name = $name;
			$this->content = $content;
			$this->parent = $parent;
			$this->head = $head;
			$this->menuID = $menuID;
		}
	}
?>