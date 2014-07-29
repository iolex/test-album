<?php

namespace Gallery\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;


class AlbumController extends AbstractActionController
{
    protected $albumModel;
    public function getAlbumModel()
    {
        if (!$this->albumModel) {
            $sm = $this->getServiceLocator();
            $this->albumModel = $sm->get('Gallery\Model\AlbumModel');
        }
        return $this->albumModel;
    }
    
    
    // TODO: pagination
    public function indexAction()
    {
        return new ViewModel(array(
            'albums' => $this->getAlbumModel()->fetchAll(),
        ));
    }
    
    public function viewAction()
    {
        return new ViewModel();
    }
    
    // TODO: AJAX
    public function createAction()
    {
        return new ViewModel();
    }
    
    // TODO: AJAX
    public function updateAction()
    {
        return new ViewModel();
    }
    
    // TODO: AJAX
    public function deleteAction()
    {
        return new ViewModel();
    }
}
