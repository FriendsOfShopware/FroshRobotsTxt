<?php declare(strict_types=1);

namespace Frosh\RobotsTxt\Page\Robots;

use Frosh\RobotsTxt\Page\Robots\Struct\DomainRuleCollection;
use Frosh\RobotsTxt\Page\Robots\Struct\DomainRuleStruct;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Exception\InconsistentCriteriaIdsException;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\ContainsFilter;
use Shopware\Core\System\SalesChannel\Aggregate\SalesChannelDomain\SalesChannelDomainCollection;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Core\System\SystemConfig\SystemConfigService;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;

class RobotsPageLoader
{
    private EventDispatcherInterface $eventDispatcher;
    private EntityRepositoryInterface $domainRepository;
    private SystemConfigService $systemConfigService;

    public function __construct(
        EventDispatcherInterface $eventDispatcher,
        EntityRepositoryInterface $domainRepository,
        SystemConfigService $systemConfigService
    ) {
        $this->eventDispatcher = $eventDispatcher;
        $this->domainRepository = $domainRepository;
        $this->systemConfigService = $systemConfigService;
    }

    /**
     * @throws InconsistentCriteriaIdsException
     */
    public function load(Request $request, SalesChannelContext $context): RobotsPage
    {
        $page = new RobotsPage();

        $hostname = $request->server->get('HTTP_HOST');

        if (is_string($hostname) && $hostname !== '') {
            $domains = $this->getDomains($hostname, $context->getContext());

            $page->setDomainRules($this->getDomainRules($hostname, $domains));
            $page->setSitemaps($this->getSitemaps($domains));
        }

        $this->eventDispatcher->dispatch(
            new RobotsPageLoadedEvent($page, $context, $request)
        );

        return $page;
    }

    private function getDomains(string $hostname, Context $context): SalesChannelDomainCollection
    {
        $criteria = new Criteria();
        $criteria->addFilter(new ContainsFilter('url', $hostname));

        $domains = $this->domainRepository->search($criteria, $context)->getEntities();
        assert($domains instanceof SalesChannelDomainCollection);

        return $domains;
    }

    private function getDomainRules(string $hostname, SalesChannelDomainCollection $domains): DomainRuleCollection
    {
        $domainRuleCollection = new DomainRuleCollection();
        foreach ($domains as $domain) {
            $domainPath = explode($hostname, $domain->getUrl(), 2);

            // Should never happen, but you never know...
            assert($domainPath && isset($domainPath[1]));

            $domainRuleCollection->add(new DomainRuleStruct(
                trim($this->systemConfigService->getString('FroshRobotsTxt.config.rules', $domain->getSalesChannelId())),
                trim($domainPath[1])
            ));
        }

        return $domainRuleCollection;
    }

    /**
     * @return string[]
     */
    private function getSitemaps(SalesChannelDomainCollection $domains): array
    {
        $sitemaps = [];

        foreach ($domains as $domain) {
            $sitemaps[] = $domain->getUrl() . '/sitemap.xml';
        }

        return $sitemaps;
    }
}
