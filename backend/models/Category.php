<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%category}}".
 *
 * @property int $id
 * @property string $slug
 * @property string $title
 * @property int $enabled
 *
 * @property News[] $news
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%category}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['slug', 'title'], 'required'],
            [['enabled'], 'integer'],
            [['slug', 'title'], 'string', 'max' => 256],
            [['slug'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'slug' => Yii::t('app', 'Slug'),
            'title' => Yii::t('app', 'Title'),
            'enabled' => Yii::t('app', 'Enabled'),
        ];
    }

    /**
     * Gets query for [[News]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNews()
    {
        return $this->hasMany(News::className(), ['category_id' => 'id']);
    }
}
