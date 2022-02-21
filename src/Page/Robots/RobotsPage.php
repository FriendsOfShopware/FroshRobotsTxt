<?php declare(strict_types=1);

namespace Frosh\RobotsTxt\Page\Robots;

use Frosh\RobotsTxt\Page\Robots\Struct\DomainRuleCollection;
use Shopware\Core\Framework\Struct\Struct;

class RobotsPage extends Struct
{
    protected DomainRuleCollection $domainRules;

    /**
     * @var string[]
     */
    protected array $sitemaps;

    public function getDomainRules(): DomainRuleCollection
    {
        return $this->domainRules;
    }

    public function setDomainRules(DomainRuleCollection $domainRules): void
    {
        $this->domainRules = $domainRules;
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
