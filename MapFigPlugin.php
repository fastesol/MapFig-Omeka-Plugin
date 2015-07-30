<?php

/**
 * @copyright Roy Rosenzweig Center for History and New Media, 2007-2012
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 * @package Mapfig
 */

if (!defined('MAPFIG_PLUGIN_DIR')) {
    define('MAPFIG_PLUGIN_DIR', dirname(__FILE__));
}

if (!defined('MAPFIG_JSON_DIR')) {
    define('MAPFIG_JSON_DIR', dirname(__FILE__) . '/json');
}

class MapFigPlugin extends Omeka_Plugin_AbstractPlugin
{
    protected $_hooks = array(
        'install', 
        'uninstall', 
        'define_routes',
        'define_acl',
        'public_items_show',
        'admin_items_show_sidebar',
        'admin_items_browse_detailed_each',
        'initialize',
        'after_save_item' ,  
        'public_head',
        'admin_head'                           
    );

    
    protected $_filters = array(
        'admin_navigation_main',
        'exhibit_layouts',         // Added by David  
        'admin_items_form_tabs'   // Added by David   

    );

    public function hookInstall(){  
        include("install.php");

    }
    
    public function hookUninstall(){ 

        // Drop the Location table
        $db = get_db();
        $db->query("DROP TABLE IF EXISTS `$db->Mapfig`");
        $db->query("DROP TABLE IF EXISTS `$db->MapfigGroup`");
        $db->query("DROP TABLE IF EXISTS `$db->MapfigLayer`");
        $db->query("DROP TABLE IF EXISTS `$db->MapfigItem`");

    }
        
    public function hookInitialize(){      
      add_shortcode ('mapfig', array($this,'mapfigShortcode'));
    }
    
    public function mapfigShortcode($args){        
       include("shortcode.php");
    }


    
    public function hookPublicHead($args){
    }



     public function hookAdminHead($args)
    {

    }


    public function hookPublicItemsShow($args){

        $item = $args['item'];
        $id = $item->id; 


        $mapfigItem = get_db()->getTable('MapfigItem')->find($item->id);
           
           
        if(count($mapfigItem) > 0){
            $tobj = new Omeka_View_Helper_Shortcodes;
        
            echo $tobj->shortcodes($mapfigItem->content);
            
        }

        
    }
    
    public function hookDefineAcl($args){
        $acl = $args['acl'];
        $acl->addResource('Mapfigs');
        $acl->allow(null, 'Mapfigs');
    }

    
    public function hookAdminItemsBrowseDetailedEach($args){       
    }
    
    public function hookAdminItemsShowSidebar($args){       
    }
    
    public function hookDefineRoutes($array){
    }
    
    public function filterAdminNavigationMain($navArray){
        $navArray['MapFig'] = array('label'=>__("MapFig"), 'uri'=>url('map-fig'));
        return $navArray;
    }


    // Added by David  - Add MapFig Layout 
    public function filterExhibitLayouts($layouts){
        $layouts['map-fig'] = array(
            'name' => __('MapFig Map'),
            'description' => __('Display a MapFig Map')
        );
        return $layouts;
    }

    // Added by David - add MapFig to 'Add an Item' Tab
    public function filterAdminItemsFormTabs($tabs, $args){
        // insert the mapfig tab before the Miscellaneous tab
        $item = $args['item'];
        $tabs['MapFig'] = $this->_mapfigForm($item);

        return $tabs;
    }

    public function hookAfterSaveItem($args){
        if (!($post = $args['post'])) {
            return;
        }
        $item = $args['record'];
        
        // If we don't have the geolocation form on the page, don't do anything!
        if (!isset($post['mapfig_content'])) {
            return;
        }

        $mapfig_item_id = (int)$post['mapfig_item_id'];
        $mapfigItem = get_db()->getTable('MapfigItem');
        
		$obj = new MapfigItem();
		
		if ($mapfig_item_id > 0){
	    	$obj = $mapfigItem->find($mapfig_item_id);
		}
		
    	$obj->item_id = $item->id;
		$obj->content = $post['mapfig_content'];

    	$obj->save();
    }

    // Start of Added by David: this is to add MapFig Map as an Item

    protected function _mapfigForm($item, $post = null)
    {
              
        $mapfig_item_id = $item->id;
        
     
        ob_start();
        include("mapfigItemForm.php");
        $string = ob_get_contents();
        ob_end_clean();
        
        return $string;       
    }
    // End of Added by David 

}