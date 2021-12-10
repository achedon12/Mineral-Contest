<?php

namespace achedon12\MineralContest;

use achedon12\MineralContest\Commands\Metier;
use achedon12\MineralContest\Commands\StartCMD;
use achedon12\MineralContest\Events\PlayerEvents;
use pocketmine\event\Listener;
use pocketmine\permission\Permission;
use pocketmine\permission\PermissionManager;
use pocketmine\plugin\PluginBase;

class MC extends PluginBase implements Listener{

    public static int $start = 0;
    public static $EQUIPE_A = [];
    public static $EQUIPE_B = [];
    public static $EQUIPE_C = [];
    public static $EQUIPE_D = [];

    protected function onEnable(): void
    {
        $this->getLogger()->info("Plugin Enable");

        $this->getServer()->getCommandMap()->registerAll('Commands',[
            new StartCMD("start","start a game","/start"),
            new Metier("metier","choose/claim a class","/metier")
        ]);

        $this->getServer()->getPluginManager()->registerEvents(new PlayerEvents(), $this);

        PermissionManager::getInstance()->addPermission(new Permission("mc.start"));


    }

    protected function onDisable(): void
    {
        $this->getLogger()->info("Plugin Disable");
    }


}