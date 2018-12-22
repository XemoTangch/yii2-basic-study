<?php

use yii\db\Migration;

/**
 * Handles the creation of table `bbx2018_apply`.
 */
class m181104_063540_create_bbx2018_apply_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%bbx2018_apply}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(100)->notNull()->defaultValue(''),
            'organization' => $this->string(100)->notNull()->defaultValue(''),
            'sex' => $this->tinyInteger(2)->notNull()->defaultValue(0),
            'mobile' => $this->string(20)->notNull()->defaultValue(''),
            'telephone' => $this->string(20)->notNull()->defaultValue(''),
            'email' => $this->string(200)->notNull()->defaultValue(''),
            'education' => $this->string(100)->notNull()->defaultValue(''),
            'country' => $this->string(100)->notNull()->defaultValue(''),
            'university' => $this->string(100)->notNull()->defaultValue(''),
            'major' => $this->string(100)->notNull()->defaultValue(''),
            'study_field' => $this->string(100)->notNull()->defaultValue(''),
            'project' => $this->string(100)->notNull()->defaultValue(''),
            't' => $this->string(100)->notNull()->defaultValue(''),
            'ctime' => $this->integer(11)->notNull()->defaultValue(0),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%bbx2018_apply}}');
    }
}
