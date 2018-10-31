<?php

namespace OCA\Registration\Controller;


use OCA\Registration\Service\MailService;
use OCA\Registration\Service\ReferralsService;
use OCA\Registration\Service\RegistrationException;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http;
use OCP\AppFramework\Http\DataResponse;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\IL10N;
use OCP\ILogger;
use OCP\IRequest;
use OCP\IURLGenerator;
use OCP\IUserManager;

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
	/** @var IUserManager */
	private $userManager;
	/** @var ILogger */
	private $logger;


	public function __construct(
		$appName,
		IRequest $request,
		IL10N $l10n,
		IURLGenerator $urlgenerator,
		ReferralsService $referralsService,
		MailService $mailService,
		IUserManager $userManager,
		ILogger $logger,
		$UserId
	){
		parent::__construct($appName, $request);
		$this->l10n = $l10n;
		$this->urlgenerator = $urlgenerator;
		$this->referralsService = $referralsService;
		$this->mailService = $mailService;
		$this->userId = $UserId;
		$this->userManager = $userManager;
		$this->logger = $logger;
	}

	/**
	 * @NoCSRFRequired
	 * @PublicPage
	 * @UseSession
	 *
	 */
	public function newReferral() {
		$email = $this->request->getParam('email');

		$existingUsers = $this->userManager->getByEmail($email);
		if (!empty($existingUsers)) {
			$this->logger->error('Referral not sent, user already exists.');
			return;
		}
		
		$invitedUsers = $this->referralsService->findByEmail($email);
		if (!empty($invitedUsers)) {
			$this->logger->error('Referral not sent, user already invited.');
			return;
		}

		$referral = $this->referralsService->insertOrUpdate($this->userId, $email, 0);

		try {
			$this->mailService->sendReferralByMail($referral);
		} catch (RegistrationException $e) {
			return $this->renderError($e->getMessage(), $e->getHint());
		}

		return new DataResponse("", Http::STATUS_OK);
	}

	private function renderError($error, $hint="") {
		return new TemplateResponse('', 'error', array(
			'errors' => array(array(
				'error' => $error,
				'hint' => $hint
			))
		), 'error');
	}
}