<?php declare(strict_types=1);

namespace Frosh\RobotsTxt\Core\Framework\Adapter\Twig\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class LeadingSpacesFilterExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('remove_leading_spaces', [$this, 'removeLeadingSpaces'], ['is_safe' => ['all']]),
        ];
    }

    public function removeLeadingSpaces(string $content): string
    {
        $contentStripped = preg_replace('/^ +/m', '', $content);

        if ($contentStripped !== null) {
            return trim($contentStripped);
        }

        return $content;
    }
}
