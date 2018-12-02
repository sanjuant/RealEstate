<?php

namespace App\Repository;

use App\Entity\Property;
use App\Entity\PropertySearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Property|null find($id, $lockMode = null, $lockVersion = null)
 * @method Property|null findOneBy(array $criteria, array $orderBy = null)
 * @method Property[]    findAll()
 * @method Property[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertyRepository extends ServiceEntityRepository
{
	public function __construct(RegistryInterface $registry)
	{
		parent::__construct($registry, Property::class);
	}

	/**
	 * @param PropertySearch $search
	 * @return Query
	 */
	public function findAllVisibleQuery(PropertySearch $search): Query
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

		return $query->getQuery();
	}

	/**
	 * @return QueryBuilder
	 */
	private function findVisibleQuery(): QueryBuilder
	{
		return $this->createQueryBuilder('p')
					->where('p.sold = false');
	}

	/**
	 * @return Property[]
	 */
	public function findLatest(): array
	{
		return $this->findVisibleQuery()
					->setMaxResults(4)
					->getQuery()
					->getResult();
	}
}
