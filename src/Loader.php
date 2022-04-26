<?php

namespace davidglitch04\MultiServerChat;

use davidglitch04\MultiServerChat\Command\MultiServerChat;
use davidglitch04\MultiServerChat\Provider\MySQLProvider;
use davidglitch04\MultiServerChat\Task\ShowChat;
use davidglitch04\MultiServerChat\Updater\GetUpdateInfo;
use pocketmine\plugin\PluginBase;

class Loader extends PluginBase {

    public static $instance;

    public MySQLProvider $provider;

    public function onEnable(): void
    {
        self::$instance = $this;
        $this->getScheduler()->scheduleRepeatingTask(new ShowChat($this), 1);
        $this->initialize();
        var_dump(time());
    }

    protected function initialize()
    {
        if ($this->getConfig()->get("auto-updater")) {
            $this->checkUpdater();
        }
        $this->provider = new MySQLProvider($this);
        $this->provider->open();
        $this->getServer()->getCommandMap()->register("multiserverchat", new MultiServerChat($this));
    }

    public function getProvider(): MySQLProvider{
        return $this->provider;
    }

    protected function checkUpdater() : void {
        $this->getServer()->getAsyncPool()->submitTask(new GetUpdateInfo($this, "https://raw.githubusercontent.com/David-pm-pl/MultiServerChat/stable/poggit_news.json"));
    }

    public static function getInstance(): Loader{
        return self::$instance;
    }

    public function getFileHack(): string{
        return $this->getFile();
    }
}