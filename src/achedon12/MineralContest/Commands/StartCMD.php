<?php

namespace achedon12\MineralContest\Commands;

use achedon12\MineralContest\MC;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\lang\Translatable;
use pocketmine\player\Player;
use pocketmine\Server;

class StartCMD extends Command{

    public const prefix = "§0[§6Mineral§bContest§0]§r";

    public function __construct(string $name, Translatable|string $description = "", Translatable|string|null $usageMessage = null, array $aliases = []){
        parent::__construct($name, $description, $usageMessage, $aliases);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args){
        if(!$sender instanceof Player){
            $sender->sendMessage("Command to execute in game");
        }else{
            if(!$sender->hasPermission("mc.start") || !Server::getInstance()->isOp($sender->getName())){
                $sender->sendMessage("§eYou don't have this permission to execute this command");
            }else{
                MC::$start = 1;
                Server::getInstance()->broadcastMessage(self::prefix . " Game launching");
                Server::getInstance()->broadcastMessage(self::prefix . " Assiging your team members\nYou will be teleported when the teams have been chosen");
                $players = Server::getInstance()->getOnlinePlayers();
                $count = count($players);
                $a = 0;
                $b = 0;
                $c = 0;
                $d = 0;

                foreach ($players as $index => $player){
                    switch (rand(1,4)){
                        case 1: break;
                        case 2: break;
                        case 3: break;
                        case 4: break;

                    }
                }


                for($i = $count/4;$i<4;$i++){
                    MC::$EQUIPE_A[] = $players[rand(0,$count-1)];
                    MC::$EQUIPE_B[] =
                    MC::$EQUIPE_C[] =
                    MC::$EQUIPE_D[] =
                }
                var_dump(MC::$EQUIPE_A);
                var_dump(MC::$EQUIPE_B);
                var_dump(MC::$EQUIPE_C);
                var_dump(MC::$EQUIPE_D);





            }
        }


    }
}
