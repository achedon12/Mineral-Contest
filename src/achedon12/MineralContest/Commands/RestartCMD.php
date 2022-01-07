<?php

namespace achedon12\MineralContest\Commands;

use achedon12\MineralContest\MC;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\lang\Translatable;
use pocketmine\player\Player;
use pocketmine\Server;

class RestartCMD extends Command{

    private const prefix = "§0[§6Mineral§bContest§0]§r";


    public function __construct(string $name, Translatable|string $description = "", Translatable|string|null $usageMessage = null, array $aliases = [])
    {
        parent::__construct($name, $description, $usageMessage, $aliases);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if(!$sender instanceof Player){
            $sender->sendMessage("Command to execute in game");
        }else {
            if (!$sender->hasPermission("mc.op") && !Server::getInstance()->isOp($sender->getName())) {
                $sender->sendMessage(self::prefix . " §eYou don't have this permission to execute this command");
            } else {
                if(MC::$start != 1){
                    $sender->sendMessage(self::prefix." §eNone game has been launch");
                }else {
                    MC::restartScenario($sender);
                    Server::getInstance()->broadcastMessage(self::prefix." The scenario has been restart");
                }
            }
        }
    }
}