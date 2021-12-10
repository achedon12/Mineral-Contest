<?php

namespace achedon12\MineralContest\Commands;

use achedon12\MineralContest\MC;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\lang\Translatable;
use pocketmine\player\Player;

class Metier extends Command{

    public function __construct(string $name, Translatable|string $description = "", Translatable|string|null $usageMessage = null, array $aliases = [])
    {
        parent::__construct($name, $description, $usageMessage, $aliases);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if(!$sender instanceof Player){
            $sender->sendMessage("Command to execute in game");
        }else{
            if(MC::$start == 0){
                $sender->sendMessage("You can't run this command while the game is not start");
            }elseif (MC::$start == 1){
                if(count($args) == 0){

                }else{

                }
            }
        }
    }
}
