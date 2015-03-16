<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 16.03.15
 * Time: 16:36
 */

namespace Oro\Bundle\TrackerBundle\Tests\Unit\Entity;

use Oro\Bundle\TrackerBundle\Entity\Issue;

class IssueTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        new Issue();
    }

}