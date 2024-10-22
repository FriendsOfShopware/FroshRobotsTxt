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

            assert(in_array(mb_strtolower($rule[0]), ['allow', 'disallow'], true));
            assert(isset($rule[1]));
            $path = $this->basePath . '/' . ltrim(trim($rule[1]), '/');
            $this->rules[] = ['type' => ucfirst($rule[0]), 'path' => '/' . ltrim($path, '/')];
        }

    }
}
