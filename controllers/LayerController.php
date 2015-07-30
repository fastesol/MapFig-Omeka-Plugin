<?php

class MapFig_LayerController extends Omeka_Controller_AbstractActionController
{
 	private $layerObj = null;     

    public function init(){
    	$this->_helper->db->setDefaultModelName('MapfigLayer');
		
    	$this->layerObj = $this->_helper->db->getTable('MapfigLayer');
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