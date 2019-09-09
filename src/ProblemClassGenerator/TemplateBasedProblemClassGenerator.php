<?php

declare(strict_types=1);

namespace tomtomsen\ProjectEuler\ProblemClassGenerator;

use tomtomsen\ProjectEuler\Problem;

final class TemplateBasedProblemClassGenerator implements ProblemClassGenerator
{
    public function generate(Problem $problem) : string
    {
        $fileName = __DIR__ . '/ProblemClass.tpl.dist';
        $tpl = \file_get_contents($fileName);

        if (false === $tpl) {
            throw new \RuntimeException('couldnt load template ' . $fileName);
        }

        /** @phan-suppress-next-line PhanParamSuspiciousOrder */
        return \strtr(
            $tpl,
            [
                '{number}' => $problem->number(),
                '{name}' => \strtr($problem->name(), ['\'' => '\\\'']),
                '{className}' => \preg_replace('~ ~', '', $problem->name()),
                '{description}' => \strtr(
                    \trim(
                        $problem->description(),
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
