<?php

namespace Gallery\Model;

use Zend\Db\TableGateway\TableGateway;

use Zend\Db\Sql\Select;
use Zend\Db\Sql\Expression;


class AlbumModel
{
    protected $tableGateway;
    
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    
    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select(function(Select $select) {
            $select->columns(array(
                'ID',
                'name',
                'description',
                'owner',
                'email',
                'phone',
                'created',
                'updated',
            ));
            
            $sub = new Select('photo');
            $sub->columns(array(
                'album_id',
                'max_id' => new Expression('MAX(`ID`)'),
                'count_photo' => new Expression('COUNT(`ID`)'),
            ));
            $sub->group('album_id');
            
            $select->join(
                array('sub' => $sub),
                'album.ID = sub.album_id',
                array(
                    'count_photo',
                ),
                $select::JOIN_LEFT
            );
            
            $select->join(
                'photo',
                'sub.max_id = photo.ID',
                array(
                    //'photo_id'      => 'ID',
                    'photo_src'     => 'src',
                    'photo_ext'     => 'ext',
                    'photo_created' => 'created',
                ),
                $select::JOIN_LEFT
            );
            
            $select->order('ID');
        });
        
        return $resultSet;
    }
    
    public function getAlbum($id)
    {
        $resultSet = $this->tableGateway->select(function(Select $select) use ($id) {
            $select->columns(array(
                'ID',
                'name',
                'description',
                'owner',
                'email',
                'phone',
                'created',
                'updated',
            ));
            
            $select->where(array('ID = ?' => $id));
            
            $select->limit(1);
        });
        
        $album = $resultSet->current();
        
        return $album;
    }
    
    public function saveAlbum($data, $id = null)
    {
        $album = array(
            'name'        => (!empty($data['albumName']))        ? $data['albumName']             : 'std:name',
            'description' => (!empty($data['albumDescription'])) ? $data['albumDescription']      : 'std:description',
            'owner'       => (!empty($data['albumOwner']))       ? $data['albumOwner']            : 'std:owner',
            'email'       => (!empty($data['albumEmail']))       ? $data['albumEmail']            : null,
            'phone'       => (!empty($data['albumPhone']))       ? $data['albumPhone']            : null,
        );
        
        if (isset($id))
            $this->tableGateway->update($album, array('ID' => $id));
        else
            $this->tableGateway->insert($album);
    }
    
    public function deleteAlbum($id)
    {
        $this->tableGateway->delete(array('ID' => $id));
    }
}
