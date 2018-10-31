<?php
namespace OCA\Registration\Db;

use JsonSerializable;

use OCP\AppFramework\Db\Entity;

class Referral extends Entity implements JsonSerializable {

	protected $referrer;
	protected $referreeEmail;
	protected $status;
	protected $dateCreated;
	protected $hash;

	public function jsonSerialize() {
		return [
			'id' => $this->id,
			'referrer' => $this->referrer,
			'referree_email' => $this->referreeEmail,
			'status' => $this->status,
			'hash' => $this->hash,
			'date_created' => $this->dateCreated
		];
	}
}