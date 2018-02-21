<?php
/**
 * @author Dmitriy Lezhnev <lezhnev.work@gmail.com>
 * Date: 21/02/2018
 */
declare(strict_types=1);


namespace SignupForm\Filesystem;


interface FilesystemInterface
{
    function moveToPublic(string $targetRelativePath, string $sourceFullPath): string;

    function removeFromPublic(string $relativePath): void;
}