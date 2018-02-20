<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2018 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko <vladislavdolgolenko.com>
 * @support      support@torbara.com
 */

namespace WPObjects\VC\AddonPreset;

if (!class_exists('WP_Customize_Control')) {
    require ABSPATH . WPINC . '/class-wp-customize-control.php';
}

class CustomizerControle extends \WP_Customize_Control implements
    \WPObjects\AssetsManager\AssetsManagerInterface
{
    public $type = 'vc-addons-customizer-presets-constrole';
    
    /**
     * @var \WPObjects\AssetsManager\AssetsManager
     */
    protected $AssetsManager = null;
    
    protected $Addon = null;

    public function __construct( $manager, $id, $args, \WPObjects\VC\CustomAddonModel $Addon)
    {
        parent::__construct($manager, $id, $args);
        $this->Addon = $Addon;
    }

    public function enqueue()
    {
        if (!$this->getAssetsManager() instanceof \WPObjects\AssetsManager\AssetsManager) {
            throw new \Exception('Undefined AssetsManager');
        }
        
        $this->getAssetsManager()->enqueueStyle('bootstrap-wrapper');
        $this->getAssetsManager()->enqueueStyle('vc-addons-customizer-presets-constrole');
        $this->getAssetsManager()->enqueueScript('vc-addons-customizer-presets-constrole');
    }

    public function to_json()
    {
        parent::to_json();
        //$this->json['label'] = html_entity_decode( $this->label, ENT_QUOTES, get_bloginfo( 'charset' ) );
    }

    public function render_content()
    {
        $Presets = $this->getAddon()->getPresets();
        
        ?>
            <div class="wpobjects-bootstrap-wrapper js-vc-addons-customizer-presets-constrole">
                <div class="col-lg12">
                    <label>
                        <?php esc_html_e('Style presets', 'wpobjects'); ?>
                    </label>
                    <select class="form-control">
                        <?php foreach ($Presets as $Preset) : ?>
                        <option value="<?php echo esc_attr($Preset->getId()); ?>">
                            <?php echo esc_html($Preset->getName()); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                    <p class="help-block">
                        <?php esc_html_e('When you select present, all fields can rewrite.', 'wpobjects'); ?>
                    </p>
                </div>
            </div>
        <?php
    }
        
    /**
     * @return \WPObjects\AssetsManager\AssetsManager 
     */
    public function getAssetsManager()
    {
        return $this->AssetsManager;
    }
    
    public function setAssetsManager(\WPObjects\AssetsManager\AssetsManager $AM)
    {
        $this->AssetsManager = $AM;
        
        return $this;
    }
    
    /**
     * @return \WPObjects\VC\CustomAddonModel
     */
    public function getAddon()
    {
        return $this->Addon;
    }
	
}
