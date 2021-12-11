<?php

namespace achedon12\MineralContest\Commands;

use achedon12\MineralContest\MC;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\lang\Translatable;
use pocketmine\player\Player;

class Metier extends Command{

    private const prefix = "§0[§6Mineral§bContest§0]§r";

    public function __construct(string $name, Translatable|string $description = "", Translatable|string|null $usageMessage = null, array $aliases = []){
        parent::__construct($name, $description, $usageMessage, $aliases);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args){
        if(!$sender instanceof Player){
            $sender->sendMessage("Command to execute in game");
        }else{
            if(MC::$start == 0){
                $sender->sendMessage(self::prefix." You can't run this command while the game is not start");
            }elseif (MC::$start == 1){
                if(count($args) == 0){
                    $sender->sendMessage(self::prefix." You can choose your class between <lutin | guerrier | mineur>\nExecute the command §c/class choose <lutin | guerrier | mineur>§r");
                }else{
                    if($args[0] != "choose" && $args[1] != ["lutin","guerrier","mineur"]){
                        $sender->sendMessage(self::prefix." Execute the command §c/class choose <lutin | guerrier | mineur>§r");
                    }else{
                        switch($args[1]){
                            case "lutin":
                                MC::$CLASS[$sender->getName()] = "lutin";
                                $sender->sendMessage(self::prefix." You have choose the class lutin for your party");
                                return;
                            case "guerrier":
                                MC::$CLASS[$sender->getName()] = "guerrier";
                                $sender->sendMessage(self::prefix." You have choose the class guerrier for your party");

                                return;
                            case "mineur":
                                MC::$CLASS[$sender->getName()] = "mineur";
                                $sender->sendMessage(self::prefix." You have choose the class mineur for your party");

                                return;
                        }
                    }
                }
            }
        }
    }
}
