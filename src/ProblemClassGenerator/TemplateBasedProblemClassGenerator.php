<?php

declare(strict_types=1);

namespace tomtomsen\ProjectEuler\ProblemClassGenerator;

final class TemplateBasedProblemClassGenerator implements ProblemClassGenerator
{
    public function generate(int $number, string $name, string $description = '') : string
    {
        $fileName = __DIR__ . '/ProblemClass.tpl.dist';
        $tpl = \file_get_contents($fileName);

        if (!$tpl) {
            throw new \RuntimeException('couldnt load template ' . $fileName);
        }

        /** @phan-suppress-next-line PhanParamSuspiciousOrder */
        return \strtr(
            $tpl,
            [
                '{number}' => $number,
                '{name}' => \strtr($name, ['\'' => '\\\'']),
                '{className}' => \preg_replace('~ ~', '', $name),
                '{description}' => \strtr(
                    \trim(
                        $description,
                        "\n\r "
                        ),
                    [
                        \PHP_EOL => \PHP_EOL . '            ',
                    ]
                    ),
            ]
        );
    }
}
