<?php

namespace achedon12\MineralContest\Commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\lang\Translatable;
use pocketmine\player\Player;

class Scenario extends Command{

    public function __construct(string $name, Translatable|string $description = "", Translatable|string|null $usageMessage = null, array $aliases = []){
        parent::__construct($name, $description, $usageMessage, $aliases);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args){
        if(!$sender instanceof Player){
            $sender->sendMessage("Command to execut in game");
        }else{
            $sender->sendMessage(" §6-- ----§0[§bMineralContest§0]§6---- --§r\n\n§4Plugin Made By achedon12\n§2✔ Contact: achedon12#0034\n§6Private plugin created with ❤");
        }
    }
}