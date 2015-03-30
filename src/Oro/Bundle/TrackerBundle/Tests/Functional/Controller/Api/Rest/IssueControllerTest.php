<?php

namespace Oro\Bundle\TrackerBundle\Tests\Functional\Controller\Api\Rest;

use Oro\Bundle\TestFrameworkBundle\Test\WebTestCase;
use Oro\Bundle\TrackerBundle\Entity\Issue;
use Oro\Bundle\TrackerBundle\Entity\Type;
use Oro\Bundle\TrackerBundle\Entity\Priority;
use Oro\Bundle\TrackerBundle\Entity\Resolution;

/**
 * @outputBuffering enabled
 * @dbIsolation
 * @dbReindex
 */
class IssueControllerTest extends WebTestCase
{

    protected $client;

    /** @var array */
    protected $issue = [
        'owner' => null,
        'reporter' => null,
        'priority' => 2,
        'summary' => 'New summary',
        'description' => 'New description',
        'type' => 1
    ];

    protected function setUp()
    {
        $this->initClient([], $this->generateWsseAuthHeader());

        $owner = $this->getContainer()->get('doctrine')
                ->getRepository('OroUserBundle:User')->findOneBy(['username' => self::USER_NAME])->getId();

        $this->assertNotEmpty($owner);

        $type = $this->getContainer()->get('doctrine')->getRepository('OroTrackerBundle:Type')
            ->findOneByName(Type::TYPE_TASK);
        $priority = $this->getContainer()->get('doctrine')->getRepository('OroTrackerBundle:Priority')
            ->findOneByName(Priority::PRIORITY_MINOR);

        $this->issue['owner']  = $owner;
        $this->issue['reporter'] = $owner;
        $this->issue['type'] = $type->getId();
        $this->issue['priority'] = $priority->getId();
    }


    /**
     * @return array
     */
    public function testCreate()
    {
        $request = [
            'issue' => $this->issue
        ];

        $this->client->request('POST', $this->getUrl('orotracker_api_post_issue'), $request);

        $response = $this->getJsonResponseContent($this->client->getResponse(), 201);

        $this->assertArrayHasKey('id', $response);

        return $response['id'];
    }

    public function testCget()
    {
        $this->client->request(
            'GET',
            $this->getUrl('orotracker_api_get_issues'),
            [],
            [],
            $this->generateWsseAuthHeader()
        );

        $issues = $this->getJsonResponseContent($this->client->getResponse(), 200);

        $this->assertCount(1, $issues);
    }

    /**
     * @depends testCreate
     * @param integer $id
     * @return array
     */
    public function testGet($id)
    {
        $this->client->request(
            'GET',
            $this->getUrl('orotracker_api_get_issue', ['id' => $id]),
            [],
            [],
            $this->generateWsseAuthHeader()
        );

        $issue = $this->getJsonResponseContent($this->client->getResponse(), 200);

        $this->assertArrayIntersectEquals(
            [
                'owner' => $this->issue['owner'],
                'summary' => 'New summary',
                'description' => 'New description'
            ],
            $issue
        );
    }

    /**
     * @depends testCreate
     *
     * @param integer $id
     */
    public function testPut($id)
    {
        $updatedIssue = array_merge($this->issue, ['summary' => 'Updated summary']);
        $this->client->request('PUT', $this->getUrl('orotracker_api_put_issue', ['id' => $id]), $updatedIssue);
        $result = $this->client->getResponse();
        $this->assertEmptyResponseStatusCodeEquals($result, 204);

        $this->client->request('GET', $this->getUrl('orotracker_api_get_issue', ['id' => $id]));

        $task = $this->getJsonResponseContent($this->client->getResponse(), 200);
        $this->assertEquals('Updated summary', $task['summary']);
        $this->assertEquals($updatedIssue['summary'], $task['summary']);
    }


    /**
     * @depends testCreate
     *
     * @param integer $id
     */
    public function testDelete($id)
    {
        $this->client->request('DELETE', $this->getUrl('orotracker_api_delete_issue', ['id' => $id]));
        $result = $this->client->getResponse();
        $this->assertEmptyResponseStatusCodeEquals($result, 204);

        $this->client->request('GET', $this->getUrl('orotracker_api_get_issue', ['id' => $id]));
        $result = $this->client->getResponse();
        $this->assertJsonResponseStatusCodeEquals($result, 404);
    }

//
//    /**
//     * @depends testCreate
//     */
//    public function testCget()
//    {
//        $this->client->request('GET', $this->getUrl('orocrm_api_get_tasks'));
//        $tasks = $this->getJsonResponseContent($this->client->getResponse(), 200);
//
//        $this->assertCount(1, $tasks);
//    }
//
//    /**
//     * @depends testCreate
//     */
//    public function testCgetFiltering()
//    {
//        $baseUrl = $this->getUrl('orocrm_api_get_tasks');
//
//        $date     = '2014-03-04T20:00:00+0000';
//        $ownerId  = $this->task['owner'];
//        $randomId = rand($ownerId + 1, $ownerId + 100);
//
//        $this->client->request('GET', $baseUrl . '?createdAt>' . $date);
//        $this->assertCount(1, $this->getJsonResponseContent($this->client->getResponse(), 200));
//
//        $this->client->request('GET', $baseUrl . '?createdAt<' . $date);
//        $this->assertEmpty($this->getJsonResponseContent($this->client->getResponse(), 200));
//
//        $this->client->request('GET', $baseUrl . '?ownerId=' . $ownerId);
//        $this->assertCount(1, $this->getJsonResponseContent($this->client->getResponse(), 200));
//
//        $this->client->request('GET', $baseUrl . '?ownerId=' . $randomId);
//        $this->assertEmpty($this->getJsonResponseContent($this->client->getResponse(), 200));
//
//        $this->client->request('GET', $baseUrl . '?ownerUsername=' . self::USER_NAME);
//        $this->assertCount(1, $this->getJsonResponseContent($this->client->getResponse(), 200));
//
//        $this->client->request('GET', $baseUrl . '?ownerUsername<>' . self::USER_NAME);
//        $this->assertEmpty($this->getJsonResponseContent($this->client->getResponse(), 200));
//    }
//
//    /**
//     * @depends testCreate
//     *
//     * @param integer $id
//     */
//    public function testGet($id)
//    {
//        $this->client->request('GET', $this->getUrl('orocrm_api_get_task', ['id' => $id]));
//        $task = $this->getJsonResponseContent($this->client->getResponse(), 200);
//
//        $this->assertEquals($this->task['subject'], $task['subject']);
//    }
//
//    /**
//     * @depends testCreate
//     *
//     * @param integer $id
//     */
//    public function testPut($id)
//    {
//        $updatedTask = array_merge($this->task, ['subject' => 'Updated subject']);
//        $this->client->request('PUT', $this->getUrl('orocrm_api_put_task', ['id' => $id]), $updatedTask);
//        $result = $this->client->getResponse();
//        $this->assertEmptyResponseStatusCodeEquals($result, 204);
//
//        $this->client->request('GET', $this->getUrl('orocrm_api_get_task', ['id' => $id]));
//
//        $task = $this->getJsonResponseContent($this->client->getResponse(), 200);
//
//        $this->assertEquals('Updated subject', $task['subject']);
//        $this->assertEquals($updatedTask['subject'], $task['subject']);
//    }
//
//    /**
//     * @depends testCreate
//     *
//     * @param integer $id
//     */
//    public function testDelete($id)
//    {
//        $this->client->request('DELETE', $this->getUrl('orocrm_api_delete_task', ['id' => $id]));
//        $result = $this->client->getResponse();
//        $this->assertEmptyResponseStatusCodeEquals($result, 204);
//
//        $this->client->request('GET', $this->getUrl('orocrm_api_get_task', ['id' => $id]));
//        $result = $this->client->getResponse();
//        $this->assertJsonResponseStatusCodeEquals($result, 404);
//    }
}
