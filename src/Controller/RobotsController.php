<?php declare(strict_types=1);

namespace Frosh\RobotsTxt\Controller;

use Frosh\RobotsTxt\Page\Robots\RobotsPageLoader;
use Shopware\Core\Framework\Routing\Annotation\RouteScope;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Storefront\Controller\StorefrontController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @RouteScope(scopes={"storefront"})
 */
class RobotsController extends StorefrontController
{
    private RobotsPageLoader $robotsPageLoader;

    public function __construct(RobotsPageLoader $robotsPageLoader)
    {
        $this->robotsPageLoader = $robotsPageLoader;
    }

    /**
     * @Route("/robots.txt", name="frontend.robots.txt", methods={"GET"}, defaults={"_format"="txt"})
     */
    public function robotsTxt(SalesChannelContext $context, Request $request): Response
    {
        $page = $this->robotsPageLoader->load($request, $context);

        $response = $this->renderStorefront('@FroshRobotsTxt/page/robots/robots.txt.twig', ['page' => $page]);
        $response->headers->set('content-type', 'text/plain; charset=utf-8');

        return $response;
    }
}
