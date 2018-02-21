<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2018 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko <vladislavdolgolenko.com>
 * @support      support@torbara.com
 */

namespace WPObjects\Customizer\Preset;

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
    
    /**
     * @var \WPObjects\Customizer\Preset\Model
     */
    protected $Presets = array();

    public function __construct( $manager, $id, $args, $Presets)
    {
        parent::__construct($manager, $id, $args);
        $this->Presets = is_array($Presets) ? $Presets : array();
    }

    public function enqueue()
    {
        if (!$this->getAssetsManager() instanceof \WPObjects\AssetsManager\AssetsManager) {
            throw new \Exception('Undefined AssetsManager');
        }
        
        $this->getAssetsManager()->enqueueStyle('customizer-constroles');
        $this->getAssetsManager()->enqueueScript('customizer-presets-constrole-handler');
    }

    public function to_json()
    {
        parent::to_json();
        
        $this->json['presets_params'] = array();
        foreach ($this->getPresets() as $Preset) {
            $this->json['presets_params'][$Preset->getId()] = $Preset->getParamsForCustomizer();
        }
    }

    public function render_content()
    {
        $Presets = $this->getPresets();
        
        ?>
            <div class="msp-bootstrap-wrapper msp-presets-controle js-vc-addons-customizer-presets-constrole" data-controle-id="<?php echo esc_attr($this->id); ?>">
                <div class="col-lg12">
                    <div class="form-group">
                        <div class="control-label">
                            <label class="customize-control-title">
                                <?php esc_html_e('Style presets', 'wpobjects'); ?>
                            </label>
                        </div>
                        <div class="input-group">
                            <div class="btn-group">
                                <?php foreach ($Presets as $Preset) : ?>
                                <div class="preset-button btn btn-default js-select-preset" data-preset-id="<?php echo esc_attr($Preset->getId()); ?>">
                                    <?php echo esc_html($Preset->getName()); ?>
                                    <div class="lines-wrapper">
                                        
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
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
     * @return \WPObjects\Customizer\Preset\Model
     */
    public function getPresets()
    {
        return $this->Presets;
    }
	
}
