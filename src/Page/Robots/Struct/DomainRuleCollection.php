<?php declare(strict_types=1);

namespace Frosh\RobotsTxt\Page\Robots\Struct;

use Shopware\Core\Framework\Struct\Collection;

/**
 * @method void add(DomainRuleStruct $domainRule)
 * @method void set(string $key, DomainRuleStruct $domainRule)
 * @method DomainRuleStruct[] getIterator()
 * @method DomainRuleStruct[] getElements()
 * @method DomainRuleStruct|null get(string $key)
 * @method DomainRuleStruct|null first()
 * @method DomainRuleStruct|null last()
 */
class DomainRuleCollection extends Collection
{
    protected function getExpectedClass(): string
    {
        return DomainRuleStruct::class;
    }
}
