<?php

namespace App\Controller\Admin;

use App\Constant\BookTypes;
use App\Constant\EBookFormats;
use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\HiddenField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\PercentField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            ChoiceField::new('type')
                ->setChoices(
                    BookTypes::toArray()
                ),
            MoneyField::new('price', 'Price')
                      ->setCurrency(Product::CURRENCY_CODE),
            PercentField::new('discountPercent', 'Discount Percent')
                        ->setStoredAsFractional(false),
            MoneyField::new('discountPrice', 'Discount Price')
                      ->setCurrency(Product::CURRENCY_CODE),
            IntegerField::new('salesCount', 'Paper Book Sales Count'),
            CollectionField::new('eBookFormats')
        ];
    }
}
