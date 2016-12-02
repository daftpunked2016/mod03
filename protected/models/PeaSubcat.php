<?php

/**
 * This is the model class for table "{{pea_subcat}}".
 *
 * The followings are the available columns in table '{{pea_subcat}}':
 * @property integer $sub_id
 * @property integer $cat_id
 * @property string $SubCat
 */
class PeaSubcat extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{pea_subcat}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sub_id, cat_id, SubCat', 'required'),
			array('sub_id, cat_id', 'numerical', 'integerOnly'=>true),
			array('SubCat', 'length', 'max'=>91),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('sub_id, cat_id, SubCat', 'safe', 'on'=>'search'),
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
			'category' => array(self::BELONGS_TO, 'PeaCategory', 'cat_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'sub_id' => 'Sub',
			'cat_id' => 'Cat',
			'SubCat' => 'Sub Cat',
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

		$criteria->compare('sub_id',$this->sub_id);
		$criteria->compare('cat_id',$this->cat_id);
		$criteria->compare('SubCat',$this->SubCat,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PeaSubcat the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getSubCat($id)
	{
		$desc = PeaDescriptions::model()->findByPk($id);

		return $desc->subcat->SubCat;
	}
}
