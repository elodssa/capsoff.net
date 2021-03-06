<?php

/**
 * BasePostTags
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $post_id
 * @property integer $tag_id
 * @property Post $Post
 * @property Tag $Tag
 * 
 * @method integer  getId()      Returns the current record's "id" value
 * @method integer  getPostId()  Returns the current record's "post_id" value
 * @method integer  getTagId()   Returns the current record's "tag_id" value
 * @method Post     getPost()    Returns the current record's "Post" value
 * @method Tag      getTag()     Returns the current record's "Tag" value
 * @method PostTags setId()      Sets the current record's "id" value
 * @method PostTags setPostId()  Sets the current record's "post_id" value
 * @method PostTags setTagId()   Sets the current record's "tag_id" value
 * @method PostTags setPost()    Sets the current record's "Post" value
 * @method PostTags setTag()     Sets the current record's "Tag" value
 * 
 * @package    capsoff.net
 * @subpackage model
 * @author     Моисеев Данил
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasePostTags extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('post_tags');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('post_id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'length' => 4,
             ));
        $this->hasColumn('tag_id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'length' => 4,
             ));

        $this->option('symfony', array(
             'form' => false,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Post', array(
             'local' => 'post_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('Tag', array(
             'local' => 'tag_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));
    }
}