<?php

namespace OCA\Registration\Settings;

use OCP\IL10N;
use OCP\IURLGenerator;
use OCP\IUserSession;

class PersonalSection extends Section {
	/** @var IUserSession */
	private $userSession;

	public function __construct(
		IURLGenerator $url,
		IL10N $l,
		IUserSession $userSession
	) {
		parent::__construct($url, $l);
		$this->userSession = $userSession;
	}
}
