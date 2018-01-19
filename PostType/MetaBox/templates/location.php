<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2018 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko <vladislavdolgolenko.com>
 * @support      support@torbara.com
 */

?>

<div class="msp-bootstrap-wrapper msp-form">
    
    <div class="metabox-location-picker">
        
        <div class="form-group">
          <input class="placepicker form-control" 
                 name="_location"
                 data-map-container-id="collapseOne" 
                 data-latitude="<?php echo $this->getPostModel()->getMeta('_location_latitude'); ?>"
                 data-longitude="<?php echo $this->getPostModel()->getMeta('_location_longitude'); ?>"
            />
        </div>
        
        <div id="collapseOne" class="colapse-in collapse in">
          <div class="placepicker-map thumbnail" style="min-height: 250px;"></div>
        </div>
        <div class="row">
            <div class="col-md-6 text-center">
                <input type="text" name="_location_latitude" value="">
            </div>
            <div class="col-md-6 text-center">
                <input type="text" name="_location_longitude" value="">
            </div>
            
            <div class="clearfix"></div>
            
        </div>
        
    </div>
    
</div>