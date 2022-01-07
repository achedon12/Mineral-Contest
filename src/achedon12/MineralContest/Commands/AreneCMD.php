<?php

namespace achedon12\MineralContest\Commands;

use achedon12\MineralContest\MC;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\lang\Translatable;
use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\world\Position;

class AreneCMD extends Command{

    private const prefix = "§0[§6Mineral§bContest§0]§r";

    public function __construct(string $name, Translatable|string $description = "", Translatable|string|null $usageMessage = null, array $aliases = [])
    {
        parent::__construct($name, $description, $usageMessage, $aliases);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        $cfg = MC::getConfigs();
        if(!$sender instanceof Player) {
            $sender->sendMessage("Command to execute in game");
        }else{
            if(!MC::$ARENE == 1){
                $sender->sendMessage(self::prefix." You can not teleport to the arena");
            }else{
                $equipe = MC::getEquipe($sender);
                $x = $cfg->getNested("Equipe.$equipe.arene.x");
                $y = $cfg->getNested("Equipe.$equipe.arene.y");
                $z = $cfg->getNested("Equipe.$equipe.arene.z");
                $world = Server::getInstance()->getWorldManager()->getWorldByName($cfg->get("World0"));
                switch($equipe){
                    case "a":
                        foreach(MC::$EQUIPE_A as $players){
                            $players->teleport(new Position($x,$y,$z,$world));
                        }
                        $players->sendMessage(self::prefix." You have been teleported to the arena");
                        break;
                    case "b":
                        foreach(MC::$EQUIPE_B as $players){
                            $players->teleport(new Position($x,$y,$z,$world));
                        }
                        $players->sendMessage(self::prefix." You have been teleported to the arena");
                        break;
                    case "c":
                        foreach(MC::$EQUIPE_C as $players){
                            $players->teleport(new Position($x,$y,$z,$world));
                        }
                        $players->sendMessage(self::prefix." You have been teleported to the arena");
                        break;
                    case "d":
                        foreach(MC::$EQUIPE_D as $players){
                            $players->teleport(new Position($x,$y,$z,$world));
                        }
                        $players->sendMessage(self::prefix." You have been teleported to the arena");
                        break;
                }
            }
        }
    }
}