<?php

namespace Oro\Bundle\TrackerBundle\Tests\Controller;

use Oro\Bundle\TestFrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function setUp()
    {
        $this->initClient(array(),  $this->generateBasicAuthHeader());
    }

    public function testCreate()
    {
        $crawler = $this->client->request('GET', $this->getUrl('orotracker_issue_create'));

        $form = $crawler->selectButton('Save and Close')->form();
        $form['orotracker_issue[summary]'] = 'New Issue';
        $form['orotracker_issue[description]'] = 'New description';

//        $form['orocrm_task[owner]'] = '1';

        $this->client->followRedirects(true);
        $crawler = $this->client->submit($form);

        $result = $this->client->getResponse();
        $this->assertHtmlResponseStatusCodeEquals($result, 200);
        $this->assertContains("Issue saved", $crawler->html());
    }

    public function viewIndex()
    {

    }

    public function testIndex()
    {
        $this->client->request('GET', $this->getUrl('orotracker_issue_index'));
        $result = $this->client->getResponse();
        $this->assertHtmlResponseStatusCodeEquals($result, 200);
        $this->assertContains('Create Issue', $result->getContent());
    }
}
