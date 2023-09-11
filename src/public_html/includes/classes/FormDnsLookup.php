<?php

use libAllure\Form;
use libAllure\Sanitizer;
use libAllure\ElementInput;
use libAllure\ElementSelect;

class FormDnsLookup extends Form
{
    public function __construct()
    {
        parent::__construct('formDnsLookup', 'DNS Lookup');

        $this->addElement(new ElementInput('dnsName', 'DNS Name'));
        $elRecordType = $this->addElement(new ElementSelect('recordType', 'Record type'));
        $elRecordType->addOption('All', DNS_ALL);
        $elRecordType->addOption('MX - Mail records', DNS_MX);
        $elRecordType->addOption('CNAME - Cannonical names (aka. subdomains)', DNS_CNAME);
        $elRecordType->addOption('A - IPV4 Addresses', DNS_A);
        $elRecordType->addOption('AAAA - IPV6 Addresses', DNS_AAAA);

        $this->addDefaultButtons('lookup');
    }

    public function process()
    {
        $sanitizer = new Sanitizer();

        $this->result = array();

        foreach (dns_get_record($sanitizer->filterString('dnsName'), $this->getElementValue('recordType')) as $result) {
            $this->result[] = $result;
        }
    }

    public function renderOutput($tpl)
    {
        $tpl->assign('rows', $this->result);
        $tpl->display('dnsQueryResults.tpl');
    }
}
