<?php
class RankScorer
{
	const BLUE = 10;
	const GREEN = 40;
	const YELLOW = 20;
	const RED = 30;
	/**
	* @var array
	*
	* Overall score of chapters
	*/
	public $scores;

	/**
	* @var array (multidimensional)
	* chapter_id -> array of scores
	* item code / pair number (if have pair/s) -> pea code & score
	* collection of scores
	*/
	private $score_collection;

	/**
	* @var array (multidimensional)
	* collection of etraining score and details
	*/
	private $etraining_scores;

	/**
	* @var array
	*
	* Complete data of chapter-> chapter name, rank and score
	*/
	public $ranking_prop;

	public function __construct($area = null, $region_id = null, $count = null)
	{	
		ScoresStorage::setup();  
		$this->etraining_scores = ScoresStorage::$scores;

		if($area == null) {
			$reports = PeaReports::model()->findAll(array('condition'=>'(status_id = 1)'));
		} elseif($region_id != null) {
			$reports = PeaReports::model()
				->with(array(
				    'chapter'=>array(
				    	'select' => false,
				        'condition' =>'chapter.region_id = :region_id',
				        'params' => array(':region_id'=>$region_id),
				    ),
				))
				->findAll(array('condition'=>'(status_id = 1)'));
		} else {
			$reports = PeaReports::model()
				->with(array(
				    'chapter'=>array(
				    	'select' => false,
				        'condition' =>'chapter.area_no = :area',
				        'params' => array(':area'=>$area),
				    ),
				))
				->findAll(array('condition'=>'(status_id = 1)'));
		}

		$this->score_collection = $this->scoreCollect($reports);
		$this->iterateChapter();
		$this->sortChapters();
		$this->getProperties($count);
	}

	public function scoreCollect($reports)
	{
		$etraining_scores = $this->etraining_scores;
		$chapter_scores = array();

		foreach($reports as $report) {
			$selected_scorecards = array();
			/*if(isset($etraining_scores[$report->rep_id])) {
				$chapter_scores[$report->chapter_id][$report->rep_id] = $etraining_scores[$report->rep_id]['score'];
			}*/
			//
			foreach($etraining_scores as $key1=>$score) {
				if (strpos($key1, $report->rep_id.':')) {
					$selected_scorecards[$key1] = $report->score->goal_status;  
				}
			}
			

			foreach($selected_scorecards as $key2=>$goal_status) {
				/*if(!isset($chapter_scores[$report->chapter_id]['total_training_reports'])) {
					$chapter_scores[$report->chapter_id]['total_training_reports'] = 0;
				}
				*/

				if(!isset($chapter_scores[$report->chapter_id][$etraining_scores[$key2]['group']]['perfect_score'])) {
					$chapter_scores[$report->chapter_id][$etraining_scores[$key2]['group']]['perfect_score'] = 0;
					$chapter_scores[$report->chapter_id][$etraining_scores[$key2]['group']]['total_score'] = 0;
					$chapter_scores[$report->chapter_id][$etraining_scores[$key2]['group']]['items'] = 0;
				}
			
				/*$chapter_scores[$report->chapter_id]['total_training_reports']++;*/
				$chapter_scores[$report->chapter_id][$etraining_scores[$key2]['group']]['items']++;
				$chapter_scores[$report->chapter_id][$etraining_scores[$key2]['group']]['perfect_score'] += $etraining_scores[$key2]['score'];
				
				if($goal_status === "Y") {
					$chapter_scores[$report->chapter_id][$etraining_scores[$key2]['group']]['total_score'] += $etraining_scores[$key2]['score'];
					$chapter_scores[$report->chapter_id][$etraining_scores[$key2]['group']][$key2] = $etraining_scores[$key2]['score'];
				} else {
					$chapter_scores[$report->chapter_id][$etraining_scores[$key2]['group']][$key2] = 0;
				}
			}
		}

		return $chapter_scores;
	}

	private function iterateChapter()
	{
		foreach($this->score_collection as $chapter=>$sc) {
			$this->scores[$chapter] = $this->sumScore($sc);
		}
	}

	private function sumScore(array $chapter_scores)
	{	
		$overall_raw_score = 0;
		$overall_percentage = 0;

		foreach($chapter_scores as $group_name=>$group_scoring) {
			$overall_raw_score += $group_scoring['total_score'];

			$raw_average = @($group_scoring['total_score'] / $group_scoring['items']);
			$perfect_average = @($group_scoring['perfect_score'] / $group_scoring['items']);
			$group_percentage = @($raw_average / $perfect_average) * 100;
			$group_equivalent = $group_percentage * $this->getGroupPerc($group_name);

			$overall_percentage += $group_equivalent;
		}
		
		return array(
			'raw_score'=>$overall_raw_score,
			'percentage'=>round($overall_percentage, 2),
		);
	}

	private function getGroupPerc($group_name)
	{
		return @(constant('self::'.$group_name) / 100);
	}

	private function sortChapters()
	{
		uasort($this->scores, function($a, $b) {
		    if($a['percentage']==$b['percentage']) 
		    	return 0;
    	
    		return ($a['percentage'] < $b['percentage']) ? 1 : -1;
		});
	}

	private function getProperties($count = null)
	{
		ChapterStorage::setup(); 
		$rank = 0;
		$chapter_count = 0;
		$prev_score = 1;

		foreach($this->scores as $chapter=>$scores) {
			$chapter_count++;	

			if($prev_score."%" !== $scores['percentage']."%") {
				$rank++;
				$prev_score = $scores['percentage'];
			}

			if($count != null) {
				if($rank > $count) {
					break;
				}
			}

			$this->ranking_prop[$chapter]['chapter_name'] = ChapterStorage::$chapters[$chapter]['name'];
			$this->ranking_prop[$chapter]['region'] = ChapterStorage::$chapters[$chapter]['region'];
			$this->ranking_prop[$chapter]['rank'] = $rank;
			$this->ranking_prop[$chapter]['percentage'] = round($scores['percentage'], 2);
			$this->ranking_prop[$chapter]['score'] = round($scores['raw_score'], 2);
		}
	}

	public function getScoreCollection()
	{
		return $this->score_collection;
	}
}