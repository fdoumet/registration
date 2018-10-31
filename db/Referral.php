<?php
namespace OCA\Registration\Db;

use JsonSerializable;

use OCP\AppFramework\Db\Entity;

class Referral extends Entity implements JsonSerializable {

	protected $referrer;
	protected $referreeEmail;
	protected $status;
	protected $dateCreated;

	public function jsonSerialize() {
		return [
			'id' => $this->id,
			'referrer' => $this->referrer,
			'referree_email' => $this->referreeEmail,
			'status' => $this->status,
			'date_created' => $this->dateCreated
		];
	}
}