<?php

namespace achedon12\MineralContest\Task;

use achedon12\MineralContest\MC;
use pocketmine\scheduler\Task;

class ChestTask extends Task{

    private const prefix = "§0[§6Mineral§bContest§0]§r";
    private $cfg;

    public function __construct(){
        $this->cfg = MC::getConfigs();
    }

    public function onRun(): void
    {
        if(MC::$start == 1){
            $x = $this->cfg->getNested("Coffre.x");
            $y = $this->cfg->getNested("Coffre.y");
            $z = $this->cfg->getNested("Coffre.z");

        }
    }
}