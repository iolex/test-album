<?php

namespace Gallery\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class AlbumController extends AbstractActionController
{
    // pagination?
    public function indexAction()
    {
        //echo Zend_Control_Front::getInstance()->getRequest()->getModuleName();
        
        echo 'ololo';
        return new ViewModel();
    }
    
    // AJAX тут же?
    public function createAction()
    {
        return new ViewModel();
    }
    
    // AJAX тут же?
    public function updateAction()
    {
        return new ViewModel();
    }
    
    // AJAX тут же?
    public function deleteAction()
    {
        return new ViewModel();
    }
    
    
    
}
