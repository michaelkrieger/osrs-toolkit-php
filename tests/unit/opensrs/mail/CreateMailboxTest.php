<?php

namespace OpenSRS\mail;

use OpenSRS\mail\CreateMailbox;
/**
 * @group mail
 * @group MailCreateMailbox
 */
class CreateMailboxTest extends \PHPUnit_Framework_TestCase
{
    protected $validSubmission = array(
        'attributes' => array(
            'admin_username' => '',
            'admin_password' => '',
            'admin_domain' => '',
            'domain' => '',
            'workgroup' => '',
            'mailbox' => '',
            'password' => '',
            ),
        );

    /**
     * Valid submission should complete with no
     * exception thrown
     *
     * @return void
     *
     * @group validsubmission
     */
    public function testValidSubmission() {
        $data = json_decode( json_encode($this->validSubmission ) );

        $data->attributes->admin_username = 'phptest' . time();
        $data->attributes->admin_password = 'password1234';
        $data->attributes->admin_domain = 'mail.phptest' . time() . '.com';
        $data->attributes->domain = 'new-' . $data->attributes->admin_domain;
        $data->attributes->workgroup = "phptest-workgroup-" . time();
        $data->attributes->mailbox = "phptest" . time();
        $data->attributes->password = "password1234";

        $ns = new CreateMailbox( 'array', $data );

        $this->assertTrue( $ns instanceof CreateMailbox );
    }

    /**
     * Data Provider for Invalid Submission test
     */
    function submissionFields() {
        return array(
            'missing admin_username' => array('admin_username'),
            'missing admin_password' => array('admin_password'),
            'missing admin_domain' => array('admin_domain'),
            'missing domain' => array('domain'),
            'missing workgroup' => array('workgroup'),
            'missing mailbox' => array('mailbox'),
            'missing password' => array('password'),
            );
    }

    /**
     * Invalid submission should throw an exception
     *
     * @return void
     *
     * @dataProvider submissionFields
     * @group invalidsubmission
     */
    public function testInvalidSubmissionFieldsMissing( $field, $parent = 'attributes', $message = null ) {
        $data = json_decode( json_encode($this->validSubmission ) );

        $data->attributes->admin_username = 'phptest' . time();
        $data->attributes->admin_password = 'password1234';
        $data->attributes->admin_domain = 'mail.phptest' . time() . '.com';
        $data->attributes->domain = 'new-' . $data->attributes->admin_domain;
        $data->attributes->workgroup = "phptest-workgroup-" . time();
        $data->attributes->mailbox = "phptest" . time();
        $data->attributes->password = "password1234";
        
        if(is_null($message)){
          $this->setExpectedExceptionRegExp(
              'OpenSRS\Exception',
              "/$field.*not defined/"
              );
        }
        else {
          $this->setExpectedExceptionRegExp(
              'OpenSRS\Exception',
              "/$message/"
              );
        }



        // clear field being tested
        if(is_null($parent)){
            unset( $data->$field );
        }
        else{
            unset( $data->$parent->$field );
        }

        $ns = new CreateMailbox( 'array', $data );
    }
}
