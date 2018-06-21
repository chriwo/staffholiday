<?php
namespace ChriWo\Staffholiday\Utility;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Fluid\View\StandaloneView;

/**
 * This file is part of the "staffholiday" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

/**
 * Class TemplateUtility.
 */
class TemplateUtility extends AbstractUtility
{
    /**
     * Get absolute path for templates with fallback. In case of multiple paths this will just return the first one.
     * See getTemplateFolders() for an array of paths.
     * @param string $part "template", "partial", "layout"
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     * @return string
     * @see getTemplateFolders()
     */
    public static function getTemplateFolder($part = 'template')
    {
        $matches = self::getTemplateFolders($part);

        return !empty($matches) ? $matches[0] : '';
    }

    /**
     * Get absolute paths for templates with fallback. Returns paths from *RootPaths and *RootPath and "hardcoded" paths
     * pointing to the EXT:staffholiday-resources.
     *
     * @param string $part "template", "partial", "layout"
     * @param bool $returnAllPaths Default: FALSE, If FALSE only paths
     *        for the first configuration (Paths, Path, hardcoded)
     *        will be returned. If TRUE all (possible) paths will be returned.
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     * @return array
     */
    public static function getTemplateFolders($part = 'template', $returnAllPaths = false)
    {
        $templatePaths = [];
        $configuration = self::getConfigurationManager()
            ->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
        if (!empty($configuration['view'][$part . 'RootPaths'])) {
            $templatePaths = $configuration['view'][$part . 'RootPaths'];
            $templatePaths = array_values($templatePaths);
        }
        if ($returnAllPaths || empty($templatePaths)) {
            $path = $configuration['view'][$part . 'RootPath'];
            if (!empty($path)) {
                $templatePaths[] = $path;
            }
        }
        if ($returnAllPaths || empty($templatePaths)) {
            $templatePaths[] = 'EXT:staffholiday/Resources/Private/' . ucfirst($part) . 's/';
        }
        $templatePaths = array_unique($templatePaths);
        $absolutePaths = [];
        foreach ($templatePaths as $templatePath) {
            $absolutePaths[] = GeneralUtility::getFileAbsFileName($templatePath);
        }

        return $absolutePaths;
    }

    /**
     * Return path and filename for a file or path. Only the first existing file/path will be returned.
     * Respect *RootPaths and *RootPath.
     *
     * @param string $pathAndFilename e.g. Email/Name.html
     * @param string $part "template", "partial", "layout"
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     * @return string Filename/path
     */
    public static function getTemplatePath($pathAndFilename, $part = 'template')
    {
        $matches = self::getTemplatePaths($pathAndFilename, $part);

        return !empty($matches) ? end($matches) : '';
    }

    /**
     * Return path and filename for one or many files/paths. Only existing files/paths will be returned.
     * Respect *RootPaths and *RootPath.
     *
     * @param string $pathAndFilename Path/filename (Email/Name.html) or path
     * @param string $part "template", "partial", "layout"
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     * @return array All existing matches found
     */
    public static function getTemplatePaths($pathAndFilename, $part = 'template')
    {
        $pathAndFilenames = [];
        $absolutePaths = self::getTemplateFolders($part, true);
        foreach ($absolutePaths as $absolutePath) {
            if (file_exists($absolutePath . $pathAndFilename)) {
                $pathAndFilenames[] = $absolutePath . $pathAndFilename;
            }
        }

        return $pathAndFilenames;
    }

    /**
     * Get standaloneview with default properties.
     *
     * @param string $controllerName
     * @param string $extensionName
     * @param string $pluginName
     * @param string $format
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\InvalidControllerNameException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\InvalidExtensionNameException
     * @return StandaloneView
     */
    public static function getDefaultStandAloneView(
        $controllerName = 'New',
        $extensionName = 'Staffholiday',
        $pluginName = 'Pi1',
        $format = 'html'
    ) {
        /** @var StandaloneView $standAloneView */
        $standAloneView = self::getObjectManager()->get(StandaloneView::class);
        $standAloneView->getRequest()->setControllerExtensionName($extensionName);
        $standAloneView->getRequest()->setPluginName($pluginName);
        $standAloneView->getRequest()->setControllerName($controllerName);
        $standAloneView->setFormat($format);
        $standAloneView->setLayoutRootPaths(self::getTemplateFolders('layout'));
        $standAloneView->setPartialRootPaths(self::getTemplateFolders('partial'));

        return $standAloneView;
    }
}
