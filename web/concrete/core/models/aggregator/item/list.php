<?
defined('C5_EXECUTE') or die("Access Denied.");
class Concrete5_Model_Aggregator_Item_List extends DatabaseItemList {

	protected $itemsPerPage = 24;

	public function __construct(Aggregator $ag) {
		$this->setQuery('select agiID from AggregatorItems');
		$this->filter('agID', $ag->getAggregatorID());
		$this->filter('agiIsDeleted', 0);
	}

	public function sortByDateDescending() {
		$this->sortByMultiple('agiBatchTimestamp desc', 'agiBatchDisplayOrder asc');
	}

	public function get($itemsToGet = 10000, $offset = 0) {
		$items = array(); 
		$r = parent::get($itemsToGet, intval($offset));
		foreach($r as $row) {
			$ag = AggregatorItem::getByID($row['agiID']);
			if (is_object($ag)) {
				$items[] = $ag;
			}
		}
		return $items;
	}

}
