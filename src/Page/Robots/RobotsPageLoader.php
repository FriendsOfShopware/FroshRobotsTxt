<?php declare(strict_types=1);

namespace Frosh\RobotsTxt\Page\Robots;

use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Exception\InconsistentCriteriaIdsException;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\ContainsFilter;
use Shopware\Core\System\SalesChannel\Aggregate\SalesChannelDomain\SalesChannelDomainCollection;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;

class RobotsPageLoader
{
    private EventDispatcherInterface $eventDispatcher;
    private EntityRepositoryInterface $domainRepository;

    public function __construct(
        EventDispatcherInterface $eventDispatcher,
        EntityRepositoryInterface $domainRepository
    ) {
        $this->eventDispatcher = $eventDispatcher;
        $this->domainRepository = $domainRepository;
    }

    /**
     * @throws InconsistentCriteriaIdsException
     */
    public function load(Request $request, SalesChannelContext $context): RobotsPage
    {
        $page = new RobotsPage();

        // TODO: Handle empty hostname?
        $hostname = $request->server->get('HTTP_HOST');
        $domains = $this->getDomains($hostname, $context->getContext());

        $page->setBasePaths($this->getBasePaths($hostname, $domains));
        $page->setSitemaps($this->getSitemaps($domains));

        $this->eventDispatcher->dispatch(
            new RobotsPageLoadedEvent($page, $context, $request)
        );

        return $page;
    }

    private function getDomains(string $hostname, Context $context): SalesChannelDomainCollection
    {
        $criteria = new Criteria();
        $criteria->addFilter(new ContainsFilter('url', $hostname));

        return $this->domainRepository->search($criteria, $context)->getEntities();
    }

    /**
     * @return string[]
     */
    private function getBasePaths(string $hostname, SalesChannelDomainCollection $domains): array
    {
        $basePaths = [];
        foreach ($domains as $domain) {
            $domainPath = explode($hostname, $domain->getUrl(), 2);

            // Should never happen, but you never know...
            if (empty($domainPath[1])) {
                continue;
            }

            $basePaths[] = $domainPath[1];
        }

        return $basePaths;
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
