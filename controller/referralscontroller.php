<?php

namespace OCA\Registration\Controller;

require_once __DIR__ . '/../service/ReferralsService.php';

use OCA\Registration\Db\Referral;
use OCA\Registration\Db\Registration;
use OCA\Registration\Service\MailService;
use OCA\Registration\Service\ReferralsService;
use OCA\Registration\Service\RegistrationException;
use OCA\Registration\Service\RegistrationService;
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
	/** @var RegistrationService */
	private $registrationService;
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
		RegistrationService $registrationService,
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
		$this->registrationService = $registrationService;
	}

	/**
	 * @NoCSRFRequired
	 * @PublicPage
	 * @UseSession
	 *
	 */
	public function newReferral() {
		$email = $this->request->getParam('email');
		$validReferral = $this->isValidReferral($email);

		// Make sure we don't duplicated referrals
		if (!$validReferral){
			$error = 'Referral not sent. Referral already exists';
			$this->logger->error($error);
			return new DataResponse(['status' => 'failure', 'data' => ['message' => $error]], Http::STATUS_OK);
		}

		// Insert this referral in the database
		$referral = $this->referralsService->insert($this->userId, $email, 0);

		// Notify referree
		try {
			$this->mailService->sendReferralByMail($referral);
		} catch (RegistrationException $e) {
			return $this->renderError($e->getMessage(), $e->getHint());
		}

		// Result
		return new DataResponse(['status' => 'success', 'data' => ['message' => 'Referral Sent']], Http::STATUS_OK);
	}

	private function doesUserExist($email){
		// Check if user already exists
		$existingUsers = $this->userManager->getByEmail($email);
		return !empty($existingUsers);
	}

	private function isValidReferral($email){
		// Check if user already exists
		if ($this->doesUserExist($email))
			return false;

		$invitedUser = $this->referralsService->findByEmail($email);
		if (isset($invitedUser) && $invitedUser->getStatus() == Referral::REFERRAL_SENT)
			return false;

		return true;
	}

	/**
	 * @NoCSRFRequired
	 * @PublicPage
	 *
	 * @param $token
	 * @return TemplateResponse
	 */
	public function followReferral($hash) {
		$referral = $this->referralsService->findByHash($hash);
		$userExists = $this->doesUserExist($referral->getReferreeEmail()) || $referral->getStatus() == Referral::REFERRAL_COMPLETE;

		// If user already exists (likely because this referral link has already been acted upon), notify the user with a message
		if ($userExists)
			return new TemplateResponse('registration', 'message', array('msg' => "User already exists, or referral link has already been used"), 'guest');

		try {
			/** @var Referral $referral */
			return new TemplateResponse('registration', 'form', ['email' => $referral->getReferreeEmail(), 'token' => $hash], 'guest');
		} catch (RegistrationException $exception) {
			return $this->renderError($exception->getMessage(), $exception->getHint());
		}
	}

	/**
	 * @NoCSRFRequired
	 * @PublicPage
	 *
	 * @param $token
	 * @return TemplateResponse
	 */
	public function createAccountFromReferral($hash) {
		$referral = $this->referralsService->findByHash($hash);
		$username = $this->request->getParam('username');
		$password = $this->request->getParam('password');
		$displayName = $this->request->getParam('displayname');

		$registration = new Registration();
		$registration->setEmail($referral->getReferreeEmail());
		$registration->setDisplayname($displayName);

		try {
			$this->registrationService->validateDisplayname($displayName);
			$user = $this->registrationService->createAccount($registration, $username, $password);
			$user->setDisplayName($displayName);
		} catch (\Exception $exception) {
			// Render form with previously sent values
			return new TemplateResponse('registration', 'form',
				[
					'email' => $registration->getEmail(),
					'entered_data' => array('user' => $username),
					'errormsgs' => array($exception->getMessage()),
					'token' => $hash
				], 'guest');
		}

		// UPDATE referral
		$this->referralsService->update($hash, Referral::REFERRAL_COMPLETE);

		if ($user->isEnabled()) {
			// log the user in
			return $this->registrationService->loginUser($user->getUID(), $username, $password, false, $hash);
		} else {
			// warn the user their account needs admin validation
			return new TemplateResponse(
				'registration',
				'message',
				array('msg' => "You're awesome! Welcome to your PixelDrive account.\r\n\r\nDue to demand, and to keep our service great, we're slowly rolling out new registrations. We'll approve your account within 24 hours and send you an email.\r\n\r\nAs an early adopter, you're gonna see something pretty cool in our platform.\r\n\r\nHold tight!"),
				'guest');
		}
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