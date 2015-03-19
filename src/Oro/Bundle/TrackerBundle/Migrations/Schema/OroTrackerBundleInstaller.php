<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 16.03.15
 * Time: 18:24
 */

namespace Oro\Bundle\TrackerBundle\Migrations\Schema;

use Doctrine\DBAL\Schema\Schema;

//use Oro\Bundle\ActivityBundle\Migration\Extension\ActivityExtension;
//use Oro\Bundle\ActivityBundle\Migration\Extension\ActivityExtensionAwareInterface;
//use Oro\Bundle\CommentBundle\Migration\Extension\CommentExtension;
//use Oro\Bundle\CommentBundle\Migration\Extension\CommentExtensionAwareInterface;
use Oro\Bundle\MigrationBundle\Migration\Installation;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;

class OroTrackerBundleInstaller implements Installation
{

    /**
     * {@inheritdoc}
     */
    public function getMigrationVersion()
    {
        return 'v1_0';
    }

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

//      $this->createOrocrmTaskPriorityTable($schema);

        /** Foreign keys generation **/
//        $this->addOrocrmTaskForeignKeys($schema);

        /** Add activity association */

        /** Add comment relation */
    }

    /**
     * @param Schema $schema
     */
    protected function createOroTrackerIssueTable(Schema $schema)
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
        $table->addColumn('workflow_item_id', 'integer', ['notnull' => false]);
        $table->addColumn('workflow_step_id', 'integer', ['notnull' => false]);
        $table->addColumn('created', 'datetime', []);
        $table->addColumn('updated', 'datetime', []);
        $table->setPrimaryKey(['id']);
    }

    protected function createOroTrackerIssueTypeTable(Schema $schema)
    {
        $table = $schema->createTable('oro_tracker_issue_type');
        $table->addColumn('id',    'integer', ['autoincrement'=>true]);
        $table->addColumn('name', 'string', ['length'=>30]);
        $table->addColumn('label', 'string', ['notnull' => true, 'length' => 255]);
        $table->addColumn('order', 'integer', ['notnull' => true, 'default' => 0]);
        $table->setPrimaryKey(['id']);
    }

    protected  function createOroTrackerIssuePriorityTable(Schema $schema)
    {
        $table = $schema->createTable('oro_tracker_issue_priority');
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

    /**
     * @param Schema $schema
     */
//    protected function createOrocrmTaskPriorityTable(Schema $schema)
//    {
//        $table = $schema->createTable('orocrm_task_priority');
//        $table->addColumn('name', 'string', ['notnull' => true, 'length' => 32]);
//        $table->addColumn('label', 'string', ['notnull' => true, 'length' => 255]);
//        $table->addColumn('`order`', 'integer', ['notnull' => true]);
//        $table->setPrimaryKey(['name']);
//        $table->addUniqueIndex(['label'], 'UNIQ_DB8472D3EA750E8');
//    }

//    /**
//     * @param Schema $schema
//     */
//    protected function addOrocrmTaskForeignKeys(Schema $schema)
//    {
//        $table = $schema->getTable('orocrm_task');
//        $table->addForeignKeyConstraint(
//            $schema->getTable('orocrm_task_priority'),
//            ['task_priority_name'],
//            ['name'],
//            ['onDelete' => 'SET NULL']
//        );
//        $table->addForeignKeyConstraint(
//            $schema->getTable('oro_user'),
//            ['owner_id'],
//            ['id'],
//            ['onDelete' => 'SET NULL']
//        );
//        $table->addForeignKeyConstraint(
//            $schema->getTable('oro_organization'),
//            ['organization_id'],
//            ['id'],
//            ['onDelete' => 'SET NULL', 'onUpdate' => null]
//        );
//        $table->addForeignKeyConstraint(
//            $schema->getTable('oro_workflow_item'),
//            ['workflow_item_id'],
//            ['id'],
//            ['onDelete' => 'SET NULL']
//        );
//        $table->addForeignKeyConstraint(
//            $schema->getTable('oro_workflow_step'),
//            ['workflow_step_id'],
//            ['id'],
//            ['onDelete' => 'SET NULL']
//        );
//    }
}
