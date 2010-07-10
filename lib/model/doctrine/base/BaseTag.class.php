<?php

/**
 * BaseTag
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property integer $views
 * @property integer $posts
 * @property Doctrine_Collection $Posts
 * @property Doctrine_Collection $PostsTags
 * 
 * @method integer             getId()        Returns the current record's "id" value
 * @method string              getName()      Returns the current record's "name" value
 * @method integer             getViews()     Returns the current record's "views" value
 * @method integer             getPosts()     Returns the current record's "posts" value
 * @method Doctrine_Collection getPosts()     Returns the current record's "Posts" collection
 * @method Doctrine_Collection getPostsTags() Returns the current record's "PostsTags" collection
 * @method Tag                 setId()        Sets the current record's "id" value
 * @method Tag                 setName()      Sets the current record's "name" value
 * @method Tag                 setViews()     Sets the current record's "views" value
 * @method Tag                 setPosts()     Sets the current record's "posts" value
 * @method Tag                 setPosts()     Sets the current record's "Posts" collection
 * @method Tag                 setPostsTags() Sets the current record's "PostsTags" collection
 * 
 * @package    capsoff.net
 * @subpackage model
 * @author     Моисеев Данил
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseTag extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('tag');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('name', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('views', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => true,
             'default' => 0,
             'length' => 4,
             ));
        $this->hasColumn('posts', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => true,
             'default' => 0,
             'length' => 4,
             ));

        $this->option('symfony', array(
             'form' => false,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('Post as Posts', array(
             'refClass' => 'PostTags',
             'local' => 'tag_id',
             'foreign' => 'post_id'));

        $this->hasMany('PostTags as PostsTags', array(
             'local' => 'id',
             'foreign' => 'tag_id'));
    }
}