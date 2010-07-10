<?php

/**
 * BaseUserPostVoting
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $user_id
 * @property integer $post_id
 * @property Doctrine_Collection $Post
 * 
 * @method integer             getUserId()  Returns the current record's "user_id" value
 * @method integer             getPostId()  Returns the current record's "post_id" value
 * @method Doctrine_Collection getPost()    Returns the current record's "Post" collection
 * @method UserPostVoting      setUserId()  Sets the current record's "user_id" value
 * @method UserPostVoting      setPostId()  Sets the current record's "post_id" value
 * @method UserPostVoting      setPost()    Sets the current record's "Post" collection
 * 
 * @package    capsoff.net
 * @subpackage model
 * @author     Моисеев Данил
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseUserPostVoting extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('user_post_voting');
        $this->hasColumn('user_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('post_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));

        $this->option('symfony', array(
             'form' => false,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('Post', array(
             'local' => 'post_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));
    }
}