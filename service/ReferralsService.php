<?php
namespace OCA\Registration\Service;

use Exception;

use OCP\AppFramework\Db\DoesNotExistException;
use OCP\AppFramework\Db\MultipleObjectsReturnedException;

use OCA\Registration\Db\Referral;
use OCA\Registration\Db\ReferralMapper;


class ReferralsService {

	private $mapper;

	public function __construct(ReferralMapper $mapper){
		$this->mapper = $mapper;
	}

	public function findAllForUser($username) {
		try {
			return $this->mapper->findAllForUser($username);
		} catch(Exception $e) {
			$this->handleException($e);
		}
	}

	public function findByEmail($email) {
		try {
			return $this->mapper->findByEmail($email);
		} catch(Exception $e) {
			$this->handleException($e);
		}
	}

	public function findByHash($hash) {
		try {
			return $this->mapper->findByHash($hash);
		} catch(Exception $e) {
			$this->handleException($e);
		}
	}

	public function find($username, $referree_email) {
		try {
			return $this->mapper->find($username, $referree_email);
		} catch(Exception $e) {
			$this->handleException($e);
		}
	}

	public function findAll(): array{
		try {
			return $this->mapper->findAll();
		} catch(Exception $e) {
			$this->handleException($e);
		}
	}

	private function handleException ($e) {
		if ($e instanceof DoesNotExistException ||
			$e instanceof MultipleObjectsReturnedException) {
			throw new NotFoundException($e->getMessage());
		} else {
			throw $e;
		}
	}

	public function insert($referrer, $referree_email, $status) {
		$r = new Referral();
		$r->setReferrer($referrer);
		$r->setReferreeEmail($referree_email);
		$r->setStatus($status);
		return $this->mapper->insert($r);
	}

	public function update($hash, $status) {
		try {
			$referral = $this->mapper->findByHash($hash);
			$referral->setStatus($status);
			return $this->mapper->update($referral);
		} catch(Exception $e) {
			$this->handleException($e);
		}
	}

	public function insertOrUpdate($referrer, $referree_email, $status){
		$r = $this->mapper->find($referrer, $referree_email);
		if (isset($r))
			return $this->update($r->getHash(), $status);
		return $this->insert($referrer, $referree_email, $status);
	}

	public function delete($hash) {
		try {
			$p = $this->mapper->findByHash($hash);
			$this->mapper->delete($p);
			return $p;
		} catch(Exception $e) {
			$this->handleException($e);
		}
	}
}