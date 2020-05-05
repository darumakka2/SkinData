<?php

namespace Skin;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerLoginEvent;
use pocketmine\Server;
use pocketmine\utils\Config;
use pocketmine\utils\UUID;

class Main extends PluginBase implements Listener{

	public function onEnable(){
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		if(!file_exists($this->getDataFolder())){
			mkdir($this->getDataFolder(), 0744, true); 
		}
		$this->player = new Config($this->getDataFolder() . "skin.yml", Config::YAML, array());
		$this->data = $this->player->getAll();
	}

	public function onDisable(){
		$this->ConfigSave();
	}

	public function onLogin(PlayerLoginEvent $event){
		$player = $event->getPlayer();
		$name = strtolower($player->getName());
		$skin = $player->getSkin();
		$skinid = base64_encode($skin->getSkinId());
		$skindata = base64_encode($skin->getSkinData());
		$capedata = base64_encode($skin->getCapeData());
		$geometryname = base64_encode($skin->getGeometryName());
		$geometrydata = base64_encode($skin->getGeometryData());
		$this->data[$name]["Name"] = $name;
		$this->data[$name]["Skinid"] = $skinid;
		$this->data[$name]["Skindata"] = $skindata;
		$this->data[$name]["Capedata"] = $capedata;
		$this->data[$name]["Geometryname"] = $geometryname;
		$this->data[$name]["Geometrydata"] = $geometrydata;
		$this->ConfigSave();
	}

	public function ConfigSave(){
		foreach($this->data as $t){
			$this->player->set($t["Name"], $t);
		}
		$this->player->save();
	}
}