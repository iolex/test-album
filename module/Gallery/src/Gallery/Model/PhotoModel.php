<?php

namespace Gallery\Model;

use Zend\Db\TableGateway\TableGateway;

use Zend\Db\Sql\Select;
use Zend\Db\Sql\Expression;


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
    
    public function getPhoto($id = null)
    {
        
    }
    
    public function getNextPhoto($id = null)
    {
        
    }
    
    public function getPreviousPhoto($id = null)
    {
        
    }
    
    
    
    public function savePhoto($data, $id = null)
    {
        
    }
    
    public function deleteAlbum($id = null)
    {
        if (isset($id))
            $this->tableGateway->delete(array('ID' => $id));
        
        return true;
    }
}
