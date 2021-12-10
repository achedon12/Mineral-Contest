<?php

namespace achedon12\MineralContest\Events;

use achedon12\MineralContest\MC;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerRespawnEvent;
use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\world\Position;

class PlayerEvents implements Listener{

    private const prefix = "§0[§6Mineral§bContest§0]§r";
    private const Team_prefix = "§b[§cTeam§b]§r";

    public function onEntityDamageEvent(EntityDamageEvent $event){

        if($event->getEntity() instanceof Player){
            $cfg = MC::getConfigs();

            $player = $event->getEntity();
            $event->cancel();
            $player->setHealth(20);
            if(MC::$start == 1){
                $equipe = MC::getEquipe($player);
                $x = $cfg->getNested("Equipe.$equipe.x");
                $y = $cfg->getNested("Equipe.$equipe.y");
                $z = $cfg->getNested("Equipe.$equipe.z");
                $world = Server::getInstance()->getWorldManager()->getWorldByName($cfg->get("World"));
                $player->teleport(new Position($x,$y,$z,$world));
                Server::getInstance()->broadcastMessage(self::prefix." ".$player->getName()." is dead");
            }else{
                $player->teleport(Server::getInstance()->getWorldManager()->getWorldByName("world")->getSafeSpawn());
                Server::getInstance()->broadcastMessage(self::prefix." ".$player->getName()." is dead");
            }
        }
    }

    public function onChat(PlayerChatEvent $event){
        $event->cancel();
        $msg = $event->getMessage();
        if(MC::$start == 1) {
            $equipe = MC::$ALL_EQUIPE[$event->getPlayer()->getName()];
            if (strpos($event->getMessage(), "!") === false) {
                switch ($equipe) {
                    case "a":
                        foreach (MC::$EQUIPE_A as $player) {
                            if ($player->isConnected()) {
                                $player->sendMessage(self::Team_prefix . " " . $player->getName() . " §6»§r " . $event->getMessage());
                            }
                        }
                        return;
                    case "b":
                        foreach (MC::$EQUIPE_B as $player) {
                            if ($player->isConnected()) {
                                $player->sendMessage(self::Team_prefix . " " . $player->getName() . " §6»§r " . $event->getMessage());
                            }
                        }
                        return;
                    case "c":
                        foreach (MC::$EQUIPE_C as $player) {
                            if ($player->isConnected()) {
                                $player->sendMessage(self::Team_prefix . " " . $player->getName() . " §6»§r " . $event->getMessage());
                            }
                        }
                        return;
                    case "d":
                        foreach (MC::$EQUIPE_D as $player) {
                            if ($player->isConnected()) {
                                $player->sendMessage(self::Team_prefix . " " . $player->getName() . " §6»§r " . $event->getMessage());
                            }
                        }
                        return;
                }
            } else {
                Server::getInstance()->broadcastMessage($event->getPlayer()->getName() . " §6»§r " .substr($msg,1));
            }
        }else{
            Server::getInstance()->broadcastMessage($event->getPlayer()->getName(). " §6»§r ". $msg);
        }
    }
}