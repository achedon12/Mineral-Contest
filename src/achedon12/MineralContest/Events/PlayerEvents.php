<?php

namespace achedon12\MineralContest\Events;

use achedon12\MineralContest\MC;
use achedon12\MineralContest\Task\Lutintask;
use pocketmine\block\BlockFactory;
use pocketmine\data\bedrock\EnchantmentIds;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerDropItemEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\enchantment\StringToEnchantmentParser;
use pocketmine\item\enchantment\VanillaEnchantments;
use pocketmine\item\Item;
use pocketmine\item\ItemFactory;
use pocketmine\network\mcpe\protocol\types\Enchant;
use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\world\Position;

class PlayerEvents implements Listener{

    private const prefix = "§0[§6Mineral§bContest§0]§r";
    private const Team_prefix = "§b[§cTeam§b]§r";

    public function onEntityDamageEvent(EntityDamageEvent $event){
        $player = $event->getEntity();
        if($player instanceof Player){
            $cfg = MC::getConfigs();

            $event->cancel();
            $player->setHealth(20);
            if(MC::$start == 1){
                $equipe = MC::getEquipe($player);
                $x = $cfg->getNested("Equipe.$equipe.x");
                $y = $cfg->getNested("Equipe.$equipe.y");
                $z = $cfg->getNested("Equipe.$equipe.z");

                foreach ($player->getInventory()->getContents() as $index => $items){
                    if($items->getCustomName() == "ClassTools"){
                        $player->getInventory()->setItem($index,ItemFactory::air());
                        continue;
                    }
                    $player->getWorld()->dropItem($player->getPosition(),$items,null);
                    $player->getInventory()->setItem($index,ItemFactory::air());
                }



                $class = MC::getMetier($player);
                $life = $cfg->getNested("Class.$class.life");
                $item = $cfg->getNested("Class.$class.items");
                $Item = explode(":",$item);
                $ItemID = $Item[0];
                $ItemMETA = $Item[1];

                $newItem = ItemFactory::getInstance()->get($ItemID,$ItemMETA,1);

                if(MC::getMetier($player) == "guerrier"){
                    $newItem->addEnchantment(new EnchantmentInstance(VanillaEnchantments::SHARPNESS(),1));
                }elseif(MC::getMetier($player) == "mineur"){
                    $newItem->addEnchantment(new EnchantmentInstance(VanillaEnchantments::EFFICIENCY(),1));
                }

                $newItem->setCustomName("ClassTools");
                $player->getInventory()->addItem($newItem);
                $player->setMaxHealth($life);


                $world = Server::getInstance()->getWorldManager()->getWorldByName($cfg->get("World"));
                $player->teleport(new Position($x,$y,$z,$world));
                Server::getInstance()->broadcastMessage(self::prefix." ".$player->getName()." is dead");
            }else{
                $player->teleport(Server::getInstance()->getWorldManager()->getWorldByName("world")->getSafeSpawn());
                Server::getInstance()->broadcastMessage(self::prefix." ".$player->getName()." is dead");
            }
        }
    }

    public function onDrop(PlayerDropItemEvent $event){

        $item = $event->getItem();
        $player = $event->getPlayer();
        if($item->getCustomName() == "ClassTools"){
            $event->cancel();
        }
    }

    public function onChat(PlayerChatEvent $event){
        $event->cancel();
        $msg = $event->getMessage();
        if(MC::$start == 1) {
            $equipe = MC::$ALL_EQUIPE[$event->getPlayer()->getName()];
            if (strpos($event->getMessage(), "!") === false) {
                switch ($equipe) {
                    case "a":
                        foreach (MC::$EQUIPE_A as $player) {
                            if ($player->isConnected()) {
                                $player->sendMessage(self::Team_prefix . " " . $player->getName() . " §6»§r " . $event->getMessage());
                            }
                        }
                        return;
                    case "b":
                        foreach (MC::$EQUIPE_B as $player) {
                            if ($player->isConnected()) {
                                $player->sendMessage(self::Team_prefix . " " . $player->getName() . " §6»§r " . $event->getMessage());
                            }
                        }
                        return;
                    case "c":
                        foreach (MC::$EQUIPE_C as $player) {
                            if ($player->isConnected()) {
                                $player->sendMessage(self::Team_prefix . " " . $player->getName() . " §6»§r " . $event->getMessage());
                            }
                        }
                        return;
                    case "d":
                        foreach (MC::$EQUIPE_D as $player) {
                            if ($player->isConnected()) {
                                $player->sendMessage(self::Team_prefix . " " . $player->getName() . " §6»§r " . $event->getMessage());
                            }
                        }
                        return;
                }
            } else {
                Server::getInstance()->broadcastMessage($event->getPlayer()->getName() . " §6»§r " .substr($msg,1));
            }
        }else{
            Server::getInstance()->broadcastMessage($event->getPlayer()->getName(). " §6»§r ". $msg);
        }
    }

    public function onInteract(PlayerInteractEvent $event){
        $item = $event->getItem();
        $player = $event->getPlayer();
        $cooldown = 120;

        if($item->getId() == 347 && $item->getMeta() == 0){
            if(!isset(MC::$COOLDOWN[$player->getName()])){
                MC::$COOLDOWN[$player->getName()] = time() + $cooldown;
                MC::getInstance()->getScheduler()->scheduleRepeatingTask(new Lutintask($player),10);
            }else{
                if(MC::$COOLDOWN[$player->getName()] > time()){
                    $remaining = MC::$COOLDOWN[$player->getName()] - time();
                    $player->sendMessage(self::prefix." You have to wait §d$remaining s §rbefore to use this command again");
                }else{
                    unset(MC::$COOLDOWN[$player->getName()]);
                }
            }
        }
    }

    public function onBreak(BlockBreakEvent $event){
        $block = $event->getBlock();
        $player = $event->getPlayer();
        $class = ["mineur","lutin","guerrier"];

        $cfg = MC::getConfigs();
        if (MC::$start == 1) {

            if (!empty(MC::$CLASS[$player->getName()])){

                switch ($block->getId()) {
                    case 15: //fer
                        $event->setDrops([ItemFactory::getInstance()->get(265, 0, 1)]); // lingot de fer
                        break;
                    case 14: //or
                        $event->setDrops([ItemFactory::getInstance()->get(266, 0, 1)]); // lingot d'or
                        break;
                    case 56: //diamand
                        $event->setDrops([ItemFactory::getInstance()->get(264, 0, 1)]); // diamond
                        break;
                    case 129: //emeraude
                        $event->setDrops([ItemFactory::getInstance()->get(388, 0, 1)]); // emeraude
                        break;
                }
            }
        }

        $x = [$cfg->getNested("Equipe.a.base.x"),$cfg->getNested("Equipe.b.base.x"),$cfg->getNested("Equipe.c.base.x"),$cfg->getNested("Equipe.d.base.x")];
        $y = [$cfg->getNested("Equipe.a.base.y"),$cfg->getNested("Equipe.b.base.y"),$cfg->getNested("Equipe.c.base.y"),$cfg->getNested("Equipe.d.base.y")];
        $z = [$cfg->getNested("Equipe.a.base.z"),$cfg->getNested("Equipe.b.base.z"),$cfg->getNested("Equipe.c.base.z"),$cfg->getNested("Equipe.d.base.z")];

        if(!Server::getInstance()->isOp($player->getName()) && $player->getPosition()->getX() == $x && $player->getPosition()->getY() == $y && $player->getPosition()->getZ() == $z){
            $event->cancel();
            $player->sendMessage(self::prefix." You can not break block in this area");
        }
    }
}