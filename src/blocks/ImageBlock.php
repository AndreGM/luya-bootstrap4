<?php

namespace luya\bootstrap4\blocks;

use luya\cms\base\PhpBlock;
use luya\cms\frontend\blockgroups\MediaGroup;
use luya\cms\helpers\BlockHelper;

/**
 * Image Block.
 *
 * File has been created with `block/create` command.
 */
class ImageBlock extends PhpBlock
{
    /**
     * @var string The module where this block belongs to in order to find the view files.
     */
    public $module = 'bootstrap4';

    /**
     * @var bool Choose whether a block can be cached trough the caching component. Be carefull with caching container blocks.
     */
    public $cacheEnabled = true;
    
    /**
     * @var int The cache lifetime for this block in seconds (3600 = 1 hour), only affects when cacheEnabled is true
     */
    public $cacheExpiration = 3600;

    /**
     * @inheritDoc
     */
    public function blockGroup()
    {
        return MediaGroup::class;
    }

    /**
     * @inheritDoc
     */
    public function name()
    {
        return 'Image';
    }
    
    /**
     * @inheritDoc
     */
    public function icon()
    {
        return 'image'; // see the list of icons on: https://design.google.com/icons/
    }
 
    /**
     * @inheritDoc
     */
    public function config()
    {
        return [
            'vars' => [
                 ['var' => 'image', 'label' => 'Bild', 'type' => self::TYPE_IMAGEUPLOAD, 'options' => ['no_filter' => false]],
                 ['var' => 'align', 'label' => 'Alignment', 'type' => self::TYPE_SELECT, 'options' => BlockHelper::selectArrayOption(['left' => 'Left', 'center' => 'Center', 'right' => 'Right'])],
                 ['var' => 'showCaption', 'label' => 'Show caption', 'type' => self::TYPE_CHECKBOX],
            ],
        ];
    }

    /**
     * @inheritDoc
     */
    public function extraVars()
    {
        return [
            'image' => BlockHelper::imageUpload($this->getVarValue('image'), false, true),
        ];
    }

    /**
     * {@inheritDoc}
     *
     * @param {{extras.image}}
     * @param {{vars.align}}
     * @param {{vars.fluid}}
     * @param {{vars.image}}
    */
    public function admin()
    {
        return '<div class="clearfix" {% if vars.align == \'center\' %}style="text-align: center;"{% endif %}>
                    <div style="display: inline-block; max-width: 80%; {% if vars.align == \'left\' %} float: left;{% elseif vars.align == \'right\' %} float: right;{% endif %}">
                        <div>
                            <img src="{{extras.image.source}}" style="width: 100%; height: auto;" />
                        </div>
                        {% if vars.showCaption and extras.image.caption %}
                            <p style="display: inline-block;"><small>{{extras.image.caption}}</small></p>
                        {% endif %}
                    </div>
                </div>';
    }
}