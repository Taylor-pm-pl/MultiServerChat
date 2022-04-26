<?php

namespace davidglitch04\MultiServerChat\Command;

use davidglitch04\MultiServerChat\Loader;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginOwned;

class MultiServerChat extends Command implements PluginOwned {

    protected Loader $msc;

    public function __construct(Loader $msc)
    {
        $this->msc = $msc;
        parent::__construct("multiserverchat");
        $this->setDescription("Chat to another server!");
        $this->setPermission("multiserverchat.allow.command");
        $this->setAliases(["msc"]);
    }

    public function getOwningPlugin(): Plugin
    {
        return $this->msc;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): void
    {
        if($sender instanceof Player){
            if(!isset($args[0])){
                $sender->sendMessage("Usage: /msc <message>");
                return;
            }
            $name = $sender->getName();
            $message = implode(" ", $args);
            $this->msc->getProvider()->sendChat($name, $message);
        }
    }
}