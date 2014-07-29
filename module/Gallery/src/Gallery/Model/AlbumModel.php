<?php

namespace Gallery\Model;

use Zend\Db\TableGateway\TableGateway;

use Zend\Db\Sql\Select;
use Zend\Db\Sql\Expression;
//use Zend\Paginator\Adapter\DbSelect;
//use Zend\Paginator\Paginator;


class AlbumModel
{
    protected $tableGateway;
    
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    
    public function fetchAll($paginated = false)
    {
        $resultSet = $this->tableGateway->select(function(Select $select){
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
        });
        return $resultSet;
        
        
        
        /*if ($paginated) {
            $select = new Select('album');
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new Album());
            $paginatorAdapter = new DbSelect(
                $select,
                $this->tableGateway->getAdapter(),
                $resultSetPrototype
            );
            $paginator = new Paginator($paginatorAdapter);
            return $paginator;
        }*/
    }
    
    public function getAlbum($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('ID' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Error while select album ($id)");
        }
        return $row;
    }
    
    public function saveAlbum(Album $album)
    {
        $data = array(
            'name'        => $album->name,
            'description' => $album->description,
            'owner'       => $album->owner,
            'email'       => $album->email,
            'phone'       => $album->phone,
        );
        
        $id = (int) $album->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getAlbum($id)) {
                $this->tableGateway->update($data, array('ID' => $id));
            } else {
                throw new \Exception('Error while update album ($id)');
            }
        }
        
        //return ID
    }
    
    public function deleteAlbum($id)
    {
        $id  = (int) $id;
        $this->tableGateway->delete(array('ID' => $id));
    }
}
