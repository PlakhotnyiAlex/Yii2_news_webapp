<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%tag}}".
 *
 * @property int $id
 * @property string $slug
 * @property string $title
 *
 * @property News[] $news
 * @property TagToNews[] $tagToNews
 */
class Tag extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%tag}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['slug', 'title'], 'required'],
            [['slug', 'title'], 'string', 'max' => 256],
            [['slug'], 'unique'],
            [['title'], 'unique'],
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
        ];
    }

    /**
     * Gets query for [[News]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNews()
    {
        return $this->hasMany(News::className(), ['id' => 'news_id'])->viaTable('{{%tag_to_news}}', ['tag_id' => 'id']);
    }

    /**
     * Gets query for [[TagToNews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTagToNews()
    {
        return $this->hasMany(TagToNews::className(), ['tag_id' => 'id']);
    }
}
