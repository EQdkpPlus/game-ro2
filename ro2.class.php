<?php
/*	Project:	EQdkp-Plus
 *	Package:	Rangarok online 2 game package
 *	Link:		http://eqdkp-plus.eu
 *
 *	Copyright (C) 2006-2015 EQdkp-Plus Developer Team
 *
 *	This program is free software: you can redistribute it and/or modify
 *	it under the terms of the GNU Affero General Public License as published
 *	by the Free Software Foundation, either version 3 of the License, or
 *	(at your option) any later version.
 *
 *	This program is distributed in the hope that it will be useful,
 *	but WITHOUT ANY WARRANTY; without even the implied warranty of
 *	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *	GNU Affero General Public License for more details.
 *
 *	You should have received a copy of the GNU Affero General Public License
 *	along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

if ( !defined('EQDKP_INC') ){
	header('HTTP/1.0 404 Not Found');exit;
}

if(!class_exists('ro2')) {
	class ro2 extends game_generic {
		protected static $apiLevel	= 20;
		public $version				= '1.0.0';
		protected $this_game		= 'ro2';
		protected $types			= array('classes', 'races', 'filters');
		protected $classes			= array();
		protected $races			= array();
		protected $filters			= array();
		public $langs				= array('english');

		protected $class_dependencies = array(
			array(
				'name'		=> 'race',
				'type'		=> 'races',
				'admin'		=> false,
				'decorate'	=> true,
				'parent'	=> false
			),
			array(
				'name'		=> 'class',
				'type'		=> 'classes',
				'admin'		=> false,
				'decorate'	=> true,
				'primary'	=> true,
				'colorize'	=> true,
				'roster'	=> true,
				'recruitment' => true,
				'parent'	=> array(
					'race' => array(
						0 	=> 'all',		// Unknown
						1 	=> 'all',		// Norman
						2 	=> 'all',		// Ellr
						3 	=> 'all',		// Dimago
					),
				),
			),
		);

		protected $class_colors = array(
			1	=> '#1FCA1F',
			2	=> '#D41188',
			3	=> '#19ECFF',
			4	=> '#C70909',
			5	=> '#FFE719',
		);

		protected $glang		= array();
		protected $lang_file	= array();
		protected $path			= '';
		public $lang			= false;

		protected function load_filters($langs){
			if(!$this->classes) {
				$this->load_type('classes', $langs);
			}
			foreach($langs as $lang) {
				$names = $this->classes[$this->lang];
				$this->filters[$lang][] = array('name' => '-----------', 'value' => false);
				foreach($names as $id => $name) {
					$this->filters[$lang][] = array('name' => $name, 'value' => 'class:'.$id);
				}
				$this->filters[$lang] = array_merge($this->filters[$lang], array(
					array('name' => '-----------', 'value' => false),
					array('name' => $this->glang('tank', true, $lang), 'value' => 'class:4'),
					array('name' => $this->glang('damage_dealer', true, $lang), 'value' => 'class:2,3,5'),
					array('name' => $this->glang('healer', true, $lang), 'value' => 'class:1'),
					
				));
			}
		}
		
		public function profilefields(){
			$xml_fields = array(
				'advancedclass'	=> array(
					'type'			=> 'dropdown',
					'category'		=> 'character',
					'lang'			=> 'uc_advanced_class',
					'options'		=> array('-' => 'uc_ac_0','Acolyte - Monk' => 'uc_ac_1', 'Acolyte - Priest' => 'uc_ac_2', 'Archer - Beastmasters' => 'uc_ac_3', 'Archer - Ranger' => 'uc_ac_4', 'Magician - Sorcerer' => 'uc_ac_5', 'Magician - Wizard' => 'uc_ac_6', 'Swordman - Knight' => 'uc_ac_7', 'Swordman - Warrior' => 'uc_ac_8', 'Thief - Assassin' => 'uc_ac_9', 'Thief - Rogue' => 'uc_ac_10'),
					'undeletable'	=> true,
					'tolang'		=> true
				),
				'gender'	=> array(
					'type'			=> 'dropdown',
					'category'		=> 'character',
					'lang'			=> 'uc_gender',
					'options'		=> array('Male' => 'uc_male', 'Female' => 'uc_female'),
					'undeletable'	=> true,
					'tolang'		=> true
				),
				'guild'	=> array(
					'type'			=> 'text',
					'category'		=> 'character',
					'lang'			=> 'uc_guild',
					'size'			=> 32,
					'undeletable'	=> true,
				),
				'prof1_value'	=> array(
					'type'			=> 'int',
					'category'		=> 'profession',
					'lang'			=> 'uc_prof1_value',
					'size'			=> 4,
					'undeletable'	=> true,
				),
				'prof1_name'	=> array(
					'type'			=> 'dropdown',
					'category'		=> 'profession',
					'lang'			=> 'uc_prof1_name',
					'options'		=> array('-' => 'uc_job_0', 'Alchemy' => 'uc_job_1', 'Artisan' => 'uc_job_2', 'Blacksmith' => 'uc_job_3', 'Chef' => 'uc_job_4'),
					'undeletable'	=> true,
					'tolang'		=> true
				),
			);
			return $xml_fields;
		}

		public function install($install=false){}
	}
}
?>