<?php

/**
 * This is the model class for table "{{pea_summary}}".
 *
 * The followings are the available columns in table '{{pea_summary}}':
 * @property integer $id
 * @property integer $chapter_id
 * @property integer $term_year
 * @property double $overall_score
 * @property double $percentage
 * @property integer $reports_count
 * @property integer $scores_count
 * @property integer $status_id
 */
class PeaSummary extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{pea_summary}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('chapter_id, term_year, overall_score, percentage, reports_count, scores_count, status_id', 'required'),
			array('chapter_id, term_year, reports_count, scores_count, status_id', 'numerical', 'integerOnly'=>true),
			array('overall_score, percentage', 'numerical'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, chapter_id, term_year, overall_score, percentage, reports_count, scores_count, status_id', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'chapter_id' => 'Chapter',
			'term_year' => 'Term Year',
			'overall_score' => 'Overall Score',
			'percentage' => 'Percentage',
			'reports_count' => 'Reports Count',
			'scores_count' => 'Scores Count',
			'status_id' => 'Status',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('chapter_id',$this->chapter_id);
		$criteria->compare('term_year',$this->term_year);
		$criteria->compare('overall_score',$this->overall_score);
		$criteria->compare('percentage',$this->percentage);
		$criteria->compare('reports_count',$this->reports_count);
		$criteria->compare('scores_count',$this->scores_count);
		$criteria->compare('status_id',$this->status_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PeaSummary the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
