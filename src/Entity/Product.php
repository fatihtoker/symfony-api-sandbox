<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 * 
 * @Vich\Uploadable
 *
 * @Serializer\ExclusionPolicy("all")
 */
class Product
{
    use TimestampableEntity;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Serializer\Expose()
     * @Serializer\Groups({"Default", "products_list", "product_category"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Serializer\Expose()
     * @Serializer\Groups({"Default", "products_list", "product_category"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=520, nullable=true)
     * @Serializer\Expose()
     * @Serializer\Groups({"Default", "products_list"})
     */
    private $description;

    /**
     * @ORM\Column(type="boolean")
     * @Serializer\Expose()
     * @Serializer\Groups({"Default", "products_list"})
     */
    private $onSale;

    /**
     * @ORM\Column(type="integer")
     * @Serializer\Expose()
     * @Serializer\Groups({"Default", "products_list", "product_category"})
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Parameter")
     * @ORM\JoinColumn(nullable=false)
     * @Serializer\Expose()
     * @Serializer\Groups({"Default", "products_list"})
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Parameter")
     * @ORM\JoinColumn(nullable=true)
     * @Serializer\Expose()
     * @Serializer\Groups({"Default"})
     */
    private $type;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="product_image", fileNameProperty="imageName", size="imageSize")
     * 
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     * @Serializer\Expose()
     * @Serializer\Groups({"Default", "products_list"})
     *
     * @var string
     */
    private $imageName;

    /**
     * @ORM\Column(type="integer")
     *
     * @var integer
     */
    private $imageSize;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }
    
    public function setImageSize(?int $imageSize): void
    {
        $this->imageSize = $imageSize;
    }

    public function getImageSize(): ?int
    {
        return $this->imageSize;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getOnSale(): ?bool
    {
        return $this->onSale;
    }

    public function setOnSale(bool $onSale): self
    {
        $this->onSale = $onSale;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCategory(): ?Parameter
    {
        return $this->category;
    }

    public function setCategory(?Parameter $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getType(): ?Parameter
    {
        return $this->type;
    }

    public function setType(?Parameter $type): self
    {
        $this->type = $type;

        return $this;
    }
}
