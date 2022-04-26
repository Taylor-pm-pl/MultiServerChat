<?php

namespace davidglitch04\MultiServerChat\Provider;

use davidglitch04\MultiServerChat\Loader;
use pocketmine\Server;

class MySQLProvider {

    protected Loader $msc;

    protected \mysqli $db;

    public function __construct(Loader $msc)
    {
        $this->msc = $msc;
    }

    public function open(): void{
        $config = $this->msc->getConfig()->get("Database", []);
        $this->db = new \mysqli(
			$config["host"] ?? "127.0.0.1",
			$config["user"] ?? "DavidGlitch04",
			$config["password"] ?? "hello_world",
			$config["db"] ?? "MultiServerChat",
			$config["port"] ?? 3306);
        if ($this->db->connect_error) {
            $this->msc->getLogger()->info("Could not connect to MySQL server: ".$this->db->connect_error);
		    $this->msc->getServer()->getPluginManager()->disablePlugin($this->msc);
        } else{
			$this->msc->getLogger()->info("Connect DataBase Success!");
			$this->createTable();
        }
    }

    public function createTable(): void{
        if (!$this->db->query("CREATE TABLE IF NOT EXISTS ".$this->msc->getConfig()->get("Current-server")." (id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,server TEXT,name TEXT,message TEXT);")){
			$this->msc->getLogger()->info("Failed on creating table: " . $this->db->error);
		}
		for($i = 0;$i<count($this->msc->getConfig()->get("List-server", []));$i++){
		    if (!$this->db->query("CREATE TABLE IF NOT EXISTS ".$this->msc->getConfig()->get("List-server")[$i]." (id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,server TEXT,name TEXT,message TEXT);")){
			    $this->msc->getLogger()->info("Failed on creating table: " . $this->db->error);
		    }
		}
    }

    public function getFormat(array $replace): string{
        $search = ["{server}","{name}", "{message}"];
        $subject = $this->msc->getConfig()->get("Format-chat");
        return str_replace($search, $replace, $subject);
    }

    public function sendChat(string $username, string $message): void{
        $server = $this->msc->getConfig()->get("Current-server");
        Server::getInstance()->broadcastMessage($this->getFormat([$server, $username, $message]));
            for ($i=0;$i < count($this->msc->getConfig()->get("List-server", []));$i++) {
            $current = $this->msc->getConfig()->get("Current-server");
            $insert = "INSERT INTO " . $this->msc->getConfig()->get("List-server")[$i] . " (server,name,message) VALUES ('$current','$username','$message')";
            if (!$this->db->query($insert)) {
                $this->msc->getLogger()->info("Error: " . $this->db->error);
            }
        }
    }

    public function ShowChat(): void
    {
        $current = $this->msc->getConfig()->get("Current-server");
        $result = $this->db->query("SELECT * FROM " . $current);
        if (!$result) {
            print($this->db->error);
        } else {
            while ($row = $result->fetch_assoc()) {
                $name = str_replace(" ", "_", $row["name"]);
                $this->msc->getServer()->broadcastMessage($this->getFormat([$row["server"], $row["name"], $message = $row["message"]]));
                $del = $this->db->query("DELETE FROM " . $this->msc->getConfig()->get("Current-server") . " WHERE id = " . $row["id"]);
                if (!$del) {
                    print($this->db->error);
                }
            }
        }
    }
}
