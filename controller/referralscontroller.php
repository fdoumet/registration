<?php

namespace OCA\Registration\Controller;


use OCA\Registration\Service\MailService;
use OCA\Registration\Service\ReferralsService;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http;
use OCP\AppFramework\Http\DataResponse;
use OCP\IL10N;
use OCP\IRequest;
use OCP\IURLGenerator;

class ReferralsController extends Controller {
	/** @var IL10N */
	private $l10n;
	/** @var IURLGenerator */
	private $urlgenerator;
	/** @var ReferralsService */
	private $referralsService;
	/** @var MailService */
	private $mailService;
	/** @var String */
	private $userId;


	public function __construct(
		$appName,
		IRequest $request,
		IL10N $l10n,
		IURLGenerator $urlgenerator,
		ReferralsService $referralsService,
		MailService $mailService,
		$UserId
	){
		parent::__construct($appName, $request);
		$this->l10n = $l10n;
		$this->urlgenerator = $urlgenerator;
		$this->referralsService = $referralsService;
		$this->mailService = $mailService;
		$this->userId = $UserId;
	}

	/**
	 * @NoCSRFRequired
	 * @PublicPage
	 * @UseSession
	 *
	 */
	public function newReferral() {
		$email = $this->request->getParam('email');
		$this->referralsService->insertOrUpdate($this->userId, $email, 0);

		return new DataResponse("", Http::STATUS_OK);
	}
}