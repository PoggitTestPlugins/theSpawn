<?php


namespace supercrafter333\theSpawn\Others;


use pocketmine\world\World;
use pocketmine\player\Player;
use pocketmine\utils\Config;
use supercrafter333\theSpawn\theSpawn;

/**
 * Class HomeInfo
 * @package supercrafter333\theSpawn\Others
 */
class HomeInfo
{
    #####################################################
    ########All other functions in class theSpawn########
    #####################################################

    /**
     * @var Player
     */
    public Player $player;
    /**
     * @var string
     */
    public string $homeName;

    /**
     * HomeInfo constructor.
     * @param Player $player
     * @param string $homeName
     */
    public function __construct(Player $player, string $homeName)
    {
        $this->player = $player;
        $this->homeName = $homeName;
    }

    /**
     * @return Config
     */
    public function getHomeCfg(): Config
    {
        return new Config(theSpawn::getInstance()->getDataFolder() . "homes/" . $this->player->getName() . ".yml", Config::YAML);
    }

    /**
     * @return bool
     */
    public function existsHome(): bool
    {
        return $this->getHomeCfg()->exists($this->homeName);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        if ($this->existsHome() == true) {
            return $this->getHomeCfg()->get($this->homeName)["homeName"];
        }
        return "";
    }

    /**
     * @return mixed
     */
    public function getX(): mixed
    {
        if ($this->existsHome() == true) {
            return $this->getHomeCfg()->get($this->homeName)["X"];
        }
        return false;
    }

    /**
     * @return mixed
     */
    public function getY(): mixed
    {
        if ($this->existsHome() == true) {
            return $this->getHomeCfg()->get($this->homeName)["Y"];
        }
        return false;
    }

    /**
     * @return mixed
     */
    public function getZ(): mixed
    {
        if ($this->existsHome() == true) {
            return $this->getHomeCfg()->get($this->homeName)["Z"];
        }
        return false;
    }

    /**
     * @return mixed
     */
    public function getLevelName(): mixed
    {
        if ($this->existsHome() == true) {
            return $this->getHomeCfg()->get($this->homeName)["level"];
        }
        return false;
    }

    /**
     * @return false|World|null
     */
    public function getLevel()
    {
        if ($this->existsHome() == true) {
            $lvlName = $this->getHomeCfg()->get($this->homeName)["level"];
            if (theSpawn::getInstance()->getServer()->getWorldManager()->isWorldGenerated($lvlName) && theSpawn::getInstance()->getServer()->getWorldManager()->isWorldLoaded($lvlName)) {
                return theSpawn::getInstance()->getServer()->getWorldManager()->getWorldByName($lvlName);
            } elseif (theSpawn::getInstance()->getServer()->getWorldManager()->isWorldGenerated($lvlName)) {
                theSpawn::getInstance()->getServer()->getWorldManager()->loadWorld($lvlName);
                return theSpawn::getInstance()->getServer()->getWorldManager()->getWorldByName($lvlName);
            }
            return false;
        }
        return false;
    }
    #####################################################
    ########All other functions in class theSpawn########
    #####################################################
}