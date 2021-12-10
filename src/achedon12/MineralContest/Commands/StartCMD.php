<?php

namespace achedon12\MineralContest\Commands;

use achedon12\MineralContest\MC;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\lang\Translatable;
use pocketmine\player\Player;
use pocketmine\Server;

class StartCMD extends Command{

    private const prefix = "§0[§6Mineral§bContest§0]§r";

    public function __construct(string $name, Translatable|string $description = "", Translatable|string|null $usageMessage = null, array $aliases = []){
        parent::__construct($name, $description, $usageMessage, $aliases);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args){
        if(!$sender instanceof Player){
            $sender->sendMessage("Command to execute in game");
        }else{
            if(!$sender->hasPermission("mc.op") && !Server::getInstance()->isOp($sender->getName())){
                $sender->sendMessage(self::prefix." §eYou don't have this permission to execute this command");
            }else{
               if(MC::$start == 1){
                   $sender->sendMessage(self::prefix." A game is already launching");
               }else{
                   MC::$start = 1;
                   var_dump(MC::$start);
                   Server::getInstance()->broadcastMessage(self::prefix . " Game launching");
                   Server::getInstance()->broadcastMessage(self::prefix . " Assiging your team members\nYou will be teleported when the teams have been chosen");
                   $players = Server::getInstance()->getOnlinePlayers();
                   $count = count($players);

                   $a = 0;
                   $b = 0;
                   $c = 0;
                   $d = 0;

                   foreach ($players as $player){
                       $rand = rand(1,4);
                       if($rand === 1 && $a < $count/4){
                           $a++;
                           MC::$EQUIPE_A[] = $player;
                           MC::$ALL_EQUIPE[$player->getName()] = "a";
                       }
                       if($rand === 2 && $b < $count/4){
                           $a++;
                           MC::$EQUIPE_B[] = $player;
                           MC::$ALL_EQUIPE[$player->getName()] = "b";
                       }
                       if($rand === 3 && $c < $count/4){
                           $a++;
                           MC::$EQUIPE_C[] = $player;
                           MC::$ALL_EQUIPE[$player->getName()] = "c";
                       }
                       if($rand === 4 && $d < $count/4){
                           $a++;
                           MC::$EQUIPE_D[] = $player;
                           MC::$ALL_EQUIPE[$player->getName()] = "d";
                       }
                   }
               }
            }
        }
    }
}
