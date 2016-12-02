<?php

/**
 * This is the model class for table "{{etraining_scorecard}}".
 *
 * The followings are the available columns in table '{{etraining_scorecard}}':
 * @property integer $id
 * @property string $category
 * @property string $measure
 * @property string $item_code
 * @property string $pea_code
 * @property string $goal_point
 * @property integer $pair
 * @property string $notes
 */
class EtrainingScorecard extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{etraining_scorecard}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('category, measure, item_code, pea_code, goal_point', 'required'),
			array('pair', 'numerical', 'integerOnly'=>true),
			array('category', 'length', 'max'=>72),
			array('measure', 'length', 'max'=>97),
			array('item_code', 'length', 'max'=>3),
			array('pea_code', 'length', 'max'=>4),
			array('goal_point', 'length', 'max'=>5),
			array('notes', 'length', 'max'=>88),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, category, measure, item_code, pea_code, goal_point, pair, notes', 'safe', 'on'=>'search'),
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
			'category' => 'Category',
			'measure' => 'Measure',
			'item_code' => 'Item Code',
			'pea_code' => 'Pea Code',
			'goal_point' => 'Goal Point',
			'pair' => 'Pair',
			'notes' => 'Notes',
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
		$criteria->compare('category',$this->category,true);
		$criteria->compare('measure',$this->measure,true);
		$criteria->compare('item_code',$this->item_code,true);
		$criteria->compare('pea_code',$this->pea_code,true);
		$criteria->compare('goal_point',$this->goal_point,true);
		$criteria->compare('pair',$this->pair);
		$criteria->compare('notes',$this->notes,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return EtrainingScorecard the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getAreaCount($rep_id, $area_no)
	{
		$count = PeaReports::model()
					->with(array(
					    'chapter'=>array(
					        // we don't want to select posts
					        'select'=>false,
					        'condition'=>'chapter.area_no = :area_no', 'params'=>array(':area_no'=>$area_no),
					    ),
					))
					->count(array('condition'=>'rep_id = :rid', 'params'=>array(':rid'=>$rep_id)));

		return $count;
	}

	public function getAreaCount2($rep_id)
	{
		$scores = array();
		$reports = PeaReports::model()->findAll(array('condition'=>'rep_id = :rid', 'params'=>array(':rid'=>$rep_id)));

		foreach($reports as $report) {
			if(!isset($scores[$report->chapter->area_no])) {
				$scores[$report->chapter->area_no] = 1;
			} else {
				$scores[$report->chapter->area_no]++;
			}
		}

		return $scores;
	}

	public function getRegionCount($rep_id, $area_no)
	{
		$scores = array();
		$reports = PeaReports::model()
					->with(array(
					    'chapter'=>array(
					        // we don't want to select posts
					        'select'=>false,
					        'condition'=>'chapter.area_no = :area_no', 'params'=>array(':area_no'=>$area_no),
					    ),
					))
					->findAll(array('condition'=>'rep_id = :rid', 'params'=>array(':rid'=>$rep_id)));

		foreach($reports as $report) {
			if(!isset($scores[$report->chapter->region_id])) {
				$scores[$report->chapter->region_id] = 1;
			} else {
				$scores[$report->chapter->region_id]++;
			}
		}

		return $scores;
	}

	public function getRegionCount2($rep_id, $region_id)
	{
		$scores = array();
		$reports = PeaReports::model()
					->with(array(
					    'chapter'=>array(
					        // we don't want to select posts
					        'select'=>false,
					        'condition'=>'chapter.region_id = :region_id', 'params'=>array(':region_id'=>$region_id),
					    ),
					))
					->findAll(array('condition'=>'rep_id = :rid', 'params'=>array(':rid'=>$rep_id)));

		foreach($reports as $report) {
			if(!isset($scores[$report->chapter->region_id])) {
				$scores[$report->chapter->region_id] = 1;
			} else {
				$scores[$report->chapter->region_id]++;
			}
		}
		
		return $scores;
	}
}
