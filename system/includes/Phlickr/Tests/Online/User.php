<?php

/**
 * User Online Tests
 *
 * @version $Id: User.php 537 2008-12-09 23:32:59Z edwardotis $
 * @copyright 2005
 */

class Phlickr_Tests_Online_User extends PHPUnit_Framework_TestCase {
    var $api;
    var $user;

    function setUp() {
        $this->api = new Phlickr_Api(TESTING_API_KEY, TESTING_API_SECRET, TESTING_API_TOKEN);
        $this->user = new Phlickr_User($this->api, $this->api->getUserId());
    }
    function tearDown() {
        unset($this->user);
        unset($this->api);
    }

    function testConstructor_FromIdConnectsAssignsId() {
        $fromId = new Phlickr_User($this->api, TESTING_USER_ID);
        $this->assertEquals(TESTING_XML_USER_ID, $fromId->getId());
    }


    function testGetContactUserList_ReturnsCorrectClass() {
        $result = $this->user->getContactUserList();
        $this->assertType('Phlickr_UserList', $result);
        $this->assertEquals(2, $result->getCount());
        $this->assertEquals(array('26159919@N00','40962351@N00'),
            $result->getIds());
    }

    function testGetFavoritesPhotoList() {
        $result = $this->user->getFavoritePhotoList();
        $this->assertType('Phlickr_PhotoList', $result);
        $this->assertEquals('flickr.favorites.getPublicList',
            $result->getRequest()->getMethod());
        $this->assertEquals(1, $result->getCount());
        $this->assertContains(6508272, $result->getIds());
    }

    function testGetGroupList() {
        $result = $this->user->getGroupList();
        $this->assertType('Phlickr_GroupList', $result);
        $this->assertEquals(1, $result->getCount());
        $this->assertEquals(array('97544914@N00'), $result->getIds());
    }

    function testGetPhotoList_DefaultPerPage() {
        $result = $this->user->getPhotoList();
        $this->assertType('Phlickr_PhotoList', $result);
        $this->assertEquals(Phlickr_PhotoList::PER_PAGE_DEFAULT,
            $result->getPhotosPerPage());
        $photos = $result->getPhotos();
        $this->assertEquals(TESTING_USER_ID, $photos[0]->getUserId());
    }

    function testGetPhotoList_AssignedPerPage() {
        $result = $this->user->getPhotoList(1);
        $this->assertType('Phlickr_PhotoList', $result);
        $this->assertEquals(1, $result->getPhotosPerPage());
        $photos = $result->getPhotos();
        $this->assertEquals(TESTING_USER_ID, $photos[0]->getUserId());
    }

    function testFindByUsername_Valid() {
        $result = Phlickr_User::findByUsername($this->api, 'just testing');
        $this->assertType('Phlickr_User', $result);
        $this->assertEquals(TESTING_USER_ID, $result->getId());
    }
    function testFindByUsername_InvalidThrows() {
        try {
            $result = Phlickr_User::findByUsername($this->api, 'this had better not be a real username');
        } catch (Phlickr_MethodFailureException $e) {
            return;
        }
        $this->fail("An exception should have been thrown.");
    }

    function testFindByEmail_Valid() {
        $result = Phlickr_User::findByEmail($this->api, 'testing@drewish.com');
        $this->assertType('Phlickr_User', $result);
        $this->assertEquals(TESTING_USER_ID, $result->getId());
    }
    function testFindByEmail_InvalidThrows() {
        try {
            $result = Phlickr_User::findByEmail($this->api, 'notreal@example.com');
        } catch (Phlickr_MethodFailureException $e) {
            return;
        }
        $this->fail("An exception should have been thrown.");
    }

    function testFindByUrl_ValidPhotosUserId() {
        $result = Phlickr_User::findByUrl($this->api, 'http://flickr.com/photos/39059360@N00/');
        $this->assertType('Phlickr_User', $result);
        $this->assertEquals(TESTING_USER_ID, $result->getId());
    }
    function testFindByUrl_ValidPeopleUserId() {
        $result = Phlickr_User::findByUrl($this->api, 'http://flickr.com/people/39059360@N00/');
        $this->assertType('Phlickr_User', $result);
        $this->assertEquals(TESTING_USER_ID, $result->getId());
    }
    function testFindByUrl_ValidPhotosName() {
        $result = Phlickr_User::findByUrl($this->api, 'http://www.flickr.com/photos/justtesting/');
        $this->assertType('Phlickr_User', $result);
        $this->assertEquals(TESTING_USER_ID, $result->getId());
    }
    function testFindByUrl_ValidPeopleName() {
        $result = Phlickr_User::findByUrl($this->api, 'http://www.flickr.com/people/justtesting/');
        $this->assertType('Phlickr_User', $result);
        $this->assertEquals(TESTING_USER_ID, $result->getId());
    }
    function testFindByUrl_InvalidThrows() {
        try {
            $result = Phlickr_User::findByUrl($this->api, 'http://www.flickr.com/photos/SOMETHING_THAT_IS_NOT_REAL/');
        } catch (Phlickr_MethodFailureException $e) {
            return;
        }
        $this->fail("An exception should have been thrown.");
    }
}

?>

