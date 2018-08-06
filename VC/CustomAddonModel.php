<?php

/**
 * @encoding     UTF-8
 * @package      WPObjects
 * @link         https://github.com/VladislavDolgolenko/WPObjects
 * @copyright    Copyright (C) 2018 Vladislav Dolgolenko
 * @license      MIT License
 * @author       Vladislav Dolgolenko <vladislavdolgolenko.com>
 * @support      <help@vladislavdolgolenko.com>
 */

namespace WPObjects\VC;

class CustomAddonModel extends \WPObjects\Model\AbstractModel implements 
    \WPObjects\EventManager\ListenerInterface,
    \WPObjects\View\ViewInterface,
    \WPObjects\Service\NamespaceInterface,
    \WPObjects\Model\ModelTypeFactoryInterface,
    \WPObjects\LessCompiler\LessParamsInterface,
    \WPObjects\LessCompiler\WPlessInterface,
    \WPObjects\AssetsManager\AssetsManagerInterface,
    \WPObjects\Customizer\Preset\PresetsInterface
{
    protected $base = null;
    protected $name = null;
    protected $enqueue_styles = array();
    protected $enqueue_scripts = array();
    protected $params = array();
    protected $category = null;
    protected $html_template = array();
    protected $php_class_name = '\WPObjects\VC\Shortcode\DefaultShortcode';
    protected $query_model_type = null;
    
    /**
     * @var \WPObjects\LessCompiler\ParamModel
     */
    protected $CustomizerSettings = array();
    
    /**
     * @var \WPObjects\Model\ModelTypeFactory
     */
    protected $ModelTypeFactory = null;
    
    /**
     * @var \WPObjects\AssetsManager\AssetsManager
     */
    protected $AssetsManager = null;
    
    /**
     * @var \WPObjects\LessCompiler\WPless
     */
    protected $WPless = null;
    
    /**
     * @var \WPObjects\Customizer\Preset\Model
     */
    protected $Presets = array();
    
    public function attach()
    {
        if (\did_action('plugins_loaded') > 0) {
            \add_action('plugins_loaded', array($this, 'registerHandler'), 30, 0);
        } else {
            $this->registerHandler();
        }
        
        if ($this->getWPLess()) {
            \add_filter( $this->getWPLess()->getCompileFilterName(), array($this, 'getLessParams'), 100, 2);
        }
    }
    
    public function detach()
    {
        \remove_action('plugins_loaded', array($this, 'registerHandler'), 30, 0);
    }
    
    public function registerHandler()
    {
        if (!class_exists('WPBMap')) {
            return;
        }
        
        \WPBMap::map($this->getId(), $this->getVCShortcodeConfig());
    }
    
    public function getVCShortcodeConfig()
    {
        $config = array(
            'AddonModel' => $this,
            'base' => $this->getId(),
            'name' => $this->getName(),
            'php_class_name' => $this->php_class_name,
            'category' => $this->category,
            'icon' => $this->get('icon'),
            'html_template' => apply_filters($this->getNamespace() . '-addon-template-' . $this->getId(), $this->html_template),
            'params' => $this->params,
            'as_child' => $this->get('as_child'),
            'is_container' => $this->get('is_container'),
            'as_parent' => $this->get('as_parent'),
            'show_settings_on_create' => $this->get('show_settings_on_create'),
            'admin_enqueue_js' => $this->get('admin_enqueue_js'),
            'admin_enqueue_css' => $this->get('admin_enqueue_css'),
            'default_content' => $this->get('default_content'),
            'custom_markup' => $this->get('custom_markup'),
            'js_view' => $this->get('js_view'),
        );
        
        // If setted main model type for addon, will be added special forms to addon ui editing panel
        if ($this->query_model_type) {
            $ModelType = $this->getModelTypeFactory()->get($this->query_model_type);
            if ($ModelType instanceof \WPObjects\Model\AbstractModelType) {
                $ShorcodeParams = new \WPObjects\VC\ShorcodeParams();
                $config['params'] = $ShorcodeParams->genAllParams($ModelType, $config['params']);
            }
        }
        
        return array_filter($config);
    }
    
    public function enqueues()
    {
        $scripts = apply_filters($this->getNamespace() . '-addon-js-' . $this->getId(), $this->enqueue_scripts);
        if (current($scripts)) {
            \wp_localize_script(current($scripts), $this->getId(), $this->getCustomazerSettingsParams());
        }
        
        foreach ($scripts as $script) {
            \wp_enqueue_script($script);
        }
        
        $styles = apply_filters($this->getNamespace() . '-addon-style-' . $this->getId(), $this->enqueue_styles);
        foreach ($styles as $style) {
            \wp_enqueue_style($style);
        }
    }
    
    public function render()
    {
        //
    }
    
    public function toJSON()
    {
        $data = parent::toJSON();
        $data['base'] = $this->getId();
        $data['name'] = $this->getName();
        $data['category'] = $this->get('category');
        $data['query_model_type_name'] = '';
        $data['presets'] = array();
        
        $ModelType = $this->getModelTypeFactory()->get($this->query_model_type);
        if ($ModelType) {
            $data['query_model_type_name'] = $ModelType->getName();
        }
        
        $Presets = $this->getPresets();
        foreach ($Presets as $Preset) {
            $data['presets'][] = $Preset->toJSON();
        }
        
        return $data;
    }
    
    public function getLessParams($vars, $handle = null)
    {
        if ( !in_array($handle, $this->getEnqueueStyles()) ) {
            return $vars;
        }
        
        $Params = $this->getCustomizerSettings();
        foreach ($Params as $Param) {
            $vars[$Param->getId()] = $Param->getCurrentValue();
        }
        
        /*
        if ($this->getId() === 'team_latest_matches') {
            var_dump($this->getId());
            var_dump($vars);
        }*/
        
        return $vars;
    }
    
    public function getCustomazerSettingsParams()
    {
        $Params = $this->getCustomizerSettings();
        
        $result = array();
        foreach ($Params as $Param) {
            $result[$Param->getId()] = $Param->getCurrentValue();
        }
        
        return $result;
    }
    
    public function beforeContent()
    {
        if ( \is_customize_preview() ) {
            if ($this->getAssetsManager()) {
                $this->getAssetsManager()->enqueueStyle('wp-customizer');
            }
            echo '<div class="'. $this->getWPCustomizerPartialClass() . ' partial-no-margins" style="position: relative;"></div>';
        }
    }
    
    public function getWPCustomizerPartialClass()
    {
        return $this->getNamespace() . '-' . $this->getId() . '-vc-shorcode-wp-customize';
    }
    
    public function attachStyle($name)
    {
        if (!in_array($name, $this->enqueue_styles)) {
            $this->enqueue_styles[] = $name;
        }
        
        return $this;
    }
    
    public function attachScript($name)
    {
        if (!in_array($name, $this->enqueue_scripts)) {
            $this->enqueue_scripts[] = $name;
        }
        
        return $this;
    }
    
    public function getEnqueueScriptName()
    {
        return current( $this->getEnqueueScripts() );
    }
    
    public function getEnqueueStyles()
    {
        return $this->enqueue_styles;
    }
    
    public function getEnqueueScripts()
    {
        return $this->enqueue_scripts;
    }
    
    public function getId()
    {
        return $this->base;
    }
    
    public function setId($string)
    {
        $this->base = (string)$string;
        
        return $this;
    }
    
    public function getName()
    {
        if ($this->name) {
            return $this->name;
        }
        
        $name = ucfirst( trim ( str_replace(array('_', '-', '/'), ' ', $this->getId()) ) );
        
        return $name;
    }
    
    public function setName($string)
    {
        $this->name = $string;
        
        return $this;
    }
    
    /**
     * Return settings panel param cofig by name
     * 
     * @param string $param_name
     * @return mixed
     */
    public function getConfigParam($param_name)
    {
        foreach ($this->params as $param) {
            if ($param['param_name'] === $param_name) {
                return $param;
            }
        }

        return array();
    }
    
    public function getConfigParams()
    {
        return $this->params;
    }
    
    /**
     * Custom setting from shortcode panel editing
     * 
     * @return array
     */
    public function getShortcodeSettings($Shortcode)
    {
        if (!function_exists('vc_map_get_attributes')) {
            return array();
        }
        
        return \vc_map_get_attributes($Shortcode->getShortcode(), $Shortcode->getAtts());
    }
    
    public function setTemplatePath($string)
    {
        $this->html_template = $string;
        
        return $this;
    }
    
    public function getTemplatePath()
    {
        return $this->html_template;
    }
    
    public function setModelTypeFactory(\WPObjects\Model\ModelTypeFactory $ModelTypeFactory)
    {
        $this->ModelTypeFactory = $ModelTypeFactory;
        
        return $this;
    }
    
    /**
     * @return \WPObjects\LessCompiler\ParamModel
     */
    public function getCustomizerSettings()
    {
        return $this->CustomizerSettings;
    }
    
    /**
     * @return \WPObjects\Model\ModelTypeFactory
     */
    public function getModelTypeFactory()
    {
        return $this->ModelTypeFactory;
    }
    
    public function setNamespace($string)
    {
        $this->namespace = $string;
        
        return $this;
    }
    
    public function getNamespace()
    {
        return $this->namespace;
    }
    
    /**
     * @return \WPObjects\LessCompiler\WPless
     */
    public function getWPLess()
    {
        return $this->WPless;
    }
    
    public function setWPLess(\WPObjects\LessCompiler\WPless $WPless)
    {
        $this->WPless = $WPless;
        
        return $this;
    }
    
    public function setAssetsManager(\WPObjects\AssetsManager\AssetsManager $AM)
    {
        $this->AssetsManager = $AM;
        
        return $this;
    }
    
    /**
     * @return \WPObjects\AssetsManager\AssetsManager 
     */
    public function getAssetsManager()
    {
        return $this->AssetsManager;
    }
    
    /**
     * @return \WPObjects\VC\AddonPreset\Model
     */
    public function getPresets()
    {
        return $this->Presets;
    }
    
    public function setPresets($Presets)
    {
        $this->Presets = $Presets;
        
        return $this;
    }
    
    public function addPreset(\WPObjects\Customizer\Preset\Model $Preset)
    {
        $this->Presets[] = $Preset;
        
        return $this;
    }
}