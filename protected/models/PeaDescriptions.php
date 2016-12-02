<?php

/**
 * This is the model class for table "{{pea_descriptions}}".
 *
 * The followings are the available columns in table '{{pea_descriptions}}':
 * @property string $rep_id
 * @property integer $sub_id
 * @property string $description
 * @property integer $goal_point
 * @property integer $criteria_point
 * @property integer $max
 * @property string $qty
 * @property integer $range
 * @property string $color
 * @property string $goal
 * @property string $criteria
 * @property string $details
 * @property string $remarks
 */
class PeaDescriptions extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{pea_descriptions}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rep_id, description, goal_point, color, goal, details', 'required'),
			array('sub_id, goal_point, criteria_point, max, range, order_no', 'numerical', 'integerOnly'=>true),
			array('rep_id', 'length', 'max'=>3),
			array('rep_id', 'unique'),
			array('description', 'length', 'max'=>101),
			array('qty', 'length', 'max'=>2),
			array('color', 'length', 'max'=>5),
			array('goal', 'length', 'max'=>74),
			array('criteria', 'length', 'max'=>100),
			array('details', 'length', 'max'=>191),
			array('remarks', 'length', 'max'=>104),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('rep_id, sub_id, description, goal_point, criteria_point, max, qty, range, color, goal, criteria, details, remarks, order_no', 'safe', 'on'=>'search'),
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
			'reports' => array(self::HAS_MANY, 'PeaReports', 'rep_id'),
			'scores' => array(self::HAS_MANY, 'PeaScores', 'rep_id'),
			'score' => array(self::HAS_ONE, 'PeaScores', 'rep_id'),
			'report' => array(self::HAS_ONE, 'PeaReports', 'rep_id'),
			'subcat' => array(self::BELONGS_TO, 'PeaSubcat', 'sub_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'rep_id' => 'Rep',
			'sub_id' => 'Sub',
			'description' => 'Description',
			'goal_point' => 'Goal Point',
			'criteria_point' => 'Criteria Point',
			'max' => 'Max',
			'qty' => 'Qty',
			'range' => 'Range',
			'color' => 'Color',
			'goal' => 'Goal',
			'criteria' => 'Criteria',
			'details' => 'Details',
			'remarks' => 'Remarks',
			'order_no' => 'Order',
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

		$criteria->compare('rep_id',$this->rep_id,true);
		$criteria->compare('sub_id',$this->sub_id);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('goal_point',$this->goal_point);
		$criteria->compare('criteria_point',$this->criteria_point);
		$criteria->compare('max',$this->max);
		$criteria->compare('qty',$this->qty,true);
		$criteria->compare('range',$this->range);
		$criteria->compare('color',$this->color,true);
		$criteria->compare('goal',$this->goal,true);
		$criteria->compare('criteria',$this->criteria,true);
		$criteria->compare('details',$this->details,true);
		$criteria->compare('remarks',$this->remarks,true);
		$criteria->compare('order_no',$this->order_no);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PeaDescriptions the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public static function computeMax($sub_id)
	{
		$max_points = Yii::app()->db->createCommand()
		    ->select('sum(max) as maxSum')
		    ->from('jci_pea_descriptions')
		    ->where('sub_id = ' . $sub_id. ' AND color = "BLACK"')
		    ->queryRow();

		if($max_points['maxSum'] == null)
			return 0;
		else
			return $max_points['maxSum'];
	}

	public static function computeRaw($sub_id, $chapter_id)
	{
		$raw_points = Yii::app()->db->createCommand()
		    ->select('sum(score) as rawSum')
		    ->from('jci_pea_scores s')
		    ->join('jci_pea_descriptions d','s.rep_id = d.rep_id')
		    ->join('jci_pea_reports r','s.report_id = r.id')
		    ->where('d.sub_id = ' . $sub_id. ' AND s.chapter_id = '.$chapter_id.' AND r.status_id = 1')
		    ->queryRow();

		if($raw_points['rawSum'] == null)
			return 0;
		else
			return $raw_points['rawSum'];
	}

	public static function computeRawWoGreen($sub_id, $chapter_id)
	{
		$raw_points = Yii::app()->db->createCommand()
		    ->select('sum(score) as rawSum')
		    ->from('jci_pea_scores s')
		    ->join('jci_pea_descriptions d','s.rep_id = d.rep_id')
		    ->join('jci_pea_reports r','s.report_id = r.id')
		    ->where('d.sub_id = ' . $sub_id. ' AND (color = "BLACK" OR color = "BLUE") AND s.chapter_id = '.$chapter_id.' AND r.status_id = 1')
		    ->queryRow();

		if($raw_points['rawSum'] == null)
			return 0;
		else
			return $raw_points['rawSum'];
	}
}
