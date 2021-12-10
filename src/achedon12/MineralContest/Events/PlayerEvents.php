<?php

namespace achedon12\MineralContest\Events;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerDeathEvent;

class PlayerEvents implements Listener{

    public function onDeath(PlayerDeathEvent $event){
        $player = $event->getPlayer();
    }

    public function onChat(PlayerChatEvent $event){

        $player = $event->getPlayer();
    }
}