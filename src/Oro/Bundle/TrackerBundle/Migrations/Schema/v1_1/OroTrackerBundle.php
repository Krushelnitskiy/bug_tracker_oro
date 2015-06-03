<?php

namespace Oro\Bundle\TrackerBundle\Migrations\Schema\v1_1;

use Doctrine\DBAL\Schema\Schema;

use Oro\Bundle\MigrationBundle\Migration\Migration;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;

class OroTrackerBundle implements Migration
{
    /**
     * {@inheritdoc}
     */
    public function up(Schema $schema, QueryBag $queries)
    {
        self::update($schema, $queries);
    }

    public static function update(Schema $schema, QueryBag $queries)
    {
        self::createOroTrackerIssueResolutionTranslationTable($schema);
        self::createOroTrackerIssuePriorityTranslationTable($schema);
        self::createOroTrackerIssueTypeTranslationTable($schema);
    }

    /**
     * Generate table oro_tracker_type_trans
     *
     * @param Schema $schema
     */
    public function createOroTrackerIssueTypeTranslationTable(Schema $schema)
    {
        /** Generate table oro_tracker_type_trans **/
        $table = $schema->createTable('oro_tracker_type_trans');
        $table->addColumn('id', 'integer', array('autoincrement' => true));
        $table->addColumn('foreign_key', 'string', array('length' => 16));
        $table->addColumn('content', 'string', array('length' => 255));
        $table->addColumn('locale', 'string', array('length' => 8));
        $table->addColumn('object_class', 'string', array('length' => 255));
        $table->addColumn('field', 'string', array('length' => 32));
        $table->setPrimaryKey(array('id'));
        $table->addIndex(
            array('locale', 'object_class', 'field', 'foreign_key'),
            'oro_tracker_issue_type_trans_idx',
            array()
        );
        /** End of generate table oro_tracker_type_trans **/
    }

    /**
     * Generate table oro_tracker_priority_trans
     *
     * @param Schema $schema
     */
    public function createOroTrackerIssuePriorityTranslationTable(Schema $schema)
    {
        /** Generate table oro_tracker_priority_trans **/
        $table = $schema->createTable('oro_tracker_priority_trans');
        $table->addColumn('id', 'integer', array('autoincrement' => true));
        $table->addColumn('foreign_key', 'string', array('length' => 16));
        $table->addColumn('content', 'string', array('length' => 255));
        $table->addColumn('locale', 'string', array('length' => 8));
        $table->addColumn('object_class', 'string', array('length' => 255));
        $table->addColumn('field', 'string', array('length' => 32));
        $table->setPrimaryKey(array('id'));
        $table->addIndex(
            array('locale', 'object_class', 'field', 'foreign_key'),
            'oro_tracker_issue_priority_trans_idx',
            array()
        );
        /** End of generate table oro_tracker_priority_trans **/
    }

    /**
     * Generate table oro_tracker_resolution_trans
     *
     * @param Schema $schema
     */
    public function createOroTrackerIssueResolutionTranslationTable(Schema $schema)
    {
        $table = $schema->createTable('oro_tracker_resolution_trans');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('foreign_key', 'string', ['length' => 16]);
        $table->addColumn('content', 'string', ['length' => 255]);
        $table->addColumn('locale', 'string', ['length' => 8]);
        $table->addColumn('object_class', 'string', ['length' => 255]);
        $table->addColumn('field', 'string', ['length' => 32]);
        $table->setPrimaryKey(['id']);
        $table->addIndex(['locale', 'object_class', 'field', 'foreign_key'], 'btc_resolution_translation', []);
        $table->addIndex(
            array('locale', 'object_class', 'field', 'foreign_key'),
            'oro_tracker_issue_resolution_trans_idx',
            array()
        );
    }
}
