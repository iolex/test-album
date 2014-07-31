<?php

namespace Gallery\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Gallery\Form\PhotoForm;
use Gallery\Form\PhotoFilter;


class PhotoController extends AbstractActionController
{
    protected $photoModel;
    public function getPhotoModel()
    {
        if (!$this->photoModel) {
            $this->photoModel = $this->getServiceLocator()->get('Gallery\Model\PhotoModel');
        }
        return $this->photoModel;
    }
    
    protected $albumModel;
    public function getAlbumModel()
    {
        if (!$this->albumModel) {
            $this->albumModel = $this->getServiceLocator()->get('Gallery\Model\AlbumModel');
        }
        return $this->albumModel;
    }
    
    
    // TODO: AJAX
    public function viewAction()
    {
        $id = $this->params()->fromRoute('id');
        if (!isset($id))
            return $this->redirect()->toRoute('Gallery/default', array('controller' => 'album', 'action' => 'index'));
        
        return new ViewModel(array(
            'photo' => $this->getPhotoModel()->getPhoto($id),
        ));
    }
    
    // TODO: AJAX
    public function createAction()
    {
        $aView = array();
        $id = $this->params()->fromRoute('id');
        
        $form = new PhotoForm('addPhoto');
        $filter = new PhotoFilter();
        $form->setInputFilter($filter->getInputFilter());
        
        if (isset($id)) {
            $aView['id'] = $id;
            $form->setAttribute('action', $this->url()->fromRoute('Gallery/default', array('controller' => 'photo', 'action' => 'create', 'id' => $id)));
        } else {
            $form->setAttribute('action', $this->url()->fromRoute('Gallery/default', array('controller' => 'photo', 'action' => 'create')));
            
            $options = array();
            $albums = $this->getAlbumModel()->fetchAll();
            foreach($albums as $album)
                $options[$album->ID] = $album->name;
            
            $form->add(array(
                'name' => 'photoAlbum',
                'type' => 'Zend\Form\Element\Select',
                'attributes' => array(
                    'required' => 'required',
                    'id' => 'photoAlbum_id',
                ),
                'options' => array(
                    'label' => 'В альбом:',
                    'empty_option' => '...',
                    'value_options' => $options,
                ),
            ));
        }
        
        $request = $this->getRequest();
        
        if ($request->isPost()) {
            $post = array_merge_recursive(
                $request->getPost()->toArray(),
                $request->getFiles()->toArray()
            );
            $form->setData($post);
            if ($form->isValid()) {
                if (isset($id)) {
                    $this->getPhotoModel()->savePhoto($form->getData(), $id);
                    return $this->redirect()->toRoute('Gallery/default', array('controller' => 'album', 'action' => 'view', 'id' => $id));
                } else {
                    $this->getPhotoModel()->savePhoto($form->getData());
                    return $this->redirect()->toRoute('Gallery/default', array('controller' => 'album', 'action' => 'index'));
                }
            }
        }
        
        $form->prepare();
        $aView['form'] = $form;
        return new ViewModel($aView);
    }
    
    // TODO: AJAX
    public function deleteAction()
    {
        $id = $this->params()->fromRoute('id');
        if (isset($id)) {
            $album_id = $this->getPhotoModel()->deletePhoto($id);
            return $this->redirect()->toRoute('Gallery/default', array('controller' => 'album', 'action' => 'view', 'id' => $album_id));
        }
        return $this->redirect()->toRoute('Gallery/default', array('controller' => 'album', 'action' => 'index'));
    }
}
