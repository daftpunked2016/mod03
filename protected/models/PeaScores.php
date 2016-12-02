<?php

/**
 * This is the model class for table "{{pea_scores}}".
 *
 * The followings are the available columns in table '{{pea_scores}}':
 * @property integer $id
 * @property integer $account_id
 * @property integer $chapter_id
 * @property integer $rep_id
 * @property string $goal_status
 * @property string $criteria_status
 * @property integer $qty
 * @property double $score
 * @property string $date_created
 */
class PeaScores extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{pea_scores}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('account_id, chapter_id, rep_id, goal_status, criteria_status, qty, score, date_created', 'required'),
			array('account_id, report_id, chapter_id, qty', 'numerical', 'integerOnly'=>true),
			array('score', 'numerical'),
			array('goal_status, criteria_status', 'length', 'max'=>1),
			array('rep_id', 'length', 'max'=>3),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, report_id, account_id, chapter_id, rep_id, goal_status, criteria_status, qty, score, date_created', 'safe', 'on'=>'search'),
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
			'report' => array(self::BELONGS_TO, 'PeaReports', 'report_id', 'condition'=>'report.status_id != 6'),
			'description' => array(self::BELONGS_TO, 'PeaDescriptions', 'rep_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'account_id' => 'Account',
			'chapter_id' => 'Chapter',
			'rep_id' => 'Rep',
			'goal_status' => 'Goal Status',
			'criteria_status' => 'Criteria Status',
			'qty' => 'Qty',
			'score' => 'Score',
			'date_created' => 'Date Created',
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
		$criteria->compare('account_id',$this->account_id);
		$criteria->compare('chapter_id',$this->chapter_id);
		$criteria->compare('rep_id',$this->rep_id);
		$criteria->compare('goal_status',$this->goal_status,true);
		$criteria->compare('criteria_status',$this->criteria_status,true);
		$criteria->compare('qty',$this->qty);
		$criteria->compare('score',$this->score);
		$criteria->compare('date_created',$this->date_created,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	//desc_gp = goal point, desc_cp = criteria point
	public function computeScore($rep_id, $g, $q, $c, $desc_qty, $desc_range, $desc_gp, $desc_cp, $desc_max)
	{
		$score = 0; 

		switch($rep_id) {
			case "A6":
			case "A8":
				if($g === "Y") 
				{
					$score = PeaScores::model()->conditionCompute($rep_id, $q, $desc_range, $desc_max, $desc_gp, $desc_cp);
				}
				break;
			case "H1":
			case "H20":
			case "H24":
			case "K2":
			case "K3":
			case "O4":
				if($g === "Y") 
				{
					$score = PeaScores::model()->divisionCompute($rep_id, $q, $desc_range, $desc_max, $desc_gp);
				} 
				break;
			default:
				if($g === "Y") 
				{
					if($desc_qty === "T") 
					{ 
						$compute = 0;

						if($q >= $desc_range)
						{
							$compute = ($desc_range * $desc_gp);
						}
						else
						{
							$compute = ($q * $desc_gp);
						}

						$score = $compute;
					} 
					else 
					{
						if($c === "Y") 
						{
							$score = $desc_max;
						} 
						else
						{
							if($desc_cp == 0)
							{
								$score = $desc_gp;	
							}
							else 
							{
								$score = $desc_cp;	
							}
						}
					}
				}
		}


		return $score;
	}

	public function divisionCompute($rep_id, $q, $desc_range, $desc_max, $desc_gp)
	{
		$score = 0;
		$divisor = 0;

		switch($rep_id) {
			case "H1":
				$divisor = 5;
				break;
			case "H20":
			case "H24":
			case "K2":
			case "K3":
			case "O4":
				$divisor = 2000;
				break;
			default:
				$divisor = 0;
		}

		if($q >= $desc_range) {
			$score = $desc_max;
		} else {
			$score = (((int)($q/$divisor)) * $desc_gp);
		}

		return $score;
	}

	public function conditionCompute($rep_id, $q, $desc_range, $desc_max, $desc_gp, $desc_cp)
	{
		$score = 0;

		switch($rep_id) {
			case "A6":
			case "A8":
				if($q >= $desc_range){
					$score = $desc_gp;
				} else {
					if($q >= 20 && $q < 25) {
						$score = $desc_gp;
					} elseif ($q >=10 && $q < 19) {
						$score = $desc_cp;
					}
				}
				break;
			default:
				$score = 0;
		}

		return $score;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PeaScores the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
