<?php

class MapFig_GroupController extends Omeka_Controller_AbstractActionController
{
 	private $groupObj = null;
	
    public function init() {
    	$this->_helper->db->setDefaultModelName('MapfigGroup');
		
    	$this->groupObj = $this->_helper->db->getTable('MapfigGroup');
    	$this->layerObj = $this->_helper->db->getTable('MapfigLayer');
		
		
		$id = $request = $this->getRequest()->getParam('id');
		$selected_baselayer = array();
		$groupData = $this->groupObj->find($id);
		if (!empty($groupData->layer_id)){
			$selected_baselayer = explode(',', $groupData->layer_id);
		}
		$this->view->selected_baselayer = $selected_baselayer;
		$this->view->baselayer = $this->layerObj->findAll();
		
		
		$this->_autoCsrfProtection = true;
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