<?php declare(strict_types=1);

namespace Frosh\RobotsTxt\Page\Robots\Struct;

use Shopware\Core\Framework\Struct\Collection;

/**
 * @extends Collection<DomainRuleStruct>
 */
class DomainRuleCollection extends Collection
{
    protected function getExpectedClass(): string
    {
        return DomainRuleStruct::class;
    }
}
