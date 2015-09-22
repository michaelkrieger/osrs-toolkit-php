<?php

namespace OpenSRS\mail;

use OpenSRS\Mail;
use OpenSRS\Exception;

class GetDomainBlockList extends Mail
{
    public $command = 'get_domain_block_list';

    public $_dataObject;
    public $_formatHolder = '';
    public $_osrsm;

    public $resultRaw;
    public $resultFormatted;
    public $resultSuccess;

    public $requiredFields = array(
        'attributes' => array(
            'domain',
            ),
        );

    public function __construct($formatString, $dataObject)
    {
        parent::__construct();

        $this->_formatHolder = $formatString;

        $command = $this->getCommand( $dataObject );

        $this->send( $dataObject, $command );
    }

    public function __destruct()
    {
        parent::__destruct();
    }
}
