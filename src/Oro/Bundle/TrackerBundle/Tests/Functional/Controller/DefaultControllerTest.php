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
        $form['orotracker_issue[reporter]'] = '1';
        $form['orotracker_issue[owner]'] = '1';

        $this->client->followRedirects(true);
        $crawler = $this->client->submit($form);

        $result = $this->client->getResponse();
        $this->assertHtmlResponseStatusCodeEquals($result, 200);
        $this->assertContains("Issue saved", $crawler->html());
    }


    public function testUpdate()
    {
        $response = $this->client->requestGrid(
            'issue-grid',
            array('issue-grid[_filter][summary][value]' => 'New Issue')
        );

        $result = $this->getJsonResponseContent($response, 200);
        $result = reset($result['data']);

        $crawler = $this->client->request(
            'GET',
            $this->getUrl('orotracker_issue_update', array('id' => $result['id']))
        );

        $form = $crawler->selectButton('Save and Close')->form();
        $form['orotracker_issue[summary]'] = 'Issue updated';
        $form['orotracker_issue[description]'] = 'Description updated';

        $this->client->followRedirects(true);
        $crawler = $this->client->submit($form);

        $result = $this->client->getResponse();
        $this->assertHtmlResponseStatusCodeEquals($result, 200);
        $this->assertContains("Issue saved", $crawler->html());
    }


    public function testView()
    {
        $response = $this->client->requestGrid(
            'issue-grid',
            array('issue-grid[_filter][summary][value]' => 'New Issue')
        );

        $result = $this->getJsonResponseContent($response, 200);
        $result = reset($result['data']);

        $this->client->request(
            'GET',
            $this->getUrl('orotracker_issue_view', array('id' => $result['id']))
        );

        $result = $this->client->getResponse();
        $this->assertHtmlResponseStatusCodeEquals($result, 200);
        $this->assertContains('General Information', $result->getContent());
    }

    public function testIndex()
    {
        $this->client->request('GET', $this->getUrl('orotracker_issue_index'));
        $result = $this->client->getResponse();
        $this->assertHtmlResponseStatusCodeEquals($result, 200);
        $this->assertContains('Create Issue', $result->getContent());
    }
}
