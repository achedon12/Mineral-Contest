<?php

namespace achedon12\MineralContest;

use achedon12\MineralContest\Commands\Annonce;
use achedon12\MineralContest\Commands\Metier;
use achedon12\MineralContest\Commands\Scenario;
use achedon12\MineralContest\Commands\StartCMD;
use achedon12\MineralContest\Events\PlayerEvents;
use pocketmine\event\Listener;
use pocketmine\network\mcpe\protocol\types\command\CommandData;
use pocketmine\network\mcpe\protocol\types\command\CommandParameter;
use pocketmine\permission\Permission;
use pocketmine\permission\PermissionManager;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class MC extends PluginBase implements Listener{


    /** @var MC $instance*/
    private static $instance;

    /** @var int|bool $start */
    public static int|bool $start = false;
    /** @var Player[] $EQUIPE_A */
    public static array $EQUIPE_A = [];
    /** @var Player[] $EQUIPE_B */
    public static array $EQUIPE_B = [];
    /** @var Player[] $EQUIPE_C */
    public static array $EQUIPE_C = [];
    /** @var Player[] $EQUIPE_D */
    public static array $EQUIPE_D = [];
    /** @var array $ALL_EQUIPE */
    public static array $ALL_EQUIPE = [];
    /** @var array $CLASS */
    public static array $CLASS = [];
    /** @var array $COOLDOWN */
    public static array $COOLDOWN = [];



    protected function onEnable(): void{

        self::$instance = $this;
        @mkdir($this->getDataFolder());
        $this->saveResource("config.yml");

        $this->getLogger()->info("Plugin Enable");

        $this->getServer()->getCommandMap()->registerAll('MineralContest',[
            new StartCMD("start","start a game","/start"),
            new Metier("class","choose/claim a class","/class"),
            new Scenario("scenario","plugin's informations","/scenario"),
            new Annonce("annonce","broadcast a message", "/annonce")
        ]);

        $this->getServer()->getPluginManager()->registerEvents(new PlayerEvents(), $this);

        PermissionManager::getInstance()->addPermission(new Permission("mc.op"));


    }

    protected function onDisable(): void{
        $this->getLogger()->info("Plugin Disable");
        $this->saveResource("config.yml");
    }

    public static function getConfigs() : Config{
        return new Config(self::$instance->getDataFolder() . "config.yml", Config::YAML);
    }

    public static function getInstance(): self{
        return self::$instance;
    }

    public static function getEquipe(Player $player) : string{
        $equipe = self::$ALL_EQUIPE[$player->getName()];
        return $equipe;
    }

    public static function getMetier(Player $player) : string{
        $class = self::$CLASS[$player->getName()];
        return $class;
    }

}