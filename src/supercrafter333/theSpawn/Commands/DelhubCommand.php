<?php

namespace supercrafter333\theSpawn\Commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\world\sound\GhastShootSound;
use pocketmine\player\Player;
use pocketmine\plugin\Plugin;
use pocketmine\utils\Config;
use supercrafter333\theSpawn\MsgMgr;
use supercrafter333\theSpawn\theSpawn;

/**
 * Class DelhubCommand
 * @package supercrafter333\theSpawn\Commands
 */
class DelhubCommand extends Command
{

    /**
     * @var theSpawn
     */
    private theSpawn $plugin;

    /**
     * DelhubCommand constructor.
     * @param string $name
     * @param string $description
     * @param string|null $usageMessage
     * @param array $aliases
     */
    public function __construct(string $name, string $description = "", string $usageMessage = null, array $aliases = [])
    {
        $this->plugin = theSpawn::getInstance();
        $this->setPermission("theSpawn.delhub.cmd");
        parent::__construct("delhub", "Delete the hub/lobby of this server!", "/delhub [randdomHubs: number|int]", ["dellobby", "rmhub", "rmlobby", "delthehub"]);
    }

    /**
     * @param CommandSender $s
     * @param string $commandLabel
     * @param array $args
     * @return bool
     */
    public function execute(CommandSender $s, string $commandLabel, array $args): bool
    {
        $prefix = theSpawn::$prefix;
        $pl = theSpawn::getInstance();
        $spawn = new Config($pl->getDataFolder() . "theSpawns.yml", Config::YAML);
        $hub = new Config($pl->getDataFolder() . "theHub.yml", Config::YAML);
        $msgs = MsgMgr::getMsgs();
        $config = $pl->getConfig();
        #########################
        if ($s instanceof Player) {
            if ($s->hasPermission("theSpawn.delhub.cmd")) {
                if ($pl->getUseRandomHubs()) {
                    if (!count($args) >= 1) {
                        $s->sendMessage($this->usageMessage);
                        return true;
                    }
                    if (!$pl->checkSetRandomHub($args[0])) {
                        $s->sendMessage($prefix . MsgMgr::getMsg("remove-random-hub-before"));
                        return true;
                    }
                    $pl->removeHub($args[0]);
                    $s->sendMessage($prefix . MsgMgr::getMsg("hub-removed"));
                    $s->getWorld()->addSound($s->getPosition(), new GhastShootSound());
                    return true;
                }
                if ($hub->exists("hub")) {
                    $pl->removeHub();
                    $s->sendMessage($prefix . MsgMgr::getMsg("hub-removed"));
                    $s->getWorld()->addSound($s->getPosition(), new GhastShootSound());
                    return true;
                } else {
                    $s->sendMessage($prefix . MsgMgr::getMsg("no-hub-set"));
                }
            } else {
                $s->sendMessage($prefix . MsgMgr::getNoPermMsg());
            }
        } else {
            $s->sendMessage(MsgMgr::getOnlyIGMsg());
            return true;
        }
        return true;
    }

    /**
     * @return Plugin
     */
    public function getPlugin(): Plugin
    {
        return $this->plugin;
    }
}