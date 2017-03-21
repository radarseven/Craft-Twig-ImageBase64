<?php

/**
 * @package   Image Base 64
 * @author    Michael Reiner
 * @copyright Copyright 2015
 * @link      https://github.com/radarseven/Craft-Twig-ImageBase64
 * @link      https://github.com/Plemi/Twig-extensions
 */

namespace Craft;

class ImageBase64Plugin extends BasePlugin
{

    function getName()
    {
         return Craft::t('Image Base64');
    }

    function getVersion()
    {
        return '0.2.0-beta1';
    }

    function getDeveloper()
    {
        return 'Michael Reiner';
    }

    function getDeveloperUrl()
    {
        return 'https://github.com/Plemi/Twig-extensions';
    }

    function addTwigExtension()
    {
        Craft::import('plugins.imagebase64.twigextensions.ImageBase64TwigExtension');
        return new ImageBase64TwigExtension();
    }

}
