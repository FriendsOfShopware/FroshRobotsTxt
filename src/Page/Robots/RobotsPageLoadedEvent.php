<?php declare(strict_types=1);

namespace Frosh\RobotsTxt\Page\Robots;

use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Storefront\Page\PageLoadedEvent;
use Symfony\Component\HttpFoundation\Request;

class RobotsPageLoadedEvent extends PageLoadedEvent
{
    protected RobotsPage $page;

    public function __construct(RobotsPage $page, SalesChannelContext $salesChannelContext, Request $request)
    {
        $this->page = $page;
        parent::__construct($salesChannelContext, $request);
    }

    public function getPage(): RobotsPage
    {
        return $this->page;
    }
}
