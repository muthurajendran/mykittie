<?php

/**
 * This is the model class for table "sliders".
 *
 * The followings are the available columns in table 'sliders':
 * @property integer $id
 * @property string $name
 * @property integer $category_id
 * @property string $description
 * @property integer $is_published
 * @property string $created_at
 *
 * The followings are the available model relations:
 * @property Categories $category
 */

class Sliders extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'sliders';
	}

	public $category_search;

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('category_id, is_published', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>512),
			array('description', 'length', 'max'=>4096),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, category_id, description, is_published, category_search', 'safe', 'on'=>'search'),
		);
	}



	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'category' => array(self::BELONGS_TO, 'Categories', 'category_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'category_id' => 'Category',
			'description' => 'Description',
			'is_published' => 'Is Published',
			'created_at' => 'Created At',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->with = array('category');

		//die(var_dump($this->category_search));


		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('category_id',$this->category_id);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('is_published',$this->is_published);
		$criteria->compare( 'category.name', $this->category_search, true );

		$criteria->compare('created_at',$this->created_at,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}



	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Sliders the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
