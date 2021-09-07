<?php declare(strict_types=1);

namespace Frosh\RobotsTxt\Page\Robots;

use Shopware\Core\Framework\Struct\Struct;

class RobotsPage extends Struct
{
    /**
     * @var string[]
     */
    protected array $basePaths;

    /**
     * @var string[]
     */
    protected array $sitemaps;

    /**
     * @return string[]
     */
    public function getBasePaths(): array
    {
        return $this->basePaths;
    }

    /**
     * @param string[] $basePaths
     */
    public function setBasePaths(array $basePaths): void
    {
        $this->basePaths = $basePaths;
    }

    /**
     * @return string[]
     */
    public function getSitemaps(): array
    {
        return $this->sitemaps;
    }

    /**
     * @param string[] $sitemaps
     */
    public function setSitemaps(array $sitemaps): void
    {
        $this->sitemaps = $sitemaps;
    }
}
