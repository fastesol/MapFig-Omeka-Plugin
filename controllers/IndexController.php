<?php

class MapFig_IndexController extends Omeka_Controller_AbstractActionController
{
 	private $mapfigObj = null;
	
    public function init(){
    	$this->_helper->db->setDefaultModelName('Mapfig');
		
    	$this->mapfigObj = $this->_helper->db->getTable('Mapfig');
    	$this->groupObj = $this->_helper->db->getTable('MapfigGroup');
    	$this->layerObj = $this->_helper->db->getTable('MapfigLayer');
		
		
		$id = $this->getRequest()->getParam('id');
		
		$this->view->baselayer = $this->layerObj->findAll();
    	$this->view->layerGroup = $this->groupObj->findAll();
		
		$mapfigData = null;
		if($id) {
			$mapfigData = $this->mapfigObj->find($id);
			
			$this->view->mapfig = $mapfigData;
			$this->view->mapfig_id = $mapfigData->id;
			$this->view->height = $mapfigData->height;
			$this->view->width = $mapfigData->width;
			$this->view->zoom = $mapfigData->zoom;
			$this->view->first_lat = 0;
			$this->view->first_lng = 0;
		}
		else {
			$this->view->height = 500;
			$this->view->width = 600;
			$this->view->zoom = 2;
			$this->view->first_lat = 0;
			$this->view->first_lng = 0;
		}
		
		$defaultLayer = array();
		if($id) {
			if (!empty($mapfigData->baselayer)){
				$defaultlayer =  $this->layerObj->find($mapfigData->baselayer);
			}else{
				$defaultlayer =  $this->view->baselayer[0];
			}
		}
		else {
			$this->view->baselayer = $this->layerObj->findAll();
			if (count($this->view->baselayer)){
				$defaultlayer =  $this->view->baselayer[0];
			}
		}
		$this->view->defaultLayer = $defaultlayer;		
		
		$layerGroup = array();
		if($id) {
			if (!empty($mapfigData->layergroup)){
				$layerGroup = get_db()->getTable('MapfigGroup')->find($mapfigData->layergroup);
			}
		}
		$rws = array();
		if (count($layerGroup) > 0){    
			$rws = explode(',', $layerGroup->layer_id);
		}
		
		$baseLayers = array();
		foreach($rws as $r) {
			$r = get_db()->getTable('MapfigLayer')->find($r);;
			if (count($r) > 0){
			   $baseLayers[] = "'".$r->name."': L.tileLayer('".$r->url."', {maxZoom: 18, id: '".$r->key."', token: '".$r->accesstoken."', attribution:'" . html_entity_decode($r->attribution) . "' + mbAttribution})";
			}  
		}
		$baseLayers = implode(",", $baseLayers);
		$this->view->mapfiglayergroup = $baseLayers;
		
		
		$this->_autoCsrfProtection = true;
    }
    
    public function indexAction(){ 
    	$this->view->mapfig = $this->mapfigObj->findAll();
		$this->view->layer_group = $this->groupObj->findAll();
		$this->view->baselayer = $this->layerObj->findAll();
    }
	
    public function browseAction() {
		header("location:" . url("map-fig"));
	    exit;
	}
	
	public function showAction() {
		header("location:" . url("map-fig"));
	    exit;
	}
}