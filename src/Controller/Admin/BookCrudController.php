<?php

namespace App\Controller\Admin;

use App\Constant\BookTypes;
use App\Entity\Book;
use App\Entity\EBookFormat;
use App\Entity\Product;
use App\Form\Admin\Type\ProductFormType;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\LanguageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\DateTimeFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\NumericFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\String\Slugger\AsciiSlugger;

class BookCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Book::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addTab('General Information'),
            FormField::addColumn(8),
            TextField::new('title'),
            IntegerField::new('generalSalesCount', 'General Sales Count')->hideOnForm(),
            IntegerField::new('stockCount'),
            TextField::new('translator')->hideOnIndex(),
            LanguageField::new('language'),
            TextEditorField::new('description')->hideOnIndex(),
            DateTimeField::new('createdAt')->onlyOnDetail(),
            DateTimeField::new('updatedAt')->onlyOnDetail(),

            FormField::addColumn(4),
            AssociationField::new('author'),
            AssociationField::new('publisher'),
            AssociationField::new('category')->onlyOnForms(),
            CollectionField::new('category')
                           ->formatValue(
                               function ($value, $entity) {
                                   $categories    = $entity->getCategory();
                                   $categoryNames = [];

                                   foreach ($categories as $category) {
                                       $url = $this->container->get(AdminUrlGenerator::class)
                                                              ->setController(CategoryCrudController::class)
                                                              ->setAction(Action::DETAIL)
                                                              ->setEntityId($category->getSlug())
                                                              ->generateUrl();

                                       $categoryNames[] = '<a href="' . $url . '">' . $category->getName() . '</a>';
                                   }

                                   return implode(', ', $categoryNames);
                               })->hideOnForm(),
            TextField::new('coverUrl')->hideOnIndex(),

            FormField::addTab('Paper Book Information'),
            NumberField::new('width')->hideOnIndex(),
            NumberField::new('height')->hideOnIndex(),
            BooleanField::new('illustration')->hideOnIndex(),
            BooleanField::new('isSoftCover')->hideOnIndex(),
            IntegerField::new('pageCount')->hideOnIndex(),
            IntegerField::new('publishedYear')->hideOnIndex(),

            FormField::addTab('Options For Sale'),
            CollectionField::new('products')->hideOnIndex()
                           ->setFormTypeOption('entry_options', ['by_reference' => true])
                           ->setEntryType(ProductFormType::class)
                           ->formatValue(
                               function ($value, $entity) {
                                   $products    = $entity->getProducts();
                                   $productData = [];

                                   /** @var Product $product */
                                   foreach ($products as $product) {
                                       $productData[] = sprintf(
                                               '</br>%s, price: %s, discount: %s, discountPrice: %s',
                                               $product,
                                               $product->getPrice(),
                                               $product->getDiscountPercent(),
                                               $product->getDiscountPrice(),
                                           ) . (
                                           $product->getType() === BookTypes::ELECTRONIC->value
                                               ? sprintf(
                                               ', formats: [%s]', implode(
                                               ', ',
                                               array_map(
                                                   function (EBookFormat $value) {
                                                       return strtoupper($value->getFormat());
                                                   },
                                                   $product->getEBookFormats()->getValues(),
                                               ),
                                           ))
                                               : ''
                                           );
                                   }

                                   return implode(', ', $productData);
                               },
                           ),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(TextFilter::new('title'))
            ->add(EntityFilter::new('author'))
            ->add(EntityFilter::new('publisher'))
            ->add(EntityFilter::new('category'))
            ->add(NumericFilter::new('stockCount'))
            ->add(DateTimeFilter::new('createdAt'));
    }

    public function configureCrud(Crud $crud): Crud
    {
        return parent::configureCrud($crud)
                     ->hideNullValues();
    }

    public function configureAssets(Assets $assets): Assets
    {
        return $assets
            ->addWebpackEncoreEntry('bookProduct');
    }

    private function persistAllStuff(EntityManagerInterface $entityManager, Book $book): void
    {
        $products = $book->getProducts();

        foreach ($products as $product) {
            foreach ($product->getEBookFormats() as $format) {
                $entityManager->persist($format);
            }

            $entityManager->persist($product);
        }

        $entityManager->persist($book);
        $entityManager->flush();
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $this->persistAllStuff($entityManager, $entityInstance);
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $this->persistAllStuff($entityManager, $entityInstance);
    }
}
