<?php

namespace backend\models;

use Yii;
use yii\behaviors\SluggableBehavior;
/**
 * This is the model class for table "{{%news}}".
 *
 * @property int $id
 * @property int|null $category_id
 * @property string $slug
 * @property string $title
 * @property string $description
 * @property int $enabled
 *
 * @property Category $category
 * @property TagToNews[] $tagToNews
 * @property Tag[] $tags
 */
class News extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%news}}';
    }
    public function behaviors()
    {
        return [
            [
                'class' => SluggableBehavior::class,
                'attribute' => 'title',
                // 'slugAttribute' => 'slug',
            ],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['enabled', 'default', 'value' => 0],

            [['title', 'description', 'enabled'], 'required'],

            [['category_id'], 'integer'],

            [['enabled'], 'boolean'],

            [['description'], 'string'],

            [['slug', 'title'], 'string', 'max' => 256],
            [['slug'], 'unique'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'category_id' => Yii::t('app', 'Category_ID'),
            'slug' => Yii::t('app', 'Slug'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'enabled' => Yii::t('app', 'Enabled'),
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * Gets query for [[TagToNews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTagToNews()
    {
        return $this->hasMany(TagToNews::className(), ['news_id' => 'id']);
    }

    /**
     * Gets query for [[Tags]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])->viaTable('{{%tag_to_news}}', ['news_id' => 'id']);
    }
}
