<?php

namespace OCA\Registration\Settings;

use OCA\Registration\Service\ReferralsService;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\IUserSession;
use OCP\Settings\ISettings;

class Personal implements ISettings {

	/** @var IUserSession */
	private $userSession;
	private $referralsService;

	public function __construct(
		IUserSession $userSession,
		ReferralsService $referralsService
	) {
		$this->userSession = $userSession;
		$this->referralsService = $referralsService;
	}

	/**
	 * @return TemplateResponse
	 */
	public function getForm() {
		$uid = $this->userSession->getUser()->getUID();
		$userReferrals = $this->referralsService->findAllForUser($uid);

		$parameters = [
			'referrals'    => $userReferrals,
		];

		return new TemplateResponse('registration', 'new_referral_form', $parameters);  // templates/index.php
	}

	/**
	 * @return string the section ID, e.g. 'payments'
	 */
	public function getSection() {
		return 'referrals';
	}

	/**
	 * @return int whether the form should be rather on the top or bottom of
	 * the admin section. The forms are arranged in ascending order of the
	 * priority values. It is required to return a value between 0 and 100.
	 *
	 * E.g.: 70
	 */
	public function getPriority() {
		return 40;
	}

}
