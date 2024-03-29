<?php

declare(strict_types=1);

namespace tomtomsen\ProjectEuler\ProblemFinder;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ReflectionClass;
use tomtomsen\ProjectEuler\Problem;

final class FilesystemProblemFinder implements ProblemFinder
{
    /** @var string */
    private $directory;

    public function __construct(string $directory)
    {
        $this->directory = $directory;
    }

    public function find() : array
    {
        $problems = [];

        $it = new RecursiveDirectoryIterator($this->directory);

        /** @var \SplFileInfo $file */
        foreach (new RecursiveIteratorIterator($it) as $file) {
            if ($file->isFile() && 'php' === $file->getExtension()) {
                $preDeclaredClasses = \get_declared_classes();

                /** @psalm-suppress UnresolvableInclude */
                require_once $file->getRealPath();
                $postDeclaredClasses = \get_declared_classes();

                $newlyDeclaredClasses = \array_diff($postDeclaredClasses, $preDeclaredClasses);

                foreach ($newlyDeclaredClasses as $className) {
                    try {
                        $reflection = new ReflectionClass($className);

                        if ($reflection->isSubclassOf(Problem::class)) {
                            /** @var Problem $problem */
                            $problem = $reflection->newInstance();
                            $problems[] = $problem;
                        }
                    } catch (\ReflectionException $e) {
                        throw $e;
                    }
                }
            }
        }

        return $problems;
    }
}
