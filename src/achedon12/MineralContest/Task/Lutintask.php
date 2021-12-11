<?php

namespace achedon12\MineralContest\Task;

use achedon12\MineralContest\MC;
use pocketmine\player\Player;
use pocketmine\scheduler\Task;

class Lutintask extends Task{

    private $time = 10;
    private $joueur;
    private const prefix = "§0[§6Mineral§bContest§0]§r";

    public function __construct(Player $player){
        $this->joueur = $player;
        $this->joueur->sendMessage(self::prefix." You are now invisible");
    }

    public function onRun(): void{
        if($this->time == 0){
            $this->joueur->setInvisible(false);
            $this->joueur->sendMessage(self::prefix." You are no longer invisible");
            $this->getHandler()->cancel();
        }else{
            $this->joueur->setInvisible(true);
        }
        $this->time--;
    }
}