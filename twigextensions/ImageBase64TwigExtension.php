<?php

namespace Craft;

/**
 * ImageBase64TwigExtension class
 *
 * @author David Guyon <dguyon@gmail.com>
 * @link http://yoann.aparici.fr/post/18599782775/extension-twig-pour-encoder-les-images-en-base-64
 *
 * @author Michael Reiner [Thanks to David, he did all the work! Just converting for use as a Craft CMS plugin.]
 * @link http://mreiner.me
 */
class ImageBase64TwigExtension extends \Twig_Extension
{

    public function initRuntime(\Twig_Environment $env)
    {
        $this->env = $env;
    }

    public function getFilters()
    {
        return array(
            'image64' => new \Twig_Filter_Method($this, 'image64'),
        );
    }

    public function getFunctions()
    {
        return array(
            'image64' => new \Twig_Function_Method($this, 'image64'),
        );
    }

    /**
     * Return a base 64 encoded string only from image content type
     * Must be a Craft AssetFileModel
     *
     * @param  string $path Path to image
     * @return string
     */
    public function image64($asset, $inline = false)
    {
        // Require an instance of `AssetFileModel` and an image
        if ($asset instanceof AssetFileModel && 0 === strpos($asset->getMimeType(), 'image/'))
        {
            // Get the file.
            $binary = file_get_contents($asset->getUrl());
        }
        // Or, ensure the mime type is an image.
        else if (0 === strpos(mime_content_type($asset), 'image/'))
        {
            $binary = file_get_contents($asset);
            $asset = new \SplFileInfo($asset);
        }
        else
        {
            // Die quietly.
            return false;
        }

        // Return the string.
        return $inline ? sprintf('data:image/%s;base64,%s', $asset->getExtension(), base64_encode($binary)) : base64_encode($binary);
    }

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getName()
    {
        return 'Image Base64 Extension';
    }
}