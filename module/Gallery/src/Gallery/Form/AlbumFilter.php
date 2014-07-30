<?php

namespace Gallery\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;


class AlbumFilter implements InputFilterAwareInterface
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
                'name' => 'albumName',
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
                'name' => 'albumDescription',
                'required' => true,
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
                'name' => 'albumOwner',
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
                'name' => 'albumEmail',
                'required' => false,
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
                    array (
                        'name' => 'EmailAddress',
                        'options' => array(
                            'messages' => array(
                                'emailAddressInvalidFormat' => 'Email введен некорректно',
                                // TODO: где разместить локализацию сообщейний из Zend\Validator\EmailAdress?
                            ),
                        ),
                    ),
                ),
            ]));
            
            $inputFilter->add($factory->createInput([
                'name' => 'albumPhone',
                'required' => false,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array (
                        'name' => 'Regex',
                        'options' => array(
                            'pattern' => '/^\+7 \(\d{3}\) \d{3}-\d{2}-\d{2}$/',
                        ),
                    ),
                ),
            ]));
            
            $this->inputFilter = $inputFilter;
        }
        
        return $this->inputFilter;
    }
}
