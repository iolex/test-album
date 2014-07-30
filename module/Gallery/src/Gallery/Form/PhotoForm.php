<?php

namespace Gallery\Form;

use Zend\Form\Element;
use Zend\Form\Form;


class PhotoForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct($name);
        
        $this->setAttribute('method', 'post');
        
        $this->add(array(
            'name' => 'photoName',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'required' => 'required',
                'autocomplete' => 'off',
                'id' => 'photoName_id',
            ),
            'options' => array(
                'label' => 'Заголовок:',
            ),
        ));
        
        $this->add(array(
            'name' => 'photoMetainfo',
            'type' => 'Zend\Form\Element\Textarea',
            'attributes' => array(
                'autocomplete' => 'off',
                'id' => 'photoMetainfo_id',
            ),
            'options' => array(
                'label' => 'Адрес съемки:',
            ),
        ));
        
        $this->add(array(
            'name' => 'photoFile',
            'type' => 'Zend\Form\Element\File',
            'attributes' => array(
                'required' => 'required',
                'id' => 'photoFile_id',
            ),
            'options' => array(
                'label' => 'Файл:',
            ),
        ));
        
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Добавить',
                'id' => 'submitButton',
            ),
        ));
    }
}
