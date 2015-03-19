<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 16.03.15
 * Time: 14:02
 */

namespace Oro\Bundle\TrackerBundle\Model;

use Oro\Bundle\ActivityBundle\Model\ActivityInterface;
use Oro\Bundle\ActivityBundle\Model\ExtendActivity;

class ExtendIssue implements ActivityInterface
{
    use ExtendActivity;

    /**
    *   Constructor
    */
    public function __construct()
    {

    }
}
