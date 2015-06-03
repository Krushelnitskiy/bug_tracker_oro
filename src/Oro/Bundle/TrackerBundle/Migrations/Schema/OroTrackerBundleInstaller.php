<?php

namespace Oro\Bundle\TrackerBundle\Migrations\Schema;

use Doctrine\DBAL\Schema\Schema;

use Oro\Bundle\MigrationBundle\Migration\Installation;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;
use Oro\Bundle\EntityExtendBundle\Migration\Extension\ExtendExtension;
use Oro\Bundle\EntityExtendBundle\Migration\Extension\ExtendExtensionAwareInterface;
use Oro\Bundle\NoteBundle\Migration\Extension\NoteExtension;
use Oro\Bundle\NoteBundle\Migration\Extension\NoteExtensionAwareInterface;
use Oro\Bundle\ActivityBundle\Migration\Extension\ActivityExtension;
use Oro\Bundle\ActivityBundle\Migration\Extension\ActivityExtensionAwareInterface;
use Oro\Bundle\TrackerBundle\Migrations\Schema\v1_0\OroTrackerBundle as OroTrackerBundle_1_0;
use Oro\Bundle\TrackerBundle\Migrations\Schema\v1_1\OroTrackerBundle as OroTrackerBundle_1_1;

class OroTrackerBundleInstaller implements
    Installation,
    ExtendExtensionAwareInterface,
    NoteExtensionAwareInterface,
    ActivityExtensionAwareInterface
{
    /**
     * @var ExtendExtension
     */
    protected $extendExtension;

    /**
     * @var NoteExtension
     */
    protected $noteExtension;

    /**
     * @var ActivityExtension
     */
    protected $activityExtension;

    /**
     * {@inheritdoc}
     */
    public function setExtendExtension(ExtendExtension $extendExtension)
    {
        $this->extendExtension = $extendExtension;
    }

    /**
     * {@inheritdoc}
     */
    public function setNoteExtension(NoteExtension $noteExtension)
    {
        $this->noteExtension = $noteExtension;
    }

    /**
     * {@inheritdoc}
     */
    public function setActivityExtension(ActivityExtension $activityExtension)
    {
        $this->activityExtension = $activityExtension;
    }

    /**
     * {@inheritdoc}
     */
    public function getMigrationVersion()
    {
        return 'v1_1';
    }

    /**
     * {@inheritdoc}
     */
    public function up(Schema $schema, QueryBag $queries)
    {
        OroTrackerBundle_1_0::up($schema, $queries);
        /** Add activity association */
        self::addNoteAssociations($schema, $this->noteExtension);
        $this->activityExtension->addActivityAssociation($schema, 'oro_email', 'oro_tracker_issue');
        OroTrackerBundle_1_1::up($schema, $queries);
    }

    public static function addNoteAssociations(Schema $schema, NoteExtension $noteExtension)
    {
        $noteExtension->addNoteAssociation($schema, 'oro_tracker_issue');
    }
}
