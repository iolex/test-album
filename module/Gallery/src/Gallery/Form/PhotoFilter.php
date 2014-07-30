<?php

namespace Gallery\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;


class PhotoFilter implements InputFilterAwareInterface
{
    protected $inputFilter;
    
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }
    
    public function getInputFilter()
    {
        if (!$this->inputFilter)
        {
            $inputFilter = new InputFilter();
            $factory = new InputFactory();
            
            $inputFilter->add($factory->createInput([
                'name' => 'photoName',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'max' => 50,
                        ),
                    ),
                ),
            ]));
            
            $inputFilter->add($factory->createInput([
                'name' => 'photoMetainfo',
                'required' => false,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'max' => 200,
                        ),
                    ),
                ),
            ]));
            
            $inputFilter->add($factory->createInput([
                'name' => 'photoFile',
                'required' => true,
                'validators' => array(
                    array(
                        'name' => 'FileSize',
                        'options' => array(
                            'max' => 20971520,
                        ),
                    ),
                    array(
                        'name' => 'FileMimetype',
                        'options' => array(
                            'mimeType' => 'image/bmp,image/gif,image/jpeg,image/png',
                        ),
                    ),
                    array(
                        'name' => 'FileExtension',
                        'options' => array(
                            'extension' => 'bmp,gif,jpg,jpeg,png',
                        ),
                    ),
                ),
            ]));
            
            $this->inputFilter = $inputFilter;
        }
        
        return $this->inputFilter;
    }
}
