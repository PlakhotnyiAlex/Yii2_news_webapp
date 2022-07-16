<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%tag_to_news}}".
 *
 * @property int $tag_id
 * @property int $news_id
 *
 * @property News $news
 * @property Tag $tag
 */
class TagToNews extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%tag_to_news}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tag_id', 'news_id'], 'required'],
            [['tag_id', 'news_id'], 'integer'],
            [['tag_id', 'news_id'], 'unique', 'targetAttribute' => ['tag_id', 'news_id']],
            [['news_id'], 'exist', 'skipOnError' => true, 'targetClass' => News::className(), 'targetAttribute' => ['news_id' => 'id']],
            [['tag_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tag::className(), 'targetAttribute' => ['tag_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'tag_id' => Yii::t('app', 'Tag ID'),
            'news_id' => Yii::t('app', 'News ID'),
        ];
    }

    /**
     * Gets query for [[News]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNews()
    {
        return $this->hasOne(News::className(), ['id' => 'news_id']);
    }

    /**
     * Gets query for [[Tag]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTag()
    {
        return $this->hasOne(Tag::className(), ['id' => 'tag_id']);
    }
}
