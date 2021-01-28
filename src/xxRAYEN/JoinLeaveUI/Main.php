<?php

namespace xxRAYEN\JoinLeaveUI;

use pocketmine\plugin\{
	PluginBase,
	Plugin
};
use pocketmine\event\{
	Listener,
	player\PlayerJoinEvent,
	player\PlayerQuitEvent
};
use pocketmine\command\{
	Command,
	CommandSender
};
use pocketmine\utils\Config;
use pocketmine\math\Vector3;
use pocketmine\Player;

class Main extends PluginBase implements Listener{
	public function onEnable(){
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	}
	
	public function onJoin(PlayerJoinEvent $event, PlayerQuitEvent $event2) {
		$sender = $event->getPlayer();
		$sender2 = $event2->getPlayer();
		if($sender->hasPermission("join.leave")) {
			$event->setJoinMessage("§7[ §a" . $sender->getName() . " §7] : " . $this->getConfig()->get("Join-" . $sender->getName()));
			$event2->setQuitMessage("§7[ §c" . $sender2->getName() . " §7] : " . $this->getConfig()->get("Quit-" . $sender2->getName()));
		}
	}
		
	public function onCommand(CommandSender $sender, Command $command, $lbl, array $args) : bool
	{
		switch($command->getName()){
			case "join":
				$form = $this->getServer()->getPluginManager()->getPlugin("FormAPI")->createCustomForm(function ($sender, $data) {
					if($sender->hasPermission("join.leave")) {
						if($data[1] != " ") {
							if($data[2] != " ") {
								$this->getConfig()->set("Join-" . $sender->getName(), $data[1]);
								$this->getConfig()->set("Quit-" . $sender->getName(), $data[2]);
							} else {
								$sender->sendMessage("§7[ §b§lSYSTEM §r§7] §cYou must set the Quit Message!");
							}
						} else {
							$sender->sendMessage("§7[ §b§lSYSTEM §r§7] §cYou must set the Join Message!");
						}
					} else {
						$sender->sendMessage("§7[ §b§lSYSTEM §r§7] §cYou can't do that!");
					}
				});
				$form->setTitle("§aJoin§cLeave §aU§cI");
				$form->addLabel("§7Set your §aJoin §7and §cLeave §7message.");
				$form->addInput("§aJoin Message:", "Join Message", "");
				$form->addInput("§cLeave Message:", "Leave Message", "");
				if($sender instanceof Player) {
					$form->sendToPlayer($sender);
				} else {
					$sender->sendMessage("§7[ §b§lSYSTEM §r§7] §cYou can't do that from the console.");
				}
				return true;
			case "leave":
				$form = $this->getServer()->getPluginManager()->getPlugin("FormAPI")->createCustomForm(function ($sender, $data) {
					if($sender->hasPermission("join.leave")) {
						if($data[1] != " ") {
							if($data[2] != " ") {
								$this->getConfig()->set("Join-" . $sender->getName(), $data[1]);
								$this->getConfig()->set("Quit-" . $sender->getName(), $data[2]);
							} else {
								$sender->sendMessage("§7[ §b§lSYSTEM §r§7] §cYou must set the Quit Message!");
							}
						} else {
							$sender->sendMessage("§7[ §b§lSYSTEM §r§7] §cYou must set the Join Message!");
						}
					} else {
						$sender->sendMessage("§7[ §b§lSYSTEM §r§7] §cYou can't do that!");
					}
				});
				$form->setTitle("§aJoin§cLeave §aU§cI");
				$form->addLabel("§7Set your §aJoin §7and §cLeave §7message.");
				$form->addInput("§aJoin Message:", "Join Message", "");
				$form->addInput("§cLeave Message:", "Leave Message", "");
				if($sender instanceof Player) {
					$form->sendToPlayer($sender);
				} else {
					$sender->sendMessage("§7[ §b§lSYSTEM §r§7] §cYou can't do that from the console.");
				}
				return true;
		}
		return true;
	}
}
