<?php

namespace CIPD\CIPD; // This one should be changed

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;

use pocketmine\event\player\PlayerItemHeldEvent;
use pocketmine\Player;
use pocketmine\utils\Config;

class Main extends PluginBase implements Listener{
   
   public $prefs;
     
     public function onLoad(){
         $this->getLogger()->info('Loading...');
     }
     public function onEnable(){
       @mkdir($this->getDataFolder());
       if(file_exists($this->getDataFolder()."config.yml")){
       $this->prefs = (new Config($this->getDataFolder()."config.yml", Config::YAML))->getAll();
       }else{
         $default = array(
         "popup-time" => 2,
         "items" => array(
           "246" => "AllMighty Glowing Obsidian"
         ));
         $this->prefs = (new Config($this->getDataFolder()."config.yml", Config::YAML, $default))->getAll();
       }
       $this->getServer()->getPluginManager()->registerEvents($this, $this); // You must register Listener to do something on events
       $this->getLogger()->info('Enabled!');
     }
     public function onDisable(){
       $this->saveDefaultConfig();
       $this->getLogger()->info('Disabled');
     }
     
     public function onItemHeld(PlayerItemHeldEvent $event){
       $player = $event->getPlayer();
       $item = $event->getItem();
         if(array_key_exists($item->getId(), $this->prefs['items'])){
           $popup = $this->prefs['items'][$item->getId()];
           $player->sendPopup($popup, $this->prefs['popup-time']);
           return true;
         }
     }
}
