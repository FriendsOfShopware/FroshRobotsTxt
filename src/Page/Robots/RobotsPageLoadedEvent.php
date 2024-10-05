<?php declare(strict_types=1);

namespace Frosh\RobotsTxt\Page\Robots;

use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Storefront\Page\PageLoadedEvent;
use Symfony\Component\HttpFoundation\Request;

class RobotsPageLoadedEvent extends PageLoadedEvent
{
    public function __construct(
        protected RobotsPage $page,
        SalesChannelContext $salesChannelContext,
        Request $request,
    ) {
        parent::__construct($salesChannelContext, $request);
    }

    public function getPage(): RobotsPage
    {
        return $this->page;
    }
}
