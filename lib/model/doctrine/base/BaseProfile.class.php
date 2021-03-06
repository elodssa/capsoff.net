<?php

/**
 * BaseProfile
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $user_id
 * @property string $email
 * @property string $gender
 * @property string $fullname
 * @property string $avatar
 * @property string $know
 * @property string $want_know
 * @property string $validate
 * @property sfGuardUser $sfGuardUser
 * @property Doctrine_Collection $Post
 * @property Doctrine_Collection $Answer
 * @property Doctrine_Collection $OnlineUser
 * 
 * @method integer             getId()          Returns the current record's "id" value
 * @method integer             getUserId()      Returns the current record's "user_id" value
 * @method string              getEmail()       Returns the current record's "email" value
 * @method string              getGender()      Returns the current record's "gender" value
 * @method string              getFullname()    Returns the current record's "fullname" value
 * @method string              getAvatar()      Returns the current record's "avatar" value
 * @method string              getKnow()        Returns the current record's "know" value
 * @method string              getWantKnow()    Returns the current record's "want_know" value
 * @method string              getValidate()    Returns the current record's "validate" value
 * @method sfGuardUser         getSfGuardUser() Returns the current record's "sfGuardUser" value
 * @method Doctrine_Collection getPost()        Returns the current record's "Post" collection
 * @method Doctrine_Collection getAnswer()      Returns the current record's "Answer" collection
 * @method Doctrine_Collection getOnlineUser()  Returns the current record's "OnlineUser" collection
 * @method Profile             setId()          Sets the current record's "id" value
 * @method Profile             setUserId()      Sets the current record's "user_id" value
 * @method Profile             setEmail()       Sets the current record's "email" value
 * @method Profile             setGender()      Sets the current record's "gender" value
 * @method Profile             setFullname()    Sets the current record's "fullname" value
 * @method Profile             setAvatar()      Sets the current record's "avatar" value
 * @method Profile             setKnow()        Sets the current record's "know" value
 * @method Profile             setWantKnow()    Sets the current record's "want_know" value
 * @method Profile             setValidate()    Sets the current record's "validate" value
 * @method Profile             setSfGuardUser() Sets the current record's "sfGuardUser" value
 * @method Profile             setPost()        Sets the current record's "Post" collection
 * @method Profile             setAnswer()      Sets the current record's "Answer" collection
 * @method Profile             setOnlineUser()  Sets the current record's "OnlineUser" collection
 * 
 * @package    capsoff.net
 * @subpackage model
 * @author     Моисеев Данил
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseProfile extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('profile');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('user_id', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => 4,
             ));
        $this->hasColumn('email', 'string', 80, array(
             'type' => 'string',
             'unique' => true,
             'length' => 80,
             ));
        $this->hasColumn('gender', 'string', 16, array(
             'type' => 'string',
             'notnull' => true,
             'default' => 'undefined',
             'length' => 16,
             ));
        $this->hasColumn('fullname', 'string', 80, array(
             'type' => 'string',
             'notnull' => false,
             'length' => 80,
             ));
        $this->hasColumn('avatar', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('know', 'string', 511, array(
             'type' => 'string',
             'length' => 511,
             ));
        $this->hasColumn('want_know', 'string', 511, array(
             'type' => 'string',
             'length' => 511,
             ));
        $this->hasColumn('validate', 'string', 17, array(
             'type' => 'string',
             'length' => 17,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('sfGuardUser', array(
             'local' => 'user_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasMany('Post', array(
             'local' => 'user_id',
             'foreign' => 'user_id'));

        $this->hasMany('Answer', array(
             'local' => 'user_id',
             'foreign' => 'user_id'));

        $this->hasMany('OnlineUser', array(
             'local' => 'user_id',
             'foreign' => 'user_id'));
    }
}