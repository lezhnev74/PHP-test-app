<?php
/**
 * @author Dmitriy Lezhnev <lezhnev.work@gmail.com>
 * Date: 21/02/2018
 */
declare(strict_types=1);


namespace SignupForm\Filesystem;


use Assert\Assert;

class Filesystem implements FilesystemInterface
{
    /** @var string */
    private $public_path;

    /**
     * Filesystem constructor.
     * @param string $public_path
     */
    public function __construct(string $public_path)
    {
        Assert::that($public_path)->writeable();
        $this->public_path = $public_path;
    }

    function moveToPublic(string $targetRelativePath, string $sourceFullPath): string
    {
        // Make dir of none
        $newFullPath = $this->public_path . DIRECTORY_SEPARATOR . $targetRelativePath;
        $folder      = dirname($newFullPath);
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }

        copy($sourceFullPath, $newFullPath);

        return $newFullPath;
    }

    function removeFromPublic(string $relativePath): void
    {
        @unlink($this->public_path . DIRECTORY_SEPARATOR . $relativePath);
    }

}