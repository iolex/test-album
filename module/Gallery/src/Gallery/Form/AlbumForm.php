<?php

namespace Gallery\Form;

use Zend\Form\Element;
use Zend\Form\Form;


class AlbumForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct($name);
        
        $this->setAttribute('method', 'post');
        
        $this->add(array(
            'name' => 'albumName',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'required' => 'required',
                'autocomplete' => 'off',
                'id' => 'albumName_id',
            ),
            'options' => array(
                'label' => 'Название:',
            ),
        ));
        
        $this->add(array(
            'name' => 'albumDescription',
            'type' => 'Zend\Form\Element\Textarea',
            'attributes' => array(
                'required' => 'required',
                'autocomplete' => 'off',
                'id' => 'albumDescription_id',
            ),
            'options' => array(
                'label' => 'Описание:',
            ),
        ));
        
        $this->add(array(
            'name' => 'albumOwner',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'required' => 'required',
                'autocomplete' => 'off',
                'id' => 'albumOwner_id',
            ),
            'options' => array(
                'label' => 'Имя фотографа:',
            ),
        ));
        
        $this->add(array(
            'name' => 'albumEmail',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'autocomplete' => 'off',
                'id' => 'albumEmail_id',
            ),
            'options' => array(
                'label' => 'Email:',
            ),
        ));
        
        $this->add(array(
            'name' => 'albumPhone',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'autocomplete' => 'off',
                'id' => 'albumPhone_id',
                'placeholder' => '+7 (XXX) XXX-XX-XX',
            ),
            'options' => array(
                'label' => 'Телефон:',
            ),
        ));
        
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Сохранить',
                'id' => 'submitButton',
            ),
        ));
    }
}
