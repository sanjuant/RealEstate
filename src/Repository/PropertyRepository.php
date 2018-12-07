<?php

namespace App\Repository;

use App\Entity\Picture;
use App\Entity\Property;
use App\Entity\PropertySearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Property|null find($id, $lockMode = null, $lockVersion = null)
 * @method Property|null findOneBy(array $criteria, array $orderBy = null)
 * @method Property[]    findAll()
 * @method Property[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertyRepository extends ServiceEntityRepository
{
	/**
	 * @var PaginatorInterface
	 */
	private $paginator;

	/**
	 * PropertyRepository constructor.
	 * @param RegistryInterface $registry
	 * @param PaginatorInterface $paginator
	 */
	public function __construct(RegistryInterface $registry, PaginatorInterface $paginator)
	{
		parent::__construct($registry, Property::class);
		$this->paginator = $paginator;
	}

	/**
	 * @param PropertySearch $search
	 * @param int $page
	 * @return PaginationInterface
	 */
	public function paginateAllVisible(PropertySearch $search, int $page): PaginationInterface
	{
		$query = $this->findVisibleQuery();

		if ($search->getMaxPrice()) {
			$query = $query
				->andWhere('p.price <= :max_price')
				->setParameter('max_price', $search->getMaxPrice());
		}

		if ($search->getMinSurface()) {
			$query = $query
				->andWhere('p.surface >= :min_surface')
				->setParameter('min_surface', $search->getMinSurface());
		}

		// If distance is defined query on lat, lng and distance
		// else query on city and postal code if is defined
		if ($search->getDistance() && $search->getLat() && $search->getLng()) {
			$query = $query
				->select('p')
				->andWhere('(6353 * 2 * ASIN(SQRT( POWER(SIN((p.lat - :lat) *  pi()/180 / 2), 2) +COS(p.lat * pi()/180) * COS(:lat * pi()/180) * POWER(SIN((p.lng -:lng) * pi()/180 / 2), 2) ))) <= :distance')
				->setParameter('lng', $search->getLng())
				->setParameter('lat', $search->getLat())
				->setParameter('distance', $search->getDistance());
		} else {
			if ($search->getCity() && $search->getCity() !== 'undefined') {
				$query = $query
					->andWhere('p.city = :city')
					->setParameter('city', $search->getCity());
			}

			if ($search->getPostalCode()) {
				$query = $query
					->andWhere('p.postal_code = :postal_code')
					->setParameter('postal_code', $search->getPostalCode());
			}
		}

		if ($search->getOptions()) {
			$k = 0;
			foreach ($search->getOptions() as $option) {
				$k++;
				$query = $query
					->andWhere(":option$k MEMBER OF p.options")
					->setParameter("option$k", $option);
			}
		}

		$properties = $this->paginator->paginate(
			$query->getQuery(),
			$page,
			12
		);

		$this->hydratePicture($properties);

		return $properties;
	}

	/**
	 * @return QueryBuilder
	 */
	private function findVisibleQuery(): QueryBuilder
	{
		return $this->createQueryBuilder('p')
					->where('p.sold = false');
	}

	private function hydratePicture($properties): void
	{
		if (method_exists($properties, 'getItems')) {
			$properties = $properties->getItems();
		}
		$pictures = $this->getEntityManager()
						 ->getRepository(Picture::class)
						 ->findForProperties($properties);

		foreach ($properties as $property) {
			/** @var $property Property */
			if ($pictures->containsKey($property->getId())) {
				$property->setPicture($pictures->get($property->getId()));
			}
		}
	}

	/**
	 * @return Property[]
	 */
	public function findLatest(): array
	{
		$properties = $this->findVisibleQuery()
						   ->setMaxResults(4)
						   ->getQuery()
						   ->getResult();
		$this->hydratePicture($properties);
		return $properties;
	}
}
