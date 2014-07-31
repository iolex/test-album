<?php

namespace Gallery\Model;

use Zend\Db\TableGateway\TableGateway;

use Zend\Db\Sql\Select;
use Zend\Db\Sql\Expression;
use WebinoImageThumb\WebinoImageThumb;


class PhotoModel
{
    protected $tableGateway;
    
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    
    public function fetchAll($album_id = null)
    {
        $resultSet = $this->tableGateway->select(function(Select $select) use ($album_id) {
            $select->columns(array(
                'ID',
                'album_id',
                'src',
                'ext',
                'name',
                'metainfo',
                'created',
                'updated',
            ));
            
            $select->where(array('album_id = ?' => $album_id));
            
            $select->order('ID');
        });
        
        return $resultSet;
    }
    
    public function getPhoto($id)
    {
        $resultSet = $this->tableGateway->select(function(Select $select) use ($id) {
            $select->columns(array(
                'ID',
                'album_id',
                'src',
                'ext',
                'name',
                'metainfo',
                'created',
                'updated',
            ));
            
            $select->where(array('ID = ?' => $id));
            
            $select->limit(1);
        });
        
        $photo = $resultSet->current();
        
        return $photo;
    }
    
    public function getNextPhoto($id)
    {
        /*$resultSet = $this->tableGateway->select(function(Select $select) use ($id) {
            $select->columns(array(
                'ID',
                'album_id',
                'src',
                'ext',
                'name',
                'metainfo',
                'created',
                'updated',
            ));
            
            
            
            $sub->
            
            
            
            
            $select->where(array('ID = ?' => $id));
            
            $select->limit(1);
        });
        
        $photo = $resultSet->current();
        
        return $photo;*/
    }
    
    public function getPreviousPhoto($id)
    {
        
    }
    
    
    
    public function savePhoto($data, $album_id = null)
    {
        if (!isset($album_id))
            $album_id = isset($data['photoAlbum']) ? $data['photoAlbum'] : null;
        
        $photoSrc = uniqid();
        $photoExt = pathinfo($data['photoFile']['name'], PATHINFO_EXTENSION);
        $photoPath = PUBLIC_PATH.DIRECTORY_SEPARATOR.'upload'.DIRECTORY_SEPARATOR.$album_id.DIRECTORY_SEPARATOR.$photoSrc.'.'.$photoExt;
        copy(
            $data['photoFile']['tmp_name'],
            $photoPath
        );
        
        $imageLib = new WebinoImageThumb;
        $imageMin = $imageLib->create(
            $photoPath,
            array(),
            array()
        );
        
        $imageMin->resize(250, 250);
        $imageMin->save(
            PUBLIC_PATH.DIRECTORY_SEPARATOR.'upload'.DIRECTORY_SEPARATOR.$album_id.DIRECTORY_SEPARATOR.$photoSrc.'_min.PNG',
            'PNG'
        );
        
        $photo = array(
            'album_id' => $album_id,
            'src'      => $photoSrc,
            'ext'      => $photoExt,
            'name'     => !empty($data['photoName'])     ? $data['photoName']     : 'std:name',
            'metainfo' => !empty($data['photoMetainfo']) ? $data['photoMetainfo'] : null,
        );
        
        $this->tableGateway->insert($photo);
    }
    
    public function deletePhoto($id)
    {
        $photo = $this->getPhoto($id);
        $this->tableGateway->delete(array('ID' => $id));
        
        $currentPath = PUBLIC_PATH.DIRECTORY_SEPARATOR.'upload'.DIRECTORY_SEPARATOR.$photo['album_id'].DIRECTORY_SEPARATOR.$photo['src'].'.'.$photo['ext'];
        if (is_file($currentPath))
            @unlink($currentPath);
            
        $currentPath = PUBLIC_PATH.DIRECTORY_SEPARATOR.'upload'.DIRECTORY_SEPARATOR.$photo['album_id'].DIRECTORY_SEPARATOR.$photo['src'].'_min.PNG';
        if (is_file($currentPath))
            @unlink($currentPath);
        
        // TODO: O_o
        return $photo['album_id'];
    }
}
