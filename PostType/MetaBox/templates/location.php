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