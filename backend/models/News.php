<?php

namespace backend\models;

use Yii;
use yii\behaviors\SluggableBehavior;
use yii\helpers\ArrayHelper;
use yii\validators\RequiredValidator;
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
    public $formTag = [];
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
    public function afterFind()
    {
        parent::afterFind();

        // populates related tags data for formTag
        $this->formTag = ArrayHelper::getColumn($this->tags, 'title');
    }

    /**
     * @param bool $runValidation
     * @param null $attributeNames
     * @return bool
     * @throws \Exception
     */
    public function save($runValidation = true, $attributeNames = null)
    {
        $transaction = Yii::$app->db->beginTransaction();

        try {
            if (! parent::save($runValidation, $attributeNames)) {
                return false;
            }

            // Handle tags
            if (! $this->saveTags()) {
                return false;
            }

            $transaction->commit();

        } catch (\Exception $e) {
            $transaction->rollBack();

            throw $e;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function saveTags()
    {
        // removes old tag records
        $this->unlinkAll('tagToNews', true);

        // adds new tag records;
        foreach ($this->formTag as $tagTitle) {
            $tag = Tag::findOne(['title' => $tagTitle]);

            if (! $tag) {
                $tag = new Tag();
                $tag->title = $tagTitle;

                if (! $tag->save()) {
                    return false;
                }
            }

            $this->link('tags', $tag);
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['enabled', 'default', 'value' => 0],

            [['title', 'description', 'enabled'], RequiredValidator::class],

            [['category_id'], 'integer'],

            [['enabled'], 'boolean'],

            [['description'], 'string'],

            [['slug', 'title'], 'string', 'max' => 256],
            [['slug'], 'unique'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
            ['formTag', 'filter', 'filter' => function ($value) {
                return !empty($value) ? ArrayHelper::toArray($value) : [];
            }],
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
