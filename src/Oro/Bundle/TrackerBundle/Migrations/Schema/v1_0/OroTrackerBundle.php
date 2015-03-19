<?php

namespace Oro\Bundle\TrackerBundle\Migrations\Schema\v1_0;

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

        $this->createOroTrackerIssueTable($schema);
        $this->createOroTrackerIssueTypeTable($schema);
        $this->createOroTrackerIssuePriorityTable($schema);
        $this->createOroTrackerIssueResolutionTable($schema);
        $this->createOroTrackerIssueCollaboratorsTable($schema);
    }

    protected function  createOroTrackerIssueTable(Schema $schema)
    {
        $table = $schema->createTable('oro_tracker_issue');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('summary', 'string', ['notnull' => false, 'length' => 255]);
        $table->addColumn('description', 'text', ['notnull' => false]);
        $table->addColumn('code', 'string', ['notnull' => false, 'length'=>50]);
        $table->addColumn('type_id', 'integer', ['notnull' => false]);
        $table->addColumn('priority_id', 'integer', ['notnull' => false]);
        $table->addColumn('resolution_id', 'integer', ['notnull' => false]);
        $table->addColumn('reporter_id', 'integer', ['notnull' => false]);
        $table->addColumn('assignee_id', 'integer', ['notnull' => false]);
        $table->addColumn('parent_id', 'integer', ['notnull' => false]);
        $table->addColumn('created', 'datetime', []);
        $table->addColumn('updated', 'datetime', []);
        $table->setPrimaryKey(['id']);
    }

    protected function createOroTrackerIssueTypeTable(Schema $schema)
    {
        $table = $schema->createTable('oro_tracker_issue_type');
        $table->addColumn('name', 'string', ['length'=>30]);
        $table->addColumn('label', 'string', ['notnull' => true, 'length' => 255]);
        $table->addColumn('order', 'integer', ['notnull' => true, 'default' => 0]);
        $table->setPrimaryKey(['name']);
    }

    protected  function createOroTrackerIssuePriorityTable(Schema $schema)
    {
        $table = $schema->createTable('oro_tracker_issue_type');
        $table->addColumn('id',    'integer', ['autoincrement'=>true]);
        $table->addColumn('name',  'string',  ['length'=>255]);
        $table->addColumn('label', 'string',  ['notnull' => true, 'length' => 255]);
        $table->addColumn('order', 'integer', ['notnull' => true, 'default' => 0]);
        $table->setPrimaryKey(['id']);
    }

    protected function createOroTrackerIssueResolutionTable(Schema $schema)
    {
        $table = $schema->createTable('oro_tracker_issue_resolution');
        $table->addColumn('id',    'integer', ['autoincrement'=>true]);
        $table->addColumn('name',  'string',  ['length'=>255]);
        $table->addColumn('label', 'string',  ['notnull' => true, 'length' => 255]);
        $table->addColumn('order', 'integer', ['notnull' => true, 'default' => 0]);
        $table->setPrimaryKey(['id']);
    }

    protected function createOroTrackerIssueCollaboratorsTable(Schema $schema)
    {
        $table = $schema->createTable('oro_tracker_issue_collaborator');
        $table->addColumn('issue_id', 'integer', []);
        $table->addColumn('user_id',  'integer',  []);
        $table->addUniqueIndex(['user_id'], 'IDX_COLLABORATOR_USER');
        $table->addUniqueIndex(['issue_id'], 'IDX_COLLABORATOR_ISSUE');
    }
}
