# Image Base64

A simple Twig extension for [Craft CMS](http://buildwithcraft.com) to create base64-encoded strings from Craft [Assets](http://buildwithcraft.com/docs/templating/assetfilemodel) in your Twig templates.

## Installation

1. Download the `.zip` and copy the `Craft-Twig-ImageBase64` directory into your Craft `plugins` directory.
2. Rename the `Craft-Twig-ImageBase64` directory to `imagebase64`.
3. Login to your Craft control panel, navigate to `Plugins` and enable `Image Base 64`.
4. Use the `{{ image64(asset) }}` in your Twig templates to output a base64-encoded string from your Craft Asset.
5. You're done!

## Requirements

This Twig extension requires that you pass an instance of Craft's [`AssetFileModel`](http://buildwithcraft.com/docs/templating/assetfilemodel) in your Twig template.

## Usage

The extension can be used as either a Twig filter or as a Twig extension.

### As a Twig Function

#### With default options

	{{ image64(asset) }}

#### With `inline` set to `true`

	{{ image64(asset, true) }}

This will return the base64-encoded string in a [data URI scheme](http://en.wikipedia.org/wiki/Data_URI_scheme).

### As a Twig Filter

	{{ asset|image64 }}

**Note:** In either case, `asset` must be an instance of Craft's [`AssetFileModel`](http://buildwithcraft.com/docs/templating/assetfilemodel). The extension will die gracefully if anything other than that is passed in as the first parameter.

## Options

### `inline`

**`default = false`**

Setting the `inline` parameter to `true` will return a base64-encoded string as a [data URI scheme](http://en.wikipedia.org/wiki/Data_URI_scheme). Use this option when setting an `<img> src` or `background-image` in CSS.

## Examples

### Inline option set to `false` by default:

	<img src="{{ image64(asset) }}" alt="Rad Dad!">

### As a Twig filter

You can optionally use the extension as a filter instead of a function:

	<img src="{{ asset|image64 }}" alt="Rad Dad!">

### Inline option set to `true`:

	{% for asset in entry.assets %}
		<img src="{{ image64(asset, true) }}" alt="A rad base64-encoded image with a data URI scheme!">
	{% endfor %}

**Note:** In all examples, `asset` must be an instance of Craft's [`AssetFileModel`](http://buildwithcraft.com/docs/templating/assetfilemodel). The extension will die gracefully if anything other than that is passed in as the first parameter.