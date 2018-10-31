<?php
namespace OCA\Registration\Db;

use OCP\AppFramework\Db\DoesNotExistException;
use OCP\AppFramework\Db\Entity;
use OCP\AppFramework\Db\MultipleObjectsReturnedException;
use OCP\DB\QueryBuilder\IQueryBuilder;
use OCP\IDbConnection;
use OCP\AppFramework\Db\QBMapper;
use OCP\ILogger;

class ReferralMapper extends QBMapper {

	/** @var string */
	private $externalShareTable = 'referrals';

	public function __construct(IDbConnection $db) {
		parent::__construct($db, $this->externalShareTable, '\OCA\Registration\Db\Referral');
	}
	
	public function find($username, $referree_email) {
		try{
			$query = $this->db->getQueryBuilder();
			$query->select('*')->from($this->externalShareTable)
				->where($query->expr()->eq('referrer', $query->createNamedParameter($username, IQueryBuilder::PARAM_STR)))
				->andWhere($query->expr()->eq('referree_email', $query->createNamedParameter($referree_email, IQueryBuilder::PARAM_STR)));
			return $this->findEntity($query);
		} catch (DoesNotExistException $e) {
			\OC::$server->getLogger()->logException($e, [
				'message' => $e->getMessage(),
				'level' => ILogger::ERROR,
				'app' => 'registration',
			]);
		} catch (MultipleObjectsReturnedException $e) {
			\OC::$server->getLogger()->logException($e, [
				'message' => $e->getMessage(),
				'level' => ILogger::ERROR,
				'app' => 'registration',
			]);
		}
	}

	public function findAllForUser($username) {
		try{
			$query = $this->db->getQueryBuilder();
			$query->select('*')->from($this->externalShareTable)
				->where($query->expr()->eq('referrer', $query->createNamedParameter($username, IQueryBuilder::PARAM_STR)));
			return $this->findEntity($query);
		} catch (DoesNotExistException $e) {
			\OC::$server->getLogger()->logException($e, [
				'message' => $e->getMessage(),
				'level' => ILogger::ERROR,
				'app' => 'registration',
			]);
		} catch (MultipleObjectsReturnedException $e) {
			\OC::$server->getLogger()->logException($e, [
				'message' => $e->getMessage(),
				'level' => ILogger::ERROR,
				'app' => 'registration',
			]);
		}
	}

	public function findByHash($hash) {
		try{
			$query = $this->db->getQueryBuilder();
			$query->select('*')->from($this->externalShareTable)
				->where($query->expr()->eq('hash', $query->createNamedParameter($hash, IQueryBuilder::PARAM_STR)));
			return $this->findEntity($query);
		} catch (DoesNotExistException $e) {
			\OC::$server->getLogger()->logException($e, [
				'message' => $e->getMessage(),
				'level' => ILogger::ERROR,
				'app' => 'registration',
			]);
		} catch (MultipleObjectsReturnedException $e) {
			\OC::$server->getLogger()->logException($e, [
				'message' => $e->getMessage(),
				'level' => ILogger::ERROR,
				'app' => 'registration',
			]);
		}
	}

	public function findAll(): array {
		try{
			$query = $this->db->getQueryBuilder();
			$query->select('*')->from($this->externalShareTable);
			return $this->findEntities($query);
		} catch (DoesNotExistException $e) {
			\OC::$server->getLogger()->logException($e, [
				'message' => $e->getMessage(),
				'level' => ILogger::ERROR,
				'app' => 'registration',
			]);
		} catch (MultipleObjectsReturnedException $e) {
			\OC::$server->getLogger()->logException($e, [
				'message' => $e->getMessage(),
				'level' => ILogger::ERROR,
				'app' => 'registration',
			]);
		}
	}

	/**
	 * @param Entity $entity
	 * @return Entity
	 */
	public function insert(Entity $entity): Entity {
		$entity->setDateCreated(date('Y-m-d H:i:s'));
		$entity->setHash(md5($entity->getReferrer() . ':' . $entity->getReferreeEmail() . ':' . $entity->getDateCreated()));
		return parent::insert($entity);
	}
}