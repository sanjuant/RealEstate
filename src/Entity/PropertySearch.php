<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

class PropertySearch
{
	/**
	 * @var int|null
	 */
	private $maxPrice;

	/**
	 * @var int|null
	 * @Assert\Range(min=10, max=600)
	 */
	private $minSurface;

	/**
	 * @var ArrayCollection
	 */
	private $options;

	/**
	 * @var string|null
	 */
	private $location;

	/**
	 * @var integer|null
	 */
	private $distance;

	/**
	 * @var string|null
	 */
	private $city;

	/**
	 * @var string|null
	 */
	private $postal_code;

	/**
	 * @var float|null
	 */
	private $lat;

	/**
	 * @var float|null
	 */
	private $lng;

	public function __construct()
	{
		$this->options = new ArrayCollection();
	}

	/**
	 * @return int|null
	 */
	public function getMaxPrice(): ?int
	{
		return $this->maxPrice;
	}

	/**
	 * @param int|null $maxPrice
	 * @return PropertySearch
	 */
	public function setMaxPrice(int $maxPrice): PropertySearch
	{
		$this->maxPrice = $maxPrice;
		return $this;
	}

	/**
	 * @return int|null
	 */
	public function getMinSurface(): ?int
	{
		return $this->minSurface;
	}

	/**
	 * @param int|null $minSurface
	 * @return PropertySearch
	 */
	public function setMinSurface(int $minSurface): PropertySearch
	{
		$this->minSurface = $minSurface;
		return $this;
	}

	/**
	 * @return ArrayCollection
	 */
	public function getOptions(): ArrayCollection
	{
		return $this->options;
	}

	/**
	 * @param ArrayCollection $options
	 * @return PropertySearch
	 */
	public function setOptions(ArrayCollection $options): PropertySearch
	{
		$this->options = $options;
		return $this;
	}


	/**
	 * @return string|null
	 */
	public function getLocation(): ?string
	{
		return $this->location;
	}

	/**
	 * @param string|null $location
	 * @return PropertySearch
	 */
	public function setLocation(?string $location): PropertySearch
	{
		$this->location = $location;
		return $this;
	}

	/**
	 * @return int|null
	 */
	public function getDistance(): ?int
	{
		return $this->distance;
	}

	/**
	 * @param int|null $distance
	 * @return PropertySearch
	 */
	public function setDistance(?int $distance): PropertySearch
	{
		$this->distance = $distance;
		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getCity(): ?string
	{
		return $this->city;
	}

	/**
	 * @param string|null $city
	 * @return PropertySearch
	 */
	public function setCity(?string $city): PropertySearch
	{
		$this->city = $city;
		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getPostalCode(): ?string
	{
		return $this->postal_code;
	}

	/**
	 * @param string|null $postal_code
	 * @return PropertySearch
	 */
	public function setPostalCode(?string $postal_code): PropertySearch
	{
		$this->postal_code = $postal_code;
		return $this;
	}

	/**
	 * @return float|null
	 */
	public function getLat(): ?float
	{
		return $this->lat;
	}

	/**
	 * @param float|null $lat
	 * @return PropertySearch
	 */
	public function setLat(?float $lat): PropertySearch
	{
		$this->lat = $lat;
		return $this;
	}

	/**
	 * @return float|null
	 */
	public function getLng(): ?float
	{
		return $this->lng;
	}

	/**
	 * @param float|null $lng
	 * @return PropertySearch
	 */
	public function setLng(?float $lng): PropertySearch
	{
		$this->lng = $lng;
		return $this;
	}
}