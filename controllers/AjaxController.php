<?php

class MapFig_AjaxController extends Omeka_Controller_AbstractActionController
{
 	private $mapfigObj = null;     

    public function init(){
		$this->_helper->db->setDefaultModelName('Mapfig');
		
    	$this->mapfigObj = $this->_helper->db->getTable('Mapfig');
    	$this->groupObj = $this->_helper->db->getTable('MapfigGroup');
    	$this->layerObj = $this->_helper->db->getTable('MapfigLayer');
    }

	
	
	
	
    public function downloadjsonAction(){
    	$id = basename($_SERVER['REQUEST_URI']);
		$mapfigData = $this->mapfigObj->find($id);
		$mapfig = json_decode($mapfigData->pointers);
		
		$mapData = array();
		$mapData['type'] = "FeatureCollection";
		$mapData['feature'] = $mapfig;
		
		$mapfig = json_encode($mapData);

		header("Content-Disposition: attachment; filename=map.json");
		header("Content-Length: ". strlen($mapfig));
		echo $mapfig;

		exit;
    }
	
	function jsonlayerAction() {
		$layers_id = (int) $_POST['layers_id'];
		
		if($layers_id > 0) {
			$defaulLayer = $this->layerObj->find($layers_id);
			$defaulLayer = array('url' => $defaulLayer['url'], 'key' => $defaulLayer['key'], 'token' => $defaulLayer['accesstoken'], 'attribution' => $defaulLayer['attribution']);
		}
		
		echo json_encode($defaulLayer);
		exit;
	}
	
	function jsongroupAction() {
		$baseLayers = array();
		
		$groups_id = (int) $_REQUEST['groups_id'];
		$layers = $this->groupObj->find($groups_id);
		$layers = explode(',', $layers['layer_id']);
		
		foreach($layers as $layers_id) {
			$layers_id = (int)$layers_id;
			$data = $this->layerObj->find($layers_id);
			$baseLayers[] = array('name' => $data['name'], 'url' => $data['url'], 'key' => $data['key'], 'token' => $data['accesstoken'], 'attribution' => $data['attribution']);
		}
		
		echo json_encode($baseLayers);
		exit;
	}
}