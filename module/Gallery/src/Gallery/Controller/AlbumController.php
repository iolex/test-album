<?php

namespace Gallery\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Gallery\Form\AlbumForm;
use Gallery\Form\AlbumFilter;


class AlbumController extends AbstractActionController
{
    protected $albumModel;
    public function getAlbumModel()
    {
        if (!$this->albumModel) {
            $this->albumModel = $this->getServiceLocator()->get('Gallery\Model\AlbumModel');
        }
        return $this->albumModel;
    }
    
    protected $photoModel;
    public function getPhotoModel()
    {
        if (!$this->photoModel) {
            $this->photoModel = $this->getServiceLocator()->get('Gallery\Model\PhotoModel');
        }
        return $this->photoModel;
    }
    
    
    // TODO: pagination
    public function indexAction()
    {
        return new ViewModel(array(
            'albums' => $this->getAlbumModel()->fetchAll(),
        ));
    }
    
    // TODO: pagination
    public function viewAction()
    {
        $id = $this->params()->fromRoute('id');
        if (!isset($id))
            return $this->redirect()->toRoute('Gallery/default', array('controller' => 'album', 'action' => 'index'));
        
        return new ViewModel(array(
            'album' => $this->getAlbumModel()->getAlbum($id),
            'photos' => $this->getPhotoModel()->fetchAll($id),
        ));
    }
    
    // TODO: AJAX, [MERGE create + update]
    public function createAction()
    {
        $form = new AlbumForm('saveAlbum');
        $filter = new AlbumFilter();
        $form->setInputFilter($filter->getInputFilter());
        $form->setAttribute('action', $this->url()->fromRoute('Gallery/default', array('controller' => 'album', 'action' => 'create')));
        $request = $this->getRequest();
        
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $this->getAlbumModel()->saveAlbum($form->getData());
                return $this->redirect()->toRoute('Gallery/default', array('controller' => 'album', 'action' => 'index'));
            }
        }
        
        $form->prepare();
        return new ViewModel(array(
            'form' => $form,
        ));
    }
    
    // TODO: AJAX, [MERGE create + update]
    public function updateAction()
    {
        $id = $this->params()->fromRoute('id');
        if (!isset($id))
            return $this->redirect()->toRoute('Gallery/default', array('controller' => 'album', 'action' => 'index'));
        
        $form = new AlbumForm('createAlbum');
        $filter = new AlbumFilter();
        $form->setInputFilter($filter->getInputFilter());
        $form->setAttribute('action', $this->url()->fromRoute('Gallery/default', array('controller' => 'album', 'action' => 'update', 'id' => $id)));
        $request = $this->getRequest();
        
        if($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $this->getAlbumModel()->saveAlbum($form->getData(), $id);
                return $this->redirect()->toRoute('Gallery/default', array('controller' => 'album', 'action' => 'index'));
            }
        } else {
            $data = $this->getAlbumModel()->getAlbum($id);
            $formData = array(
                'albumName'        => !empty($data->name)        ? $data->name        : '',
                'albumDescription' => !empty($data->description) ? $data->description : '',
                'albumOwner'       => !empty($data->owner)       ? $data->owner       : '',
                'albumEmail'       => !empty($data->email)       ? $data->email       : '',
                'albumPhone'       => !empty($data->phone)       ? $data->phone       : '',
            );
            $form->setData($formData);
        }
        
        $form->prepare();
        return new ViewModel(array(
            'form' => $form,
        ));
    }
    
    // TODO: AJAX
    public function deleteAction()
    {
        $id = $this->params()->fromRoute('id');
        if (isset($id))
            $this->getAlbumModel()->deleteAlbum($id);
        return $this->redirect()->toRoute('Gallery/default', array('controller' => 'album', 'action' => 'index'));
    }
}
