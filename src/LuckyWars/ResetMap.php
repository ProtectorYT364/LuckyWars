<?php

namespace LuckyWars;

use pocketmine\scheduler\Task;
use LuckyWars\GameSender;

class ResetMap implements Task {

	public function __construct(GameSender $plugin) {
		$this->plugin = $plugin;
	}

	public function reload($lev) {
		$name = $lev->getFolderName();
		
		if ($this->plugin->getOwner()->getServer()->isWorldLoaded($name)) {
			$this->plugin->getOwner()->getServer()->unloadWorld($this->plugin->getOwner()->getServer()->getWorldByName($name));
		}
		
		$zip = new \ZipArchive;
		$zip->open($this->plugin->getOwner()->getDataFolder() . 'arenas/' . $name . '.zip');
		$zip->extractTo($this->plugin->getOwner()->getServer()->getDataPath() . 'worlds');
		$zip->close();
		unset($zip);
		$this->plugin->getOwner()->getServer()->loadWorld($name);
		return true;
	}

}
