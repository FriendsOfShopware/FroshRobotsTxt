<?php declare(strict_types=1);

namespace Frosh\RobotsTxt\Page\Robots\Struct;

use Shopware\Core\Framework\Struct\Struct;

class DomainRuleStruct extends Struct
{
    /**
     * @var array<array{type: string, path: string}>
     */
    private array $rules;

    public function __construct(string $rules, private readonly string $basePath)
    {
        $this->parseRules($rules);
    }

    /**
     * @return array<array{type: string, path: string}>
     */
    public function getRules(): array
    {
        return $this->rules;
    }

    public function getBasePath(): string
    {
        return $this->basePath;
    }

    private function parseRules(string $rules): void
    {
        $rules = explode("\n", $rules);

        foreach ($rules as $rule) {
            $rule = explode(':', $rule, 2);

            $ruleType = mb_strtolower($rule[0] ?? '');
            $path = trim($rule[1] ?? '');

            if (!in_array($ruleType, ['allow', 'disallow'], true) || $path === '') {
                continue;
            }

            $path = $this->basePath . '/' . ltrim($path, '/');
            $this->rules[] = ['type' => ucfirst($ruleType), 'path' => '/' . ltrim($path, '/')];
        }
    }
}
