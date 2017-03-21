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

    /**
     * The binary.
     * @var bool
     */
    private $binary = false;

    /**
     * Accept either an `AssetFileModel` or a URL.
     * @values ['asset', 'url']
     * @var string
     */
    private $type = false;

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
        // Determine the type of asset.
        if ($asset instanceof AssetFileModel) {
            $this->type = 'asset';
        } else if (strpos($asset, '//', 0) === 0) {
            $this->type = 'url';
        }

        // Die quietly.
        if (!$this->type) {
            return false;
        }

        switch ($this->type) {
            case 'asset':
                // Make sure the mime type is an image.
                if (0 !== strpos($asset->getMimeType(), 'image/')) {
                    // Die quietly.
                    return false;
                }
                $this->binary = file_get_contents($asset->getUrl());
                break;
            case 'url':
                $protocol     = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on" ? 'https' : 'http';
                $url          = $protocol . ':' . $asset;
                $this->binary = file_get_contents($url);
                $asset        = new \SplFileInfo($asset);
                break;
            default:
                return false;
        }

        // Return the string.
        if ($this->binary) {
            return $inline ? sprintf('data:image/%s;base64,%s', $asset->getExtension(), base64_encode($this->binary)) : base64_encode($this->binary);
        } else {
            return false;
        }

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