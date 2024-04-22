<?php

namespace App\Service\Book\DTOBuilder;

use App\DTO\ProductDTO;
use App\Entity\EBookFormat;
use App\Entity\Product;
use App\Service\Common\DTOValuesService;

class ProductBuilder
{
    public function build(Product $product): ProductDTO {
        return new ProductDTO(
            $product->getType(),
            DTOValuesService::formatPriceValue($product->getPrice()),
            DTOValuesService::formatPriceValue($product->getDiscountPrice()),
            $product->getDiscountPercent(),
            array_map(
                fn (EBookFormat $format) => strtoupper($format->getFormat()),
                $product->getEBookFormats()->getValues()
            )
        );
    }
}