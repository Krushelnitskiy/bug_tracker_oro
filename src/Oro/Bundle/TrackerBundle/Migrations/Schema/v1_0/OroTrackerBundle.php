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
        /** Tables generation **/
        $this->createOroTrackerIssueTable($schema);
        $this->createOroTrackerIssueTypeTable($schema);
        $this->createOroTrackerIssuePriorityTable($schema);
        $this->createOroTrackerIssueResolutionTable($schema);
        $this->createOroTrackerIssueCollaboratorsTable($schema);

        /** Foreign keys generation **/
        $this->addOroTrackerIssueForeignKeys($schema);
        $this->addOroTrackerIssueCollaboratorForeignKeys($schema);

        /** Add activity association */
        self::addNoteAssociations($schema, $this->noteExtension);

        $this->activityExtension->addActivityAssociation($schema, 'oro_email', 'oro_tracker_issue');

        /** Add comment relation */
    }

    /**
     * @param Schema $schema
     */
    protected function createOroTrackerIssueTable(Schema $schema)
    {
        $table = $schema->createTable('oro_tracker_issue');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('summary', 'string', ['length' => 255, 'notnull' => true]);
        $table->addColumn('description', 'string', ['length' => 255, 'notnull' => true]);
        $table->addColumn('`code`', 'string', ['notnull' => true, 'length'=>50]);
        $table->addColumn('type_id', 'integer', ['notnull' => false]);
        $table->addColumn('priority_id', 'integer', ['notnull' => false]);
        $table->addColumn('resolution_id', 'integer', ['notnull' => false]);
        $table->addColumn('reporter_id', 'integer', ['notnull' => false]);
        $table->addColumn('owner_id', 'integer', ['notnull' => false]);
        $table->addColumn('organization_id', 'integer', ['notnull' => false]);
        $table->addColumn('parent_id', 'integer', ['notnull' => false]);
        $table->addColumn('workflow_item_id', 'integer', ['notnull' => false]);
        $table->addColumn('workflow_step_id', 'integer', ['notnull' => false]);
        $table->addColumn('created_at', 'datetime', []);
        $table->addColumn('updated_at', 'datetime', []);
        $table->setPrimaryKey(['id']);
        $table->addIndex(['organization_id'], 'IDX_4E4C1B5E32C8A3DE', []);
        $table->addIndex(['type_id'], 'IDX_4E4C1B5EC54C8C93', []);
        $table->addIndex(['priority_id'], 'IDX_4E4C1B5E497B19F9', []);
        $table->addIndex(['resolution_id'], 'IDX_4E4C1B5E12A1C43A', []);
        $table->addIndex(['reporter_id'], 'IDX_4E4C1B5EE1CFE6F5', []);
        $table->addIndex(['owner_id'], 'IDX_4E4C1B5E7E3C61F9', []);
        $table->addIndex(['parent_id'], 'IDX_4E4C1B5E727ACA70', []);
        $table->addIndex(['workflow_step_id'], 'IDX_4E4C1B5E71FE882C', []);
        $table->addUniqueIndex(['code'], 'UNIQ_4E4C1B5E1E07D977');
        $table->addUniqueIndex(['workflow_item_id'], 'UNIQ_4E4C1B5E1023C4EE');
    }

    protected function createOroTrackerIssueTypeTable(Schema $schema)
    {
        $table = $schema->createTable('oro_tracker_issue_type');
        $table->addColumn('id', 'integer', ['autoincrement'=>true]);
        $table->addColumn('name', 'string', ['length'=>30]);
        $table->addColumn('label', 'string', ['notnull' => true, 'length' => 255]);
        $table->addColumn('order', 'integer', ['notnull' => true, 'default' => 0]);
        $table->setPrimaryKey(['id']);
        $table->addUniqueIndex(['name'], 'UNIQ_C6BA9029999517A');
        $table->addUniqueIndex(['label'], 'UNIQ_C6BA9029EA750E8');
    }

    protected function createOroTrackerIssuePriorityTable(Schema $schema)
    {
        $table = $schema->createTable('oro_tracker_issue_priority');
        $table->addColumn('id', 'integer', ['autoincrement'=>true]);
        $table->addColumn('`name`', 'string', ['length'=>30]);
        $table->addColumn('label', 'string', ['notnull' => true, 'length' => 255]);
        $table->addColumn('`order`', 'integer', ['notnull' => true, 'default' => 0]);
        $table->setPrimaryKey(['id']);
        $table->addUniqueIndex(['name'], 'UNIQ_61DE5ACF999517A');
        $table->addUniqueIndex(['label'], 'UNIQ_61DE5ACFEA750E8');
    }

    protected function createOroTrackerIssueResolutionTable(Schema $schema)
    {
        $table = $schema->createTable('oro_tracker_issue_resolution');
        $table->addColumn('id', 'integer', ['autoincrement'=>true]);
        $table->addColumn('`name`', 'string', ['length'=>30]);
        $table->addColumn('label', 'string', ['notnull' => true, 'length' => 255]);
        $table->addColumn('`order`', 'integer', ['notnull' => true, 'default' => 0]);
        $table->setPrimaryKey(['id']);
        $table->addUniqueIndex(['name'], 'UNIQ_6FAF5303999517A');
        $table->addUniqueIndex(['label'], 'UNIQ_6FAF5303EA750E8');
    }

    public static function addNoteAssociations(Schema $schema, NoteExtension $noteExtension)
    {
        $noteExtension->addNoteAssociation($schema, 'oro_tracker_issue');
    }

    protected function createOroTrackerIssueCollaboratorsTable(Schema $schema)
    {
        $table = $schema->createTable('oro_tracker_issue_collaborator');
        $table->addColumn('issue_id', 'integer', []);
        $table->addColumn('user_id', 'integer', []);
        $table->setPrimaryKey(['issue_id', 'user_id']);
        $table->addIndex(['user_id'], 'IDX_E8F1E4DDA76ED395');
        $table->addIndex(['issue_id'], 'IDX_E8F1E4DD5E7AA58C');
    }

    /**
     * @param Schema $schema
     */
    protected function addOroTrackerIssueForeignKeys(Schema $schema)
    {
        $table = $schema->getTable('oro_tracker_issue');

        $table->addForeignKeyConstraint(
            $schema->getTable('oro_tracker_issue'),
            ['parent_id'],
            ['id'],
            ['onDelete' => 'CASCADE']
        );

        $table->addForeignKeyConstraint(
            $schema->getTable('oro_user'),
            ['reporter_id'],
            ['id'],
            []
        );

        $table->addForeignKeyConstraint(
            $schema->getTable('oro_tracker_issue_priority'),
            ['priority_id'],
            ['id'],
            []
        );
        $table->addForeignKeyConstraint(
            $schema->getTable('oro_tracker_issue_type'),
            ['type_id'],
            ['id'],
            []
        );

        $table->addForeignKeyConstraint(
            $schema->getTable('oro_tracker_issue_resolution'),
            ['resolution_id'],
            ['id'],
            []
        );

        $table->addForeignKeyConstraint(
            $schema->getTable('oro_user'),
            ['owner_id'],
            ['id'],
            ['onDelete' => 'SET NULL']
        );
        $table->addForeignKeyConstraint(
            $schema->getTable('oro_organization'),
            ['organization_id'],
            ['id'],
            ['onDelete' => 'SET NULL', 'onUpdate' => null]
        );
    }

    /**
     * @param Schema $schema
     * @throws \Doctrine\DBAL\Schema\SchemaException
     */
    protected function addOroTrackerIssueCollaboratorForeignKeys(Schema $schema)
    {
        $table = $schema->getTable('oro_tracker_issue_collaborator');

        $table->addForeignKeyConstraint(
            $schema->getTable('oro_tracker_issue'),
            ['issue_id'],
            ['id'],
            []
        );

        $table->addForeignKeyConstraint(
            $schema->getTable('oro_user'),
            ['user_id'],
            ['id'],
            []
        );
    }
}
